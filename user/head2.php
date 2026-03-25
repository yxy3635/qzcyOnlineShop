<?php

// 使用本地资源文件，不再依赖CDN
$cdnpublic = '../assets/';
if(!empty($conf['staticurl'])){
	$cdnserver = '//'.$conf['staticurl'].'/';
}else{
	$cdnserver = '../';
}
list($background_image, $background_css) = \lib\Template::getBackground('../');

$template_route = \lib\Template::loadRoute();
if($template_route){
	if($template_route['userlogin'] && checkIfActive('login')){
		include($template_route['userlogin']);exit;
	}elseif($template_route['userreg'] && checkIfActive('reg')){
		include($template_route['userreg']);exit;
	}elseif($template_route['userfindpwd'] && checkIfActive('findpwd')){
		include($template_route['userfindpwd']);exit;
	}elseif($template_route['userregsite'] && checkIfActive('regsite')){
		include($template_route['userregsite']);exit;
	}elseif($template_route['userregok'] && checkIfActive('regok')){
		include($template_route['userregok']);exit;
	}
}

@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?php echo $title ?></title>
  <link href="<?php echo $cdnserver?>assets/css/bootstrap-3.3.7.min.css" rel="stylesheet"/>
<link href="<?php echo $cdnserver?>assets/css/font-awesome-4.7.0.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="<?php echo $cdnserver?>assets/simple/css/plugins.css">
  <link rel="stylesheet" href="<?php echo $cdnserver?>assets/simple/css/main.css">
  <link rel="stylesheet" href="<?php echo $cdnserver?>assets/css/common.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/store/css/background.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $cdnserver; ?>assets/css/buttonStyle.css">
  <script src="<?php echo $cdnserver?>assets/js/modernizr-2.8.3.min.js"></script>

  <!--[if lt IE 9]>
    <script src="<?php echo $cdnserver?>assets/js/html5shiv-3.7.3.min.js"></script>
    <script src="<?php echo $cdnserver?>assets/js/respond-1.4.2.min.js"></script>
  <![endif]-->
<?php echo $background_css?>
</head>
<body>