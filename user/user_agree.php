<?php
session_start();

// 检查 Cookie 是否存在
if (isset($_COOKIE['user_is_visit_page'])) {
    header("Location: login.php");
    exit();
}

// 处理同意按钮点击
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agree'])) {
    setcookie('user_is_visit_page', 'true', time() + (1 * 24 * 60 * 60), '/');
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<!--              _                          
__      _____| | ___ ___  _ __ ___   ___ 
\ \ /\ / / _ \ |/ __/ _ \| '_ ` _ \ / _ \
 \ V  V /  __/ | (_| (_) | | | | | |  __/
  \_/\_/ \___|_|\___\___/|_| |_| |_|\___|-->
  
  <!--  __ _   ____   ___   _   _ 
 / _` | |_  /  / __| | | | |
| (_| |  / /  | (__  | |_| |
 \__, | /___|  \___|  \__, |
    |_|               |___/ -->
    
    <!--合作邮箱 yxy3635@gmail.com-->
    <!--代码效果自取~~效果部分已加注释，无加密~-->
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注意事项和免责声明</title>
    <!-- 本地化：移除外链 Google Fonts 与 CDNJS 的 Font Awesome，改为本地版本 -->
    <link rel="stylesheet" href="../assets/css/font-awesome-4.7.0.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
            color: #333;
            background: linear-gradient(-45deg, #74ebd5, #acb6e5, #f8cdda, #e1f5c4);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            overflow-y: auto;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* 背景 Canvas */
        #particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* 确保粒子背景在内容底层 */
        }

        .container {
            position: relative;
            max-width: 800px;
            margin :0 auto;
            margin-top: 150px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.3); 
            backdrop-filter: blur(5px); 
            -webkit-backdrop-filter: blur(5px);  
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 1.5s ease-out;
            z-index: 0;
            margin-bottom: 100px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 15px 0;
            font-size: 16px;
            line-height: 1.6;
            transition: all 0.3s ease;
        }

        li:hover {
            transform: translateX(10px);
            color: #007bff;
        }

        li::before {
            content: "\f058";
            font-family: "FontAwesome";
            color: #28a745;
            margin-right: 8px;
        }

        /* 按钮样式 */
        .btn-agree {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            background: linear-gradient(45deg, #28a745, #218838);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .btn-agree:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        /* 页脚 */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
            color: #fff;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10; /* 确保页脚位于最上层 */
        }

        /* 动画 */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 点击文字的样式 */
        .click-text {
            position: absolute;
            color: #ff6f61;
            font-size: 20px;
            font-weight: bold;
            animation: fadeInText 1s ease-out;
            pointer-events: none;
            font-family: "STXingkai", "华文行楷", cursive; 
        }

        /* 点击文字动画 */
        @keyframes fadeInText {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>
</head>
<body>
    <!-- 粒子背景 -->
    <canvas id="particles"></canvas>

    <!-- 内容部分 -->
    <div class="container">
        <h1>注意事项和免责声明</h1>
         <div style="text-align:left">
            <ul>
                <h5>千纸雏鸢系列在线商城项目模拟<font color="red">以下简称本网站</font>使用者/用户需要同意以下协议：</h5>

            <li>本网站提供的所有信息仅供参考，不构成任何法律、金融或专业建议。</li>
                <li>使用本网站即表示您已了解并接受相关风险，网站所有者不对因使用网站内容造成的任何损失负责。</li>
                <li>本网站内容可能会更新，请随时查看最新版本。</li>
                <li>请确保您遵守适用法律和法规，不用于非法用途。</li>
                <li>本网站内所有项目/内容/增值服务均为网络采集，与本网站<font color="red">无关</font>本网站不参与活动或组织。</li>
                <li>在用户使用本网站的时候，若发现侵权/违规 请联系yxy3635@gmail.com反应。</li>
        </ul>
        <p>如果您同意以上条款，请点击下方按钮进入网站。</p>
        </div>

        <form method="POST">
            <button type="submit" name="agree" class="btn-agree">同意以上并进入网站</button>
        </form>
    </div>
    <div class="footer">Powered by 千纸雏鸢 © 2023-2025</div>
    <!-- 本地化：改为相对路径，避免通过 CDN 前缀加载 -->
    <script src="../assets/store/js/style.js"></script>
</body>
</html>