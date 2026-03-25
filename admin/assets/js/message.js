function setActive(id,active) {
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=setMessage&id='+id+'&active='+active,
		dataType : 'json',
		success : function(data) {
			window.location.reload()
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function show(id) {
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=getMessage&id='+id,
		dataType : 'json',
		success : function(data) {
			if(data.code==0){
                layer.open({
                  type: 1,
                  skin: 'layui-layer-lan',
                  anim: 2,
                  shadeClose: true,
                  title: '查看站内通知',
                  content: '<div class="widget" style="border-radius:12px;overflow:hidden">'+
                           '<div class="widget-content text-center" style="padding:12px 14px;border-bottom:1px solid rgba(17,24,39,.06);background:rgba(102,126,234,.08)"><b>'+data.title+'</b><br/><small><span style="color:#6b7280">管理员 '+data.date+'</span></small></div>'+
                           '<div class="widget-content" style="padding:14px">'+data.content+'</div></div>'
                });
			}else{
				layer.alert(data.msg);
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}