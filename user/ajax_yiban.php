<?php
// 禁止错误输出破坏 JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

// 引入公共文件（鉴权）
include '../includes/common.php';
if($islogin2!=1){
    exit(json_encode(array('code'=>-1, 'msg'=>'未登录')));
}

// 确保 date 变量存在
if(!isset($date)) $date = date("Y-m-d H:i:s");

// 确定当前站点的 ZID (Site ID)
// 如果是分站长登录，siterow 可能未自动设置，需要手动覆盖
if($userrow['power']>0){
    $siterow = $userrow;
}
// 获取站点ID，如果未定义（如主站）则默认为 1
$site_zid = isset($siterow['zid']) ? $siterow['zid'] : 1;


// 读取后台配置
$api_host = isset($conf['yiban_api_url']) ? $conf['yiban_api_url'] : 'http://127.0.0.1:8080';
$api_security = isset($conf['yiban_api_key']) ? $conf['yiban_api_key'] : 'security';
$tid_1000 = isset($conf['yiban_tid_1000']) ? intval($conf['yiban_tid_1000']) : 0;
$tid_4000 = isset($conf['yiban_tid_4000']) ? intval($conf['yiban_tid_4000']) : 0;

// 初始化价格对象
$price_obj = new \lib\Price($userrow['zid'], $userrow);

// 辅助函数：使用系统逻辑获取商品价格
function get_system_price($tid) {
    global $DB, $price_obj;
    if ($tid <= 0) return false;
    
    $tool = $DB->getRow("SELECT * FROM pre_tools WHERE tid='$tid' LIMIT 1");
    if (!$tool) return false;
    
    $price_obj->setToolInfo($tid, $tool);
    if($price_obj->getToolDel($tid)==1) return false;
    
    $price = $price_obj->getToolPrice($tid);
    
    return array(
        'price' => $price,
        'name' => $tool['name'],
        'tid' => $tid
    );
}

$act = isset($_GET['act']) ? $_GET['act'] : '';

/**
 * 请求第三方接口获取账号订单数据
 */
function fetch_remote_order_data($account) {
    global $api_host, $api_security;
    $query_url = rtrim($api_host, '/') . '/getByAccount/' . $account . '/' . $api_security;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $query_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 200 && $response) {
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return array('success' => false, 'msg' => 'API返回格式错误: ' . substr($response, 0, 100));
        }
        return array('success' => true, 'data' => $data);
    } elseif ($http_code == 404) {
        return array('success' => true, 'data' => array());
    } else {
        return array('success' => false, 'msg' => '查询失败，HTTP状态码: ' . $http_code);
    }
}

function normalize_api_data($data, $account = '') {
    $list = array();
    if (empty($data) || !is_array($data)) return $list;
    $is_assoc = array_keys($data) !== range(0, count($data) - 1);

    if ($is_assoc) {
        if (!isset($data['account']) || !$data['account']) $data['account'] = $account;
        $list[] = $data;
    } else {
        foreach ($data as $item) {
            if (!is_array($item)) continue;
            if (!isset($item['account']) || !$item['account']) $item['account'] = $account;
            $list[] = $item;
        }
    }
    return $list;
}

// 1. 获取价格信息
if ($act === 'get_price') {
    $moneyTarget = isset($_POST['moneyTarget']) ? intval($_POST['moneyTarget']) : 0;
    
    $target_tid = 0;
    if ($moneyTarget == 1000) $target_tid = $tid_1000;
    elseif ($moneyTarget == 4000) $target_tid = $tid_4000;
    
    if ($target_tid == 0) {
        exit(json_encode(array('code'=>-1, 'msg'=>'后台未配置该任务对应的商品ID')));
    }
    
    $tool_info = get_system_price($target_tid);
    if (!$tool_info) {
        exit(json_encode(array('code'=>-1, 'msg'=>'商品不存在或已下架')));
    }
    
    exit(json_encode(array(
        'code' => 0,
        'price' => $tool_info['price'],
        'balance' => $userrow['rmb'],
        'is_enough' => ($userrow['rmb'] >= $tool_info['price'])
    )));
}

// 3. 查询订单
if ($act === 'query_order') {
    $account = isset($_GET['account']) ? trim($_GET['account']) : '';
    if (!$account) {
        exit(json_encode(array('code' => -1, 'msg' => '请输入账号')));
    }

    $result = fetch_remote_order_data($account);
    if ($result['success']) {
        exit(json_encode(array('code' => 0, 'data' => $result['data'])));
    } else {
        exit(json_encode(array('code' => -1, 'msg' => $result['msg'])));
    }
}

// 3.1 查询当前用户所有账号订单
if ($act === 'query_all_orders') {
    $valid_tids = array();
    if ($tid_1000 > 0) $valid_tids[] = $tid_1000;
    if ($tid_4000 > 0) $valid_tids[] = $tid_4000;
    
    $tid_sql = '';
    if (count($valid_tids) > 0) {
        $tid_sql = " AND tid IN (" . implode(',', $valid_tids) . ")";
    }

    $accounts = array();
    // 获取所有订单的账号（不去重，保留所有记录）
    $rs = $DB->query("SELECT DISTINCT input FROM pre_orders WHERE userid='{$userrow['zid']}' {$tid_sql} AND input<>'' ORDER BY id DESC LIMIT 50");
    while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($row['input'])) $accounts[] = $row['input'];
    }

    if (empty($accounts)) {
        exit(json_encode(array('code' => 0, 'data' => array(), 'msg' => '暂无账号记录')));
    }

    $all_data = array();
    foreach ($accounts as $account) {
        $res = fetch_remote_order_data($account);
        if ($res['success']) {
            $list = normalize_api_data($res['data'], $account);
            $all_data = array_merge($all_data, $list);
        }
    }

    exit(json_encode(array('code' => 0, 'data' => $all_data, 'accounts' => $accounts)));
}

// 2. 提交订单
if ($act === 'submit_order') {
    $account = isset($_POST['account']) ? trim($_POST['account']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $cookie = isset($_POST['cookie']) ? trim($_POST['cookie']) : '';
    $userAgent = isset($_POST['userAgent']) ? trim($_POST['userAgent']) : '';
    $moneyTarget = isset($_POST['moneyTarget']) ? intval($_POST['moneyTarget']) : 0;

    if (!$account || !$password || !$cookie || !$moneyTarget) {
        exit(json_encode(array('code' => -1, 'msg' => '请填写完整信息')));
    }
    
    // 确定 TID
    $target_tid = 0;
    if ($moneyTarget == 1000) $target_tid = $tid_1000;
    elseif ($moneyTarget == 4000) $target_tid = $tid_4000;
    
    if ($target_tid == 0) exit(json_encode(array('code'=>-1, 'msg'=>'未配置商品ID')));
    
    // 获取价格
    $tool_info = get_system_price($target_tid);
    if (!$tool_info) exit(json_encode(array('code'=>-1, 'msg'=>'商品无效')));
    
    $cost = $tool_info['price'];
    
    // 检查余额
    if ($userrow['rmb'] < $cost) {
        exit(json_encode(array('code'=>-1, 'msg'=>'余额不足，请充值！')));
    }

    // 构造 POST 数据
    $post_data = array(
        'id' => 0, // 根据 API 要求补充 id 字段
        'account' => $account,
        'password' => $password,
        'cookie' => $cookie,
        'userAgent' => $userAgent,
        'moneyTarget' => $moneyTarget
    );

    // 1. 扣费 (先扣费，失败再退款)
    if ($cost > 0) {
        // 使用 exec 方法，pre_site 表名前缀由 PdoHelper 处理
        $DB->exec("UPDATE pre_site SET rmb=rmb-:cost WHERE zid=:zid", array(':cost'=>$cost, ':zid'=>$userrow['zid']));
        addPointRecord($userrow['zid'], $cost, '消费', '购买 '.$tool_info['name']);
    }

    // 2. 请求第三方 API
    // 构造 API 地址: host + /insert/ + security
    $api_url = rtrim($api_host, '/') . '/insert/' . $api_security;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8'
    ));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    // 判断结果: 返回 "0" 或 纯数字ID 均视为成功
    $api_success = false;
    $api_msg = '';

    // 移除响应可能包含的空白字符
    $clean_response = trim($response);

    // 成功判断逻辑：HTTP 200 且 (返回内容是 '0' 或 是一串数字ID)
    if ($http_code == 200 && (ctype_digit($clean_response) || is_numeric($clean_response))) {
        $api_success = true;
    } else {
        // 尝试解析 JSON 错误信息
        $res_json = json_decode($response, true);
        if (is_array($res_json) && isset($res_json['msg'])) {
            $api_msg = $res_json['msg'];
        } else {
            $api_msg = $response ? substr($response, 0, 200) : 'API请求失败(HTTP '.$http_code.')';
        }
        if ($curl_error) $api_msg = 'Curl错误: ' . $curl_error;
    }

    if (!$api_success) {
        // 失败退款
        if ($cost > 0) {
            $DB->exec("UPDATE pre_site SET rmb=rmb+:cost WHERE zid=:zid", array(':cost'=>$cost, ':zid'=>$userrow['zid']));
            addPointRecord($userrow['zid'], $cost, '退款', '任务提交失败退款');
        }
        exit(json_encode(array('code' => -2, 'msg' => '提交失败: ' . $api_msg)));
    }

    // 3. 写入订单表
    $tradeno = date("YmdHis").rand(111,999);
    $status = 1; 
    
    // 使用 PdoHelper 的 insert 方法
    $res = $DB->insert('orders', array(
        'tradeno' => $tradeno,
        'tid' => $target_tid,
        'zid' => $site_zid,        // 站点ID (订单所属站点)
        'userid' => $userrow['zid'], // 用户ID (下单用户)
        'value' => 1,
        'money' => $cost,
        'addtime' => $date,
        'status' => $status,
        'input' => $account,       // 账号
        'input2' => $password,     // 密码
        'input3' => $cookie,       // Cookie
        'input4' => $userAgent     // UA
    ));

    if ($res) {
        exit(json_encode(array(
            'code' => 0, 
            'msg' => '下单成功！',
            'balance' => round($userrow['rmb'] - $cost, 2)
        )));
    } else {
        // 写入订单失败，可能需要记录日志或退款（暂不处理退款以免复杂化，通常写库不会失败）
        exit(json_encode(array('code' => -3, 'msg' => '订单写入失败: ' . $DB->error())));
    }
}
?>