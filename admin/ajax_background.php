<?php
/**
 * 个性化背景图片上传处理
 */
include("../includes/common.php");

if($islogin==1){}else exit('{"code":-1,"msg":"未登录"}');

$act = isset($_GET['act']) ? $_GET['act'] : '';

@header('Content-Type: application/json; charset=UTF-8');

switch($act) {
    case 'upload':
        if (!isset($_FILES['background']) || $_FILES['background']['error'] !== UPLOAD_ERR_OK) {
            exit('{"code":-1,"msg":"文件上传失败"}');
        }
        
        $file = $_FILES['background'];
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        
        if (!in_array($file['type'], $allowedTypes)) {
            exit('{"code":-1,"msg":"不支持的文件格式，只支持 JPG、PNG、GIF、WEBP 格式"}');
        }
        
        // 检查文件大小（最大5MB）
        if ($file['size'] > 10 * 1024 * 1024) {
            exit('{"code":-1,"msg":"文件大小不能超过10MB"}');
        }
        
        $backgroundDir = '../assets/img/background/';
        if (!is_dir($backgroundDir)) {
            mkdir($backgroundDir, 0755, true);
        }
        
        // 获取下一个背景图片编号
        $nextNumber = getNextBackgroundNumber($backgroundDir);
        
        // 获取文件扩展名
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($extension === 'jpeg') $extension = 'jpg';
        
        $newFileName = "background_{$nextNumber}.{$extension}";
        $uploadPath = $backgroundDir . $newFileName;
        
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // 返回成功信息
            exit('{"code":0,"msg":"上传成功","filename":"' . $newFileName . '","path":"' . $backgroundDir . $newFileName . '"}');
        } else {
            exit('{"code":-1,"msg":"文件保存失败"}');
        }
        break;
    
    case 'list':
        $backgroundDir = '../assets/img/background/';
        $list = [];
        if (is_dir($backgroundDir)) {
            $files = scandir($backgroundDir);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..' && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file)) {
                    $list[] = [
                        'filename' => $file,
                        'path' => $backgroundDir . $file
                    ];
                }
            }
        }
        exit(json_encode(['code'=>0,'msg'=>'succ','files'=>$list]));
        break;
        
    case 'delete':
        $filename = isset($_POST['filename']) ? $_POST['filename'] : '';
        if (empty($filename)) {
            exit('{"code":-1,"msg":"文件名不能为空"}');
        }
        
        // 防止删除background_1（默认背景）
        if (strpos($filename, 'background_1') !== false) {
            exit('{"code":-1,"msg":"不能删除默认背景图片"}');
        }
        
        $backgroundDir = '../assets/img/background/';
        $filePath = $backgroundDir . $filename;
        
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                exit('{"code":0,"msg":"删除成功"}');
            } else {
                exit('{"code":-1,"msg":"删除失败"}');
            }
        } else {
            exit('{"code":-1,"msg":"文件不存在"}');
        }
        break;
        
    default:
        exit('{"code":-1,"msg":"未知操作"}');
}

/**
 * 获取下一个背景图片编号
 */
function getNextBackgroundNumber($dir) {
    $maxNumber = 1;
    
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if (preg_match('/background_(\d+)\.(jpg|jpeg|png|gif|webp)$/i', $file, $matches)) {
                $number = intval($matches[1]);
                if ($number > $maxNumber) {
                    $maxNumber = $number;
                }
            }
        }
    }
    
    return $maxNumber + 1;
}
?>
