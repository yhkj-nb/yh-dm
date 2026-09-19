<?php
// 配置信息
$site_title = "云痕科技引导页";
$site_description = "云痕科技 - 专业的技术服务提供商";
$site_keywords = "云痕科技,云计算,软件开发,技术服务";
$author = "云痕科技";
$company_name = "云痕科技";
$company_subtitle = "欢迎访问云痕科技引导页";
$company_desc = "专注于云计算、前端后端与技术服务";

// 导航链接配置
$nav_links = [
    ['name' => '引导一', 'url' => 'xxxxxxx'],
    ['name' => '引导二', 'url' => 'xxxxxxx'],
    ['name' => '引导三', 'url' => 'xxxxxxx'],
    ['name' => '引导四', 'url' => 'xxxxxxx'],
    ['name' => '引导五', 'url' => 'xxxxxxx']
];

// 获取壁纸URL（API直接返回图片，不需要解析）
function getWallpaper() {
    return "https://api.yppp.net/api.php";
}

$background_url = getWallpaper();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="force-rendering" content="webkit" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo htmlspecialchars($site_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($site_keywords); ?>">
    <meta name="author" content="<?php echo htmlspecialchars($author); ?>">
    <title><?php echo htmlspecialchars($site_title); ?></title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/iconfont.css">
    <link rel="apple-touch-icon" href="./images/apple-touch-icon.png">
    <link rel="icon" href="./favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/volantis-x/cdn-fontawesome-pro@master/css/all.min.css" media="all">
    <script>if (/*@cc_on!@*/false || (!!window.MSInputMethodContext && !!document.documentMode)) window.location.href = "https://imsyy.top/upgrade-your-browser/index.html?referrer=" + encodeURIComponent(window.location.href);</script>
    
    <style>
        .company-sub {
            font-size: 0.85em;
            opacity: 0.85;
            letter-spacing: 1px;
        }
        
        .panel-cover__description {
            font-size: 1.1em;
            line-height: 1.6;
        }
        
        .panel-cover {
            background: url('<?php echo htmlspecialchars($background_url); ?>') center center no-repeat #666;
            background-size: cover;
            background-attachment: fixed;
            position: relative;
            z-index: 1;
        }
        
        .panel-main {
            position: relative;
            z-index: 2;
        }
        
        /* xf-MusicPlayer 播放器样式 - 固定在右下角 */
        #xf-MusicPlayer {
            position: fixed !important;
            bottom: 20px !important;
            right: 20px !important;
            z-index: 99999 !important;
        }
        
        /* 确保播放器内部元素可点击 */
        #xf-MusicPlayer * {
            pointer-events: auto !important;
        }
        
        .panel-cover--overlay {
            z-index: 1;
        }
        
        #fps {
            z-index: 9999 !important;
            position: fixed !important;
        }
    </style>
</head>

<body oncontextmenu="return false" onselectstart="return false" style="position: relative; overflow-x: hidden;">
    <header id="panel" class="panel-cover">
        <div class="panel-main">
            <div class="panel-main__inner panel-inverted">
                <div class="panel-main__content">
                    <div class="ih-item circle effect right_to_left">
                        <a class="blog-button">
                            <div class="img">
                                <img src="./images/logo.png" alt="<?php echo htmlspecialchars($company_name); ?>" class="js-avatar iUp profilepic">
                            </div>
                            <div class="info iUp">
                                <div class="info-back">
                                    <h2><?php echo htmlspecialchars($company_name); ?></h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <h1 class="panel-cover__title panel-title iUp">
                        <br /><?php echo htmlspecialchars($company_name); ?>
                    </h1>
                    <p class="panel-cover__subtitle panel-subtitle iUp company-sub"><?php echo htmlspecialchars($company_subtitle); ?></p>
                    <hr class="panel-cover__divider iUp" />
                    
                    <p id="description" class="panel-cover__description iUp">
                        <?php echo htmlspecialchars($company_desc); ?>
                        <br />
                        <strong>-「<?php echo htmlspecialchars($company_name); ?>」</strong>
                    </p>
                    
                    <div class="navigation-wrapper iUp">
                        <nav class="cover-navigation cover-navigation--primary">
                            <ul class="navigation">
                                <?php foreach ($nav_links as $link): ?>
                                <li class="navigation__item">
                                    <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank" class="blog-button">
                                        <div><?php echo htmlspecialchars($link['name']); ?></div>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="panel-cover--overlay cover-slate"></div>
        </div>
        
        <div id="fps" style="z-index:9999;position:fixed;bottom:3px;left:3px;color:#2196F3;font-size:10px;"></div>
    </header>
    
    <!-- xf-MusicPlayer 播放器 -->
    <div id="xf-MusicPlayer" 
         data-cdnName="https://player.xfyun.club/js"  
         data-themeColor="xf-sky"
         data-fadeOutAutoplay 
         data-memory="1" 
         data-random="true">
    </div>
    
    <!-- xf-MusicPlayer 核心脚本 -->
    <script src="https://player.xfyun.club/js/xf-MusicPlayer/js/xf-MusicPlayer.min.js"></script>
    
    <script>
        // 确保播放器样式正确
        setTimeout(function() {
            var player = document.getElementById('xf-MusicPlayer');
            if (player) {
                player.style.position = 'fixed';
                player.style.bottom = '20px';
                player.style.right = '20px';
                player.style.zIndex = '99999';
            }
        }, 100);
        
        iziToast.settings({
            timeout: 4000,
            icon: 'Fontawesome',
            closeOnEscape: 'true',
            position: 'topRight',
            transitionOut: 'fadeOutRight',
            displayMode: '2',
            layout: '2',
            transitionIn: 'bounceInLeft',
        });
        
        function update() {
            iziToast.info({
                icon: 'fad fa-times-octagon',
                backgroundColor: '#efefef',
                title: '站点暂时关闭',
                message: '只是出现了一点小问题 ~'
            });
        }
    </script>
    
    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <script type="text/javascript" src="./js/fetch.min.js"></script>
    <script type="text/javascript" src="./js/main.js"></script>
</body>
</html>