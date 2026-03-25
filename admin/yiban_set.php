<?php
include("../includes/common.php");
$title='易班网薪业务设置';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="col-sm-12 col-md-10 center-block" style="float: none;">
<?php
if(isset($_POST['submit'])) {
    $config_data = [
        'yiban_api_url' => $_POST['yiban_api_url'],
        'yiban_api_key' => $_POST['yiban_api_key'],
        'yiban_tid_1000' => $_POST['yiban_tid_1000'],
        'yiban_tid_4000' => $_POST['yiban_tid_4000']
    ];
    foreach ($config_data as $key => $value) {
        saveSetting($key, $value);
    }
    $CACHE->clear();
    showmsg('修改成功！',1);
}
?>
<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title">易班网薪业务对接设置</h3></div>
    <div class="panel-body">
        <form action="./yiban_set.php" method="post" class="form-horizontal" role="form">
            <div class="form-group">
                <label class="col-sm-2 control-label">第三方API地址</label>
                <div class="col-sm-10">
                    <input type="text" name="yiban_api_url" value="<?php echo $conf['yiban_api_url']; ?>" class="form-control" placeholder="例如 http://127.0.0.1:8080 (不带结尾斜杠)"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">安全密钥(Security)</label>
                <div class="col-sm-10">
                    <input type="text" name="yiban_api_key" value="<?php echo $conf['yiban_api_key']; ?>" class="form-control" placeholder="API接口的security路径参数"/>
                </div>
            </div>
            <hr/>
            <div class="alert alert-info">
                请先在<a href="./shoplist.php" target="_blank">商品列表</a>中添加两个商品分别对应1000和4000网薪，并设置好三级价格。然后将商品ID填入下方。
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">1000网薪关联商品ID</label>
                <div class="col-sm-10">
                    <input type="text" name="yiban_tid_1000" value="<?php echo $conf['yiban_tid_1000']; ?>" class="form-control" placeholder="填写商品TID"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">4000网薪关联商品ID</label>
                <div class="col-sm-10">
                    <input type="text" name="yiban_tid_4000" value="<?php echo $conf['yiban_tid_4000']; ?>" class="form-control" placeholder="填写商品TID"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" name="submit" value="保存修改" class="btn btn-primary form-control"/>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default")||0);
}
</script>
<?php include './foot.php';?>
