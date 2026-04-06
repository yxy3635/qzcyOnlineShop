<?php
include("./includes/common.php");
$user= $_REQUEST['account'];
$pass = $_REQUEST['pwd'];
$school = $_REQUEST['school'];
$tid= $_REQUEST['tid'];
//u校园
if($tid==3){ //tid为你自己代刷网对应商品的tid
   $id=90;   //id为平台商品id
}
else if($tid==40){
   $id=61;
}
//u校园班级测试
else if($tid==17){
   $id=92;
}
//智慧树慢刷全包-tom
else if($tid==54){
    $id=57;
}
//智慧树翻转课
else if($tid==70){
    $id=57;
}
//智慧树快刷
else if($tid==25){
    $id=27;
 }//智慧树视频+课后
else if($tid==24){
    $id=57;
 }//智慧树 
else if($tid==21){
    $id=57;
 } //易班
else if($tid==18){
    $id=867;
 }//u校园控分
else if($tid==20){
    $id=90;
 } //welearn
else if($tid==16){
    $id=177;
 }
 //welearn单元
else if($tid==44){
    $id=237;
 }
 //学习通全包
else if($tid==14){
    $id=2722;
 } 
 //同上
else if($tid==69){
    $id=2722;
} 
 //智慧树考试
else if($tid==5){
    $id=58;
 }//学习通考试
else if($tid==2){
    $id=24;
 }//学习通章节
else if($tid==1){
    $id=2722;
 }
 //学习通作业
 else if($tid==35){
   $id=7;
} 
 //国开
 else if($tid==26){
   $id=400;
 }
 //智慧树秒
 else if($tid==28){
   $id=55;
} 
else if($tid==29){
   $id=1216;
} 
//安全微伴
else if($tid==36){
   $id=2524;
} 
//ai版u校园
else if($tid==46){
   $id=3379;
} 
//ai版u校园 单元
else if($tid==47){
   $id=3378;
} 
//ai版u校园 班级测试
else if($tid==48){
   $id=67;
} 
//智慧职教
else if($tid==65){
   $id=1440;
} 
else if($tid==66){
   $id=2883;
} 
//智慧树异常解除
else if($tid==60){
   $id=681;
} 

//清华社团全
else if($tid==42){
    $id=3223;
}

////清华社团单元
else if($tid==42){
    $id=3224;
}
//易班课群
else if($tid==18){
   $id=867;
}
/***** 增加平台就复制这一行代码
else if($tid==代刷网商品tid){
   $id=平台商品id;
} 
****/

$apiurl = '';//域名若对接站点更换记得更换相应接口
$data=array(
    'uid'=>"",//平台uid
    'key'=>"",//平台的key
    'school'=>$school,
    'platform'=>$id,
    'user'=>$user,
    'pass'=>$pass
);

$wk=get_curl($apiurl,$data);
exit($wk);
?>
