<?php
require('./config.php');
require('./admin/webconfig.php');
require('./class/register.class.php');
?>
<!DOCTYPE HTML>
<head>
    <title><?php echo $SiteTitle; ?></title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="description" content="<?php echo $Description; ?>"/>
    <meta name="keywords" content="<?php echo $Keywords; ?>"/>
    <script src="./resource/js/jquery.min.js"></script>
    <script src="./resource/js/jquery.dropotron.min.js"></script>
    <script src="./resource/js/skel.min.js"></script>
    <script src="./resource/js/skel-layers.min.js"></script>
    <script src="./resource/js/init.js"></script>
    <style>
        #banner {
            /* background-attachment: scroll, scroll, scroll, fixed;
            background-color: #645862;
            background-image: url("./resource/css/images/light-bl.svg"), url("./resource/css/images/light-br.svg"), url("./resource/css/images/overlay.png"), url("./resource/img/banner-<?php echo rand(0,15);?>.jpg");
            background-position: bottom left, bottom right, top left, top center;
            background-repeat: no-repeat, no-repeat, repeat, no-repeat;
            background-size: 25em, 25em, auto, cover;
            color: white;
            cursor: default;
            padding: 6em 0;
            text-align: center; */
            
            width: 100%; /* 宽度设为 100% */
            height: 100vh; /* 高度设为视口高度的 100% */
            background-attachment: scroll, scroll, scroll, fixed;
            background-color: #645862;
            background-position: center; /* 背景图像居中 */
            background-repeat: no-repeat, no-repeat, repeat, no-repeat;
            background-size: cover; /* 背景图像覆盖整个元素 */
            color: white;
            cursor: default;
            text-align: center;

            display: flex; /* 设置为 Flex 容器 */
            justify-content: center; /* 水平居中 */
            align-items: center; /* 垂直居中 */

            /* transition: all 0.6s; */
            transition: background-image 0.5s ease-in-out; /* 平滑过渡效果 */
        }

        #cta {
            background-attachment: scroll, scroll, scroll, fixed;
            background-color: #645862;
            background-image: url("./resource/css/images/light-tl.svg"), url("./resource/css/images/light-tr.svg"), url("./resource/css/images/overlay.png"), url("./resource/img/banner-<?php echo rand(0,15);?>.jpg");
            background-position: top left, top right, top left, bottom center;
            background-repeat: no-repeat, no-repeat, repeat, no-repeat;
            background-size: 20em, 20em, auto, cover;
            color: white;
            padding: 3em;
            text-align: center;
        }

        #quote {
            font-size: 25px;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .fadeInElement {
            animation: fadeIn 1s ease-in;
        }

        .inner {
            background: rgba(0, 0, 0, 0.3) !important;
        }
    </style>
    <script>

        function loadNewQuote() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    var newQuote = response.quote;
                    var newBgImageUrl = response.backgroundImage;
                    // 预加载新的背景图
                    var img = new Image();
                    img.onload = function() {
                        // 当图片完全加载后更新背景
                        var bannerElement = document.getElementById("banner");
                        bannerElement.style.backgroundImage = 'url("./resource/css/images/light-bl.svg"), url("./resource/css/images/light-br.svg"), url("./resource/css/images/overlay.png"), url("' + newBgImageUrl + '")';
                        // 更新语录
                        var quoteElement = document.getElementById("quote");
                        quoteElement.innerHTML = "“ " + newQuote + " ”";
                        quoteElement.classList.remove("fadeInElement"); // 移除类以重置动画
                        void quoteElement.offsetWidth; // 触发重绘
                        quoteElement.classList.add("fadeInElement"); // 重新添加类以开始动画
                    
                    };
                    img.src = newBgImageUrl; // 开始加载图片
                }
            };

            var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            var deviceType = screenWidth < 768 ? "mobile" : "pc";
            xhr.open("GET", "get_new_quote_with_bg.php?deviceType=" + deviceType, true);
            xhr.send();
        }

        loadNewQuote();
    </script>
</head>

<body class="index loading">

<!-- Header -->
<header id="header" class="alt">
    <h1 id="logo"><a href="index.php">Quotes</a></h1>
    <nav id="nav">
        <ul>
            <li class="current"><a href="index.php">Welcome</a></li>
            <?php if (!isset($_COOKIE['rains_user'])) {
                echo '
						<li><a href="register.php" class="button special">注册</a></li>
						<li><a href="login.php" class="button special">登录</a></li>';
            } else {
                echo '
						<li><a href="/user" class="button special">' . $_COOKIE['rains_user'] . '</a></li>
						<li><a href="login.php?act=out" class="button special">退出登录</a></li>';
            } ?>
        </ul>
    </nav>
</header>

<!-- Banner -->
<section id="banner">

    <div class="inner">

        <header>
            <h2>AMF语录</h2>
        </header>
        <p id="quote"></p>
        <!-- <footer>
            <ul class="buttons vertical">
                <li><?php if (!isset($_COOKIE['rains_user'])) {
                        echo "<a href=\"register.php\" class=\"button fit scrolly\">立即加入</a>";
                    } else {
                        echo "<a href=\"/user\" class=\"button fit scrolly\">用户中心</a>";
                    } ?></li>
            </ul>
        </footer> -->
        <footer>
            <ul class="buttons vertical">
                <li><?php 
                        echo "<a class=\"button fit scrolly\" onclick=\"loadNewQuote()\">再来一条</a>";
                    ?></li>
            </ul>
        </footer>
    </div>

</section>

<!--
<article id="main">

    <header class="special container">
        <span class="icon fa-bar-chart-o"></span>
        <h2>全新的系统，更好的体验</h2>
        <p>你可以调用系统为你提供的语句，并将其展示在你的网站上。<br/>你也可以定制属于自己语句，提交你的专属语句并调用。
        </p>
    </header>
    
    <section id="cta">

        <header>
            <h2>如何使用随机语录?</h2>
            <p>点击下面的按钮，获取调用接口</p>
        </header>
        <footer>
            <ul class="buttons">
                <li><a href="/user/api_system.php" class="button special">系统语录</a></li>
                <li><a href="/user/api_users.php" class="button">我的语句</a></li>
            </ul>
        </footer>

    </section>

    <footer id="footer">
        <span class="copyright">Copyright &copy; 2016.<a target="_blank" href="http://rainss.cn/">&#38632;&#33853;&#20939;&#27527;</a> All rights reserved.</span>

    </footer>
</article>
-->
</body>
</html>