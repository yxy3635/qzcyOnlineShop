<?php
$is_defend=true;
require '../includes/common.php';
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$title = '易班网薪下单';

// 读取易班商品配置
$tid_1000 = isset($conf['yiban_tid_1000']) ? intval($conf['yiban_tid_1000']) : 0;
$tid_4000 = isset($conf['yiban_tid_4000']) ? intval($conf['yiban_tid_4000']) : 0;

// 初始化价格对象
$price_obj = new \lib\Price($userrow['zid'], $userrow);

/**
 * 根据 tid 获取系统售价
 */
function fetch_plan_price($tid, $price_obj, $DB) {
    if ($tid <= 0) return null;
    $tool = $DB->getRow("SELECT * FROM pre_tools WHERE tid='$tid' LIMIT 1");
    if(!$tool) return null;
    $price_obj->setToolInfo($tid, $tool);
    if($price_obj->getToolDel($tid)==1) return null;
    return $price_obj->getToolPrice($tid);
}

$plan_prices = array(
    '1000' => fetch_plan_price($tid_1000, $price_obj, $DB),
    '4000' => fetch_plan_price($tid_4000, $price_obj, $DB)
);

include 'head.php';
?>
<style>
.order-card { border: 2px solid #e2e8f0; background: #fff; border-radius: 12px; padding: 20px; cursor: pointer; transition: all 0.3s; text-align: center; position: relative; overflow: hidden; }
.order-card:hover { border-color: #667eea; transform: translateY(-2px); box-shadow: 0 10px 25px rgba(102,126,234,0.1); }
.order-card.selected { border-color: #667eea; background: #f0f4ff; }
.order-card.selected::after { content: '\f00c'; font-family: FontAwesome; position: absolute; bottom: 0; right: 0; background: #667eea; color: #fff; padding: 2px 8px; border-top-left-radius: 10px; font-size: 12px; }
.order-card h3 { margin: 5px 0; font-weight: 700; color: #2d3748; }
.order-card p { margin: 0; font-size: 13px; color: #718096; }
.help-block { font-size: 12px; color: #a0aec0; margin-top: 4px; }
.completed-row { animation: pulse 2s infinite; }
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.95; }
}
</style>

<div class="wrapper">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- 顶部公告栏 -->
            <div class="alert alert-warning alert-dismissible" role="alert" style="border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><i class="fa fa-bullhorn"></i> 公告：</strong> 欢迎使用易班网薪任务平台，请务必填写真实有效的账号密码信息，否则任务无法进行。
            </div>

			<div class="alert alert-warning alert-dismissible" role="alert" style="border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><i class="fa fa-bullhorn"></i> 注意事项：</strong> 请先进行订单提交 提交完成之后进入网址：https://yb.saigou.work/login/ 进行登录 <a href="https://yb.saigou.work/login/">点击跳转</a> 然后在下方查询订单是否有记录，有记录才说明提交成功！！
            </div>

            <div class="panel panel-default">
                <div class="panel-heading font-bold">
                    <i class="fa fa-paper-plane-o"></i> 提交网薪任务
                </div>
                <div class="panel-body wrapper-lg">
                    <form class="form-horizontal" id="orderForm">
                        
                        <!-- 账号信息 -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">易班账号</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="account" placeholder="请输入手机号/易班ID" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">易班密码</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" placeholder="请输入登录密码" required>
                            </div>
                        </div>

                        <!-- 任务选择 -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">选择任务</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="order-card" onclick="selectPlan(1000, this)">
                                            <h3>1000 网薪</h3>
                                            <p>预计七--八天天完成</p>
                                            <p class="plan-price" id="price-1000">
                                                <?php if($plan_prices['1000'] !== null){ ?>
                                                    当前价格：<?php echo $plan_prices['1000']; ?> 元
                                                <?php } else { ?>
                                                    价格暂不可用
                                                <?php } ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="order-card" onclick="selectPlan(4000, this)">
                                            <h3>4000 网薪</h3>
                                            <p>预计一月完成</p>
                                            <p class="plan-price" id="price-4000">
                                                <?php if($plan_prices['4000'] !== null){ ?>
                                                    当前价格：<?php echo $plan_prices['4000']; ?> 元
                                                <?php } else { ?>
                                                    价格暂不可用
                                                <?php } ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="moneyTarget" id="moneyTarget" required>
                            </div>
                        </div>

                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-2">
                                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="checkPrice()">
                                    立即提交任务
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="alert alert-info">
                <strong><i class="fa fa-info-circle"></i> 说明：</strong><br>
                1. 请确保填写的账号密码真实有效。<br>
                2. 提交后系统会自动扣费，如下单失败会自动退款。<br>
                3. 如果提交的账号或密码错误，联系上级或客提交工单申请退款即可。<br>
                4. 中途改密码不支持退款！<br>
                <font color="blue">5. 一号一单，续费请在当前任务完成之后再续费！</font>
            </div>
            
            <!-- 查询订单部分 -->
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-heading font-bold">
                    <i class="fa fa-search"></i> 查询账号订单状态
                </div>
                <div class="panel-body wrapper-lg">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="query_account" class="form-control" placeholder="请输入易班账号查询">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" onclick="queryOrder()">查询</button>
                            </span>
                        </div>
                    </div>
                    <div id="query_result" style="display:none; margin-top: 15px; background: #f9f9f9; padding: 15px; border-radius: 4px; border: 1px solid #eee;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 下单注意事项弹窗 -->
    <div class="modal fade" id="orderNoticeModal" tabindex="-1" role="dialog" aria-labelledby="orderNoticeLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="orderNoticeLabel"><i class="fa fa-exclamation-circle text-warning"></i> 下单提示</h4>
                </div>
                <div class="modal-body" style="line-height:1.8;font-size:14px;">
                    下单请仔细阅读注意事项，务必确认账号信息与操作指引，以免影响任务进度。
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">我已知晓</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 脚本移入 wrapper 内部，确保 PJAX 加载时能执行 -->
    <script>
    var priceCache = <?php echo json_encode(array_filter($plan_prices, function($price){
        return $price !== null;
    }), JSON_UNESCAPED_UNICODE); ?> || {}; // 用于缓存套餐价格，避免重复请求
    
    // 选择套餐
    function selectPlan(amount, elem) {
        $('.order-card').removeClass('selected');
        $(elem).addClass('selected');
        $('#moneyTarget').val(amount);
    }

    // 1. 检查价格并确认
    function checkPrice() {
        var moneyTarget = $('#moneyTarget').val();
        
        // 基础校验
        if(!$('input[name="account"]').val() || !$('input[name="password"]').val() || !moneyTarget) {
            layer.msg('请填写完整信息');
            return;
        }
        
        var load = layer.load(2);
        
        // 请求后端获取价格和余额
        $.post('ajax_yiban.php?act=get_price', {moneyTarget: moneyTarget}, function(res){
            layer.close(load);
            if(res.code === 0) {
                priceCache[moneyTarget] = res.price;
                var content = '<div style="padding:20px;font-size:16px;line-height:2;">';
                content += '任务类型：<b>' + moneyTarget + ' 网薪</b><br>';
                content += '需要支付：<b style="color:red">' + res.price + ' 元</b><br>';
                content += '当前余额：<b style="color:green">' + res.balance + ' 元</b><br>';
                
                if(!res.is_enough) {
                    content += '<br><span style="color:red;font-weight:bold;">余额不足，请先充值！</span>';
                    layer.alert(content, {title: '余额不足', icon: 2});
                } else {
                    content += '</div>';
                    layer.confirm(content, {
                        title: '订单确认',
                        btn: ['确认支付', '取消']
                    }, function(){
                        submitOrder();
                    });
                }
            } else {
                layer.alert(res.msg, {icon: 2});
            }
        }, 'json').fail(function(){
            layer.close(load);
            layer.msg('获取价格失败');
        });
    }

    // 2. 真正提交订单
    function submitOrder() {
        var data = {
            account: $('input[name="account"]').val(),
            password: $('input[name="password"]').val(),
            cookie: '""',
            userAgent: '""',
            moneyTarget: $('#moneyTarget').val()
        };
        
        var load = layer.load(2, {shade: [0.3, '#fff'], content: '正在提交...', success: function(layero){
            layero.find('.layui-layer-content').css({'padding-top': '40px', 'width': '100px'});
        }});
        
        $.post('ajax_yiban.php?act=submit_order', data, function(res){
            layer.close(load);
            if(res.code === 0) {
                layer.alert('任务提交成功！<br>扣除余额：' + (res.balance ? '剩余 '+res.balance+'元' : ''), {icon: 1}, function(){
                    location.reload(); 
                });
            } else {
                layer.alert(res.msg || '提交失败', {icon: 2});
            }
        }, 'json').fail(function(){
            layer.close(load);
            layer.msg('网络请求失败，请稍后重试');
        });
    }

    function normalizeOrderList(data) {
        if(!data) return [];
        if(Array.isArray(data)) return data;
        if(typeof data === 'object') return [data];
        return [];
    }

    function buildOrderTable(list) {
        var html = '<div class="table-responsive"><table class="table table-striped table-hover table-bordered" style="background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 5px rgba(0,0,0,0.05);margin-bottom:0;">';
        html += '<thead><tr style="background:#f5f7fa;color:#666;">';
        html += '<th style="text-align:center;">账号</th>';
        html += '<th style="text-align:center;">密码</th>';
        html += '<th style="text-align:center;">下单额度</th>';
        html += '<th style="text-align:center;">已完成</th>';
        html += '<th style="text-align:center;">上次新增</th>';
        html += '<th style="text-align:center;">订单状态</th>';
        html += '<th style="text-align:center;">更新时间</th>';
        html += '</tr></thead><tbody>';

        list.forEach(function(item){
            // 判断是否已完成：已完成 >= 下单额度
            var moneyCompleted = parseFloat(item.moneyCompleted || 0);
            var moneyTarget = parseFloat(item.moneyTarget || 0);
            var isCompleted = moneyCompleted >= moneyTarget && moneyTarget > 0;
            
            // 已完成的行添加特殊样式
            var rowStyle = '';
            var rowClass = '';
            if (isCompleted) {
                rowStyle = 'background: linear-gradient(90deg, #d4edda 0%, #c3e6cb 100%); border-left: 4px solid #28a745;';
                rowClass = 'completed-row';
            }
            
            html += '<tr class="' + rowClass + '" style="' + rowStyle + '">';
            html += '<td style="text-align:center;font-weight:bold;color:#333;">' + (item.account || '-') + '</td>';
            html += '<td style="text-align:center;font-weight:bold;color:#333;">' + (item.password || '-') + '</td>';
            html += '<td style="text-align:center;"><span class="label label-primary">' + (item.moneyTarget || 0) + '</span></td>';
            
            // 已完成列只显示数字，不显示标签
            html += '<td style="text-align:center;color:green;font-weight:bold;">' + (item.moneyCompleted || 0) + '</td>';
            
            var todayAdd = item.moneyAdd || 0;
            var addStyle = todayAdd > 0 ? 'color:red;font-weight:bold;' : 'color:#999;';
            var addText = todayAdd > 0 ? '+' + todayAdd : todayAdd;
            html += '<td style="text-align:center;' + addStyle + '">' + addText + '</td>';
            
            // 订单状态列：如果已完成，显示"已完成"标记，否则显示原来的remark
            var remarkText = '';
            var remarkStyle = '';
            if (isCompleted) {
                remarkText = '<span class="label label-success"><i class="fa fa-check-circle"></i> 已完成</span>';
                remarkStyle = 'color:green;font-weight:bold;';
            } else {
                remarkStyle = item.remark == "normal" ?  'color:green;' : 'color:red;';
                if (item.remark == "正在执行任务") remarkStyle = 'color:blue;';
                remarkText = item.remark || '暂未数据';
            }
            html += '<td style="text-align:center;' + remarkStyle + 'font-size:12px;">' + remarkText + '</td>';
            html += '<td style="text-align:center;color:#666;font-size:12px;">' + (item.updateTime || '-') + '</td>';
            html += '</tr>';
        });

        html += '</tbody></table></div>';
        return html;
    }

    function renderOrderResult(data, emptyText) {
        var container = $('#query_result');
        container.show();
        var list = normalizeOrderList(data);
        if(list.length > 0) {
            container.html(buildOrderTable(list));
        } else {
            container.html('<div class="text-center text-muted" style="padding: 20px;">' + (emptyText || '暂无账号信息，请先下单！') + '</div>');
        }
    }
    // 3. 查询单个账号订单
    function queryOrder() {
        var account = $('#query_account').val();
        if(!account) {
            layer.msg('请输入易班账号');
            return;
        }
        
        var load = layer.load(2);
        $.get('ajax_yiban.php?act=query_order&account=' + account, function(res){
            layer.close(load);
            if(res.code === 0) {
                renderOrderResult(res.data);
            } else {
                layer.alert(res.msg, {icon: 2});
            }
        }, 'json').fail(function(){
            layer.close(load);
            layer.msg('查询失败');
        });
    }

    // 3.1 自动查询当前用户全部账号
    function loadAllOrders() {
        var container = $('#query_result');
        container.show().html('<div class="text-center text-muted" style="padding: 20px;">正在加载账号订单...</div>');
        $.get('ajax_yiban.php?act=query_all_orders', function(res){
            if(res.code === 0) {
                renderOrderResult(res.data, '暂无账号信息，请先下单！');
            } else {
                container.html('<div class="text-center text-danger" style="padding: 20px;">' + (res.msg || '加载失败') + '</div>');
            }
        }, 'json').fail(function(){
            container.html('<div class="text-center text-danger" style="padding: 20px;">加载失败，请稍后重试</div>');
        });
    }
    
    // 初始化函数 - 确保 PJAX 加载后也能执行
    function initYibanPage() {
        // 确保 jQuery 和 Bootstrap 已加载
        if(typeof $ === 'undefined' || typeof $.fn.modal === 'undefined') {
            setTimeout(initYibanPage, 100);
            return;
        }
        
        // 页面加载后弹出注意事项
        var $modal = $('#orderNoticeModal');
        if($modal.length > 0) {
            $modal.modal('show');
        }
        
        // 加载所有订单
        loadAllOrders();
    }
    
    // 立即执行初始化（适用于首次加载和 PJAX 加载）
    (function() {
        if(typeof $ !== 'undefined' && $.fn) {
            // jQuery 已加载，检查 DOM 状态
            if(document.readyState === 'loading') {
                $(document).ready(initYibanPage);
            } else {
                // DOM 已准备好，延迟执行确保元素已渲染
                setTimeout(initYibanPage, 150);
            }
        } else {
            // jQuery 未加载，等待
            setTimeout(arguments.callee, 50);
        }
    })();
    
    // 监听 PJAX 完成事件（如果存在）
    $(document).on('pjax:success', function() {
        setTimeout(initYibanPage, 100);
    });
    </script>
</div>

<?php include './foot.php';?>