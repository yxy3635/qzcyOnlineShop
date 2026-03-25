function listTable(query){
	var url = window.document.location.href.toString();
	var queryString = url.split("?")[1];
	query = query || queryString;
	if(query == 'start' || query == undefined){
		query = '';
		history.replaceState({}, null, './userlist.php');
	}else if(query != undefined){
		history.replaceState({}, null, './userlist.php?'+query);
	}
	layer.closeAll();
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'userlist-table.php?'+query,
		dataType : 'html',
		cache : false,
		success : function(data) {
			layer.close(ii);
			$("#listTable").html(data)
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function showRecharge(zid) {
	// 确保使用Layer弹窗而不是Bootstrap modal
	console.log('showRecharge called with zid:', zid);
	layer.open({
		type: 1,
		title: '余额充值',
		area: ['400px', '300px'],
		content: `
			<div style="padding: 20px;">
				<div class="form-group">
					<label>操作类型：</label>
					<select class="form-control" id="recharge_do">
						<option value="0">加款</option>
						<option value="1">减款</option>
					</select>
				</div>
				<div class="form-group">
					<label>金额：</label>
					<input type="number" class="form-control" id="recharge_rmb" placeholder="请输入金额" step="0.01">
				</div>
				<div class="form-group">
					<label>备注：</label>
					<input type="text" class="form-control" id="recharge_remark" placeholder="备注信息（可选）">
				</div>
				<div class="form-group" style="margin-top: 20px;">
					<button type="button" class="btn btn-primary btn-block" onclick="doRecharge(${zid})">确认操作</button>
				</div>
			</div>
		`
	});
}
function setActive(zid,active) {
	$.ajax({
		type : 'GET',
		url : 'ajax_site.php?act=setSite&zid='+zid+'&active='+active,
		dataType : 'json',
		success : function(data) {
			listTable();
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function delUser(zid) {
	var confirmobj = layer.confirm('你确实要删除此用户吗？', {
	  btn: ['确定','取消']
	}, function(){
	  $.ajax({
		type : 'GET',
		url : 'ajax_site.php?act=delSite&zid='+zid,
		dataType : 'json',
		success : function(data) {
			if(data.code == 0){
				layer.msg('删除成功');
				listTable();
			}else{
				layer.alert(data.msg,{icon:0});
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	  });
	}, function(){
	  layer.close(confirmobj);
	});
}
function doRecharge(zid) {
	var actdo = $("#recharge_do").val();
	var rmb = $("#recharge_rmb").val();
	var remark = $("#recharge_remark").val();
	
	if(rmb == '' || rmb <= 0){
		layer.alert('请输入有效金额');
		return false;
	}
	
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : "POST",
		url : "ajax_site.php?act=siteRecharge",
		data : {zid:zid,actdo:actdo,rmb:rmb,remark:remark},
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.msg('修改余额成功');
				layer.closeAll();
				listTable();
			}else{
				layer.alert(data.msg);
			}
		},
		error:function(data){
			layer.close(ii);
			layer.msg('服务器错误');
			return false;
		}
	});
}

$(document).ready(function(){
	$("#search_submit").click(function(){
		var kw=$("input[name='kw']").val();
		$("#search").modal('hide');
		if(kw == ''){
			listTable('start');
		}else{
			listTable('kw='+kw);
		}
	});
	$("#tabSort").change(function(){
		if($(this).val() == '0'){
			listTable('sort=0');
		}else if($(this).val() == '1'){
			listTable('sort=1');
		}else{
			listTable('start');
		}
	});
});
$(document).ready(function(){
	listTable();
})