<?php
error_reporting(0);
include("../includes/common.php");
$user = $_GET['user'];
$ptname = $_GET['ptname'];
$tid = $_GET['tid'];

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
//智慧树快刷
else if($tid==25){
    $id=57;
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
    $id=1273;
 }
 //welearn单元
else if($tid==44){
    $id=1274;
 }
 //学习通全包
else if($tid==14){
    $id=99998;
 } //智慧树考试
else if($tid==5){
    $id=58;
 }//学习通考试
else if($tid==2){
    $id=24;
 }//学习通章节
else if($tid==1){
    $id=99999;
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
else if($tid==35){
   $id=2602;
} 
//安全微伴
else if($tid==36){
   $id=2524;
} 
//ai版u校园
else if($tid==46){
   $id=1306;
} 
//ai版u校园 单元
else if($tid==47){
   $id=1307;
} 
//ai版u校园 班级测试
else if($tid==48){
   $id=1308;
} 

/***** 增加平台就复制这一行代码 可以把查课的黏贴过来就可以了
else if($tid==代刷网商品tid){
   $id=平台商品id;
} 
****/
exit("<script language='javascript'>window.location.href='jd.php?ids=$id&ptnames=$ptname&users=$user';</script>");
?>