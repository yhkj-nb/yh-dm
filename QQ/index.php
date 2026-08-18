<?php
/**
 * ============================================================
 *  选择入口 · 开源版 (PHP)
 *  开源协议：MIT License
 *  说明：纯 PHP 静态页面，数据在下方 $itemsData 中配置
 *  支持类型：QQ群(group) / 机器人(robot) / 频道(channel) / 好友(friend)
 *  使用前请将 xxxxxxxxxx 替换为你的实际链接
 * ============================================================
 */

// ============================================================
//  1. 数据配置（在这里添加/修改你的条目）
//     ⚠️ 请将 xxxxxxxxxx 替换为你的实际链接
// ============================================================
$itemsData = [
    // ---------- QQ群 ----------
    [
        'type' => 'group',
        'type_name' => 'QQ群',
        'qq' => 'xxxxxxxxxx',
        'name' => '示例QQ群1',
        'desc' => '请修改为你的群简介',
        'join_link' => 'https://qm.qq.com/q/xxxxxxxxxx'
    ],
    [
        'type' => 'group',
        'type_name' => 'QQ群',
        'qq' => 'xxxxxxxxxx',
        'name' => '示例QQ群2',
        'desc' => '请修改为你的群简介',
        'join_link' => 'https://qm.qq.com/q/xxxxxxxxxx'
    ],
    [
        'type' => 'group',
        'type_name' => 'QQ群',
        'qq' => 'xxxxxxxxxx',
        'name' => '示例QQ群3',
        'desc' => '请修改为你的群简介',
        'join_link' => 'https://qm.qq.com/q/xxxxxxxxxx'
    ],

    // ---------- 机器人 ----------
    [
        'type' => 'robot',
        'type_name' => '机器人',
        'qq' => 'xxxxxxxxxx',
        'name' => '示例机器人',
        'desc' => '请修改为你的机器人简介',
        'join_link' => 'https://q.qq.com/qqbot/profile/?robot_uin=xxxxxxxxxx'
    ],

    // ---------- 频道（使用默认SVG头像，无需QQ号） ----------
    [
        'type' => 'channel',
        'type_name' => '频道',
        'qq' => '', // 留空则不请求头像
        'name' => '示例频道',
        'desc' => '请修改为你的频道简介',
        'join_link' => 'https://pd.qq.com/s/xxxxxxxxxx',
        'use_default_avatar' => true // 标记使用默认SVG头像
    ],

    // ---------- 个人好友 ----------
    [
        'type' => 'friend',
        'type_name' => '好友',
        'qq' => 'xxxxxxxxxx',
        'name' => '示例好友',
        'desc' => '请修改为你的好友简介',
        'join_link' => 'https://qm.qq.com/q/xxxxxxxxxx'
    ]
];

// ============================================================
//  2. 类型配置
// ============================================================
$typeConfig = [
    'group' => ['label' => 'QQ群', 'color' => '#667eea'],
    'robot' => ['label' => '机器人', 'color' => '#00b894'],
    'channel' => ['label' => '频道', 'color' => '#fdcb6e'],
    'friend' => ['label' => '好友', 'color' => '#e17055']
];

// ============================================================
//  3. 获取请求参数
// ============================================================
$filterType = isset($_GET['type']) ? $_GET['type'] : 'all';
$currentIndex = isset($_GET['index']) ? intval($_GET['index']) : 0;

// 验证类型
if ($filterType !== 'all' && !isset($typeConfig[$filterType])) {
    $filterType = 'all';
}

// 筛选数据
if ($filterType === 'all') {
    $filteredItems = $itemsData;
} else {
    $filteredItems = array_filter($itemsData, function($item) use ($filterType) {
        return $item['type'] === $filterType;
    });
    // 重新索引数组
    $filteredItems = array_values($filteredItems);
}

// 如果筛选结果为空，回退到全部
if (empty($filteredItems)) {
    $filteredItems = $itemsData;
    $filterType = 'all';
}

$totalItems = count($filteredItems);

// 边界处理
if ($currentIndex < 0) $currentIndex = 0;
if ($currentIndex >= $totalItems && $totalItems > 0) $currentIndex = $totalItems - 1;

$currentItem = $totalItems > 0 ? $filteredItems[$currentIndex] : null;

// 统计各类型数量（用于标签显示）
$typeCounts = [];
foreach ($itemsData as $item) {
    $t = $item['type'];
    $typeCounts[$t] = ($typeCounts[$t] ?? 0) + 1;
}
$totalAll = count($itemsData);

// ============================================================
//  4. 辅助函数
// ============================================================

/**
 * 获取头像 URL
 */
function getAvatarUrl($type, $qq, $useDefault = false) {
    if ($useDefault || empty($qq)) return '';
    switch ($type) {
        case 'group':
            return 'https://p.qlogo.cn/gh/' . $qq . '/' . $qq . '/640/';
        case 'robot':
        case 'friend':
            return 'https://q1.qlogo.cn/g?b=qq&nk=' . $qq . '&s=640';
        default:
            return 'https://q1.qlogo.cn/g?b=qq&nk=' . $qq . '&s=640';
    }
}

/**
 * 获取备用头像 URL
 */
function getFallbackUrl($type, $qq) {
    if (empty($qq)) return '';
    if ($type === 'group') {
        return 'https://p.qlogo.cn/gh/' . $qq . '/' . $qq . '/0/';
    }
    return 'https://q2.qlogo.cn/headimg_dl?dst_uin=' . $qq . '&spec=640';
}

/**
 * 获取类型标签颜色
 */
function getTypeColor($type) {
    global $typeConfig;
    return isset($typeConfig[$type]) ? $typeConfig[$type]['color'] : '#6c5ce7';
}

/**
 * 获取类型显示名称
 */
function getTypeLabel($type) {
    global $typeConfig;
    return isset($typeConfig[$type]) ? $typeConfig[$type]['label'] : $type;
}

/**
 * 生成 SVG 图标
 */
function getSvg($type, $fill = 'currentColor') {
    $icons = [
        'group' => '<path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>',
        'robot' => '<path d="M20 9V7c0-1.1-.9-2-2-2h-4c0-1.38-1.12-2.5-2.5-2.5S9 3.62 9 5H5c-1.1 0-2 .9-2 2v2c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2v2c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-2c1.1 0 2-.9 2-2v-4c0-1.1-.9-2-2-2zM7.5 8c.83 0 1.5.67 1.5 1.5S8.33 11 7.5 11 6 10.33 6 9.5 6.67 8 7.5 8zm9 0c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5zM7.5 14h9c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5z"/>',
        'channel' => '<path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4V4c0-1.1-.9-2-2-2zm0 14H4V4h16v12zM6 6h12v2H6V6zm0 4h12v2H6v-2zm0 4h8v2H6v-2z"/>',
        'friend' => '<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>',
        'all' => '<path d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h10v2H4v-2z"/>'
    ];
    $path = isset($icons[$type]) ? $icons[$type] : $icons['friend'];
    return '<svg viewBox="0 0 24 24" style="fill:' . $fill . ';">' . $path . '</svg>';
}

/**
 * HTML 转义
 */
function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>选择入口 · 开源版</title>
    <style>
        /* ====================================================
                   全局样式重置 & 基础
                   ==================================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            /* 随机壁纸背景（可替换为你自己的壁纸 API） */
            background-image: url('https://api.yppp.net/api.php');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 12px;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.2);
            z-index: 0;
        }

        .container {
            width: 100%;
            max-width: 420px;
            max-height: 98vh;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border-radius: 28px;
            padding: 20px 18px 24px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .header {
            text-align: center;
            margin-bottom: 14px;
            flex-shrink: 0;
        }

        .header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #2d3748;
            letter-spacing: 1px;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.5);
        }

        .header h1 span {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .filter-tabs-wrapper {
            flex-shrink: 0;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            margin-bottom: 14px;
            padding: 2px 0 6px 0;
            position: relative;
        }

        .filter-tabs-wrapper::-webkit-scrollbar {
            display: none;
        }

        .filter-tabs {
            display: flex;
            gap: 8px;
            padding: 0 2px;
            white-space: nowrap;
            min-width: max-content;
        }

        .filter-tab {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 14px;
            border-radius: 20px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(2px);
            font-size: 13px;
            font-weight: 600;
            color: #4a5568;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            flex-shrink: 0;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
        }

        .filter-tab svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
            flex-shrink: 0;
        }

        .filter-tab:active {
            transform: scale(0.94);
        }

        .filter-tab.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.35);
        }

        .filter-tab .count {
            font-size: 10px;
            background: rgba(0, 0, 0, 0.08);
            padding: 0 6px;
            border-radius: 10px;
            font-weight: 400;
            min-width: 18px;
            text-align: center;
        }

        .filter-tab.active .count {
            background: rgba(255, 255, 255, 0.2);
        }

        .card-wrapper {
            position: relative;
            flex: 1;
            min-height: 0;
            overflow: hidden;
            border-radius: 18px;
            margin-bottom: 14px;
        }

        .card-slider {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            height: 100%;
            will-change: transform;
        }

        .card-item {
            min-width: 100%;
            padding: 0 2px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
            border-radius: 18px;
            padding: 22px 16px 20px;
            width: 100%;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 14px;
            border-radius: 16px;
            font-size: 11px;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .type-badge svg {
            width: 14px;
            height: 14px;
            fill: currentColor;
        }

        .avatar-wrapper {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto 12px;
            border-radius: 50%;
            padding: 3px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.25);
        }

        .avatar-wrapper img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: block;
            background: #edf2f7;
            border: 3px solid rgba(255, 255, 255, 0.9);
            object-fit: cover;
        }

        .avatar-wrapper img.hidden {
            display: none;
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .avatar-placeholder svg {
            width: 40px;
            height: 40px;
            fill: rgba(255, 255, 255, 0.9);
        }

        .type-icon-badge {
            position: absolute;
            bottom: -3px;
            right: -3px;
            background: #2d3748;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.9);
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .type-icon-badge svg {
            width: 15px;
            height: 15px;
            fill: white;
        }

        .item-name {
            font-size: 17px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 2px;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.3);
        }

        .item-qq {
            font-size: 13px;
            color: #4a5568;
            font-weight: 500;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.3);
        }

        .item-desc {
            font-size: 13px;
            color: #2d3748;
            background: rgba(255, 255, 255, 0.6);
            padding: 4px 14px;
            border-radius: 16px;
            display: inline-block;
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }

        .indicators {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 12px;
            flex-shrink: 0;
            min-height: 12px;
        }

        .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            transition: all 0.4s ease;
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.06);
            flex-shrink: 0;
        }

        .dot.active {
            background: #667eea;
            width: 22px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
            border-color: #667eea;
        }

        .nav-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
            flex-shrink: 0;
        }

        .nav-btn {
            flex: 1;
            padding: 10px 0;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            -webkit-tap-highlight-color: transparent;
        }

        .nav-btn:active {
            transform: scale(0.95);
        }

        .nav-btn.prev {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            color: #2d3748;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .nav-btn.prev:hover {
            background: rgba(255, 255, 255, 0.9);
        }

        .nav-btn.next {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .nav-btn.next:hover {
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.4);
        }

        .join-btn {
            display: block;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #00b894, #00cec9);
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            letter-spacing: 1.5px;
            box-shadow: 0 4px 20px rgba(0, 206, 201, 0.25);
            flex-shrink: 0;
            -webkit-tap-highlight-color: transparent;
        }

        .join-btn:active {
            transform: scale(0.97);
        }

        .join-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 30px rgba(0, 206, 201, 0.35);
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.85);
            text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
            flex-shrink: 0;
        }

        .footer a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            padding: 2px 10px;
            background: rgba(0, 0, 0, 0.15);
            border-radius: 10px;
            transition: background 0.3s;
        }

        .footer a:active {
            background: rgba(0, 0, 0, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 30px 16px;
            color: #4a5568;
        }

        .empty-state svg {
            width: 60px;
            height: 60px;
            fill: #a0aec0;
            margin-bottom: 12px;
        }

        .empty-state p {
            font-size: 15px;
        }

        .bg-fade-in {
            animation: bgFadeIn 0.6s ease-out;
        }

        @keyframes bgFadeIn {
            from { opacity: 0.6; }
            to { opacity: 1; }
        }

        @media (max-width: 480px) {
            body { padding: 8px; }
            .container {
                padding: 16px 14px 18px;
                border-radius: 24px;
                max-height: 100vh;
            }
            .header h1 { font-size: 18px; }
            .filter-tab { font-size: 12px; padding: 5px 12px; }
            .filter-tab svg { width: 14px; height: 14px; }
            .card-wrapper { min-height: 320px; max-height: 380px; }
            .card { padding: 18px 14px 16px; }
            .avatar-wrapper { width: 72px; height: 72px; }
            .avatar-placeholder svg { width: 34px; height: 34px; }
            .type-icon-badge { width: 24px; height: 24px; }
            .type-icon-badge svg { width: 13px; height: 13px; }
            .item-name { font-size: 16px; }
            .item-qq { font-size: 12px; }
            .item-desc { font-size: 12px; padding: 3px 12px; }
            .nav-btn { font-size: 13px; padding: 9px 0; }
            .join-btn { font-size: 14px; padding: 11px; }
            .footer { font-size: 10px; margin-top: 8px; }
        }

        @media (max-height: 700px) {
            .card-wrapper { min-height: 240px; max-height: 300px; }
            .card { padding: 14px 12px 14px; }
            .avatar-wrapper { width: 60px; height: 60px; margin-bottom: 8px; }
            .avatar-placeholder svg { width: 30px; height: 30px; }
            .type-badge { font-size: 10px; padding: 2px 12px; margin-bottom: 6px; }
            .item-name { font-size: 15px; }
            .header h1 { font-size: 17px; }
            .header { margin-bottom: 10px; }
            .filter-tabs-wrapper { margin-bottom: 10px; }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- 头部 -->
        <div class="header">
            <h1>✨ <span>选择入口 · 开源版</span></h1>
        </div>

        <!-- 分类筛选标签 -->
        <div class="filter-tabs-wrapper">
            <div class="filter-tabs" id="filterTabs">
                <!-- "全部" 标签 -->
                <a href="?type=all<?php echo $currentIndex > 0 ? '&index=' . $currentIndex : ''; ?>"
                   class="filter-tab <?php echo $filterType === 'all' ? 'active' : ''; ?>"
                   data-type="all">
                    <?php echo getSvg('all', $filterType === 'all' ? 'white' : 'currentColor'); ?>
                    全部 <span class="count"><?php echo $totalAll; ?></span>
                </a>
                <?php foreach ($typeConfig as $key => $config):
                    $count = isset($typeCounts[$key]) ? $typeCounts[$key] : 0;
                    if ($count === 0) continue;
                    $isActive = $filterType === $key;
                ?>
                <a href="?type=<?php echo $key; ?><?php echo $currentIndex > 0 ? '&index=' . $currentIndex : ''; ?>"
                   class="filter-tab <?php echo $isActive ? 'active' : ''; ?>"
                   data-type="<?php echo $key; ?>">
                    <?php echo getSvg($key, $isActive ? 'white' : 'currentColor'); ?>
                    <?php echo $config['label']; ?> <span class="count"><?php echo $count; ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 卡片滑动区域 -->
        <div class="card-wrapper" id="cardWrapper">
            <div class="card-slider" id="cardSlider" style="transform: translateX(-<?php echo $currentIndex * 100; ?>%);">
                <?php if (empty($filteredItems)): ?>
                <div class="card-item">
                    <div class="card">
                        <div class="empty-state">
                            <?php echo getSvg('all', '#a0aec0'); ?>
                            <p>暂无此类型内容</p>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <?php foreach ($filteredItems as $index => $item):
                    $type = $item['type'];
                    $qq = isset($item['qq']) ? $item['qq'] : '';
                    $useDefault = isset($item['use_default_avatar']) ? $item['use_default_avatar'] : false;
                    $avatar = getAvatarUrl($type, $qq, $useDefault);
                    $fallback = getFallbackUrl($type, $qq);
                    $color = getTypeColor($type);
                    $label = isset($item['type_name']) ? $item['type_name'] : getTypeLabel($type);
                ?>
                <div class="card-item" data-index="<?php echo $index; ?>">
                    <div class="card">
                        <!-- 类型标签 -->
                        <div class="type-badge" style="background: <?php echo $color; ?>;">
                            <?php echo getSvg($type, 'white'); ?>
                            <?php echo e($label); ?>
                        </div>
                        <!-- 头像 -->
                        <div class="avatar-wrapper">
                            <?php if (!empty($avatar) && !$useDefault): ?>
                            <img src="<?php echo e($avatar); ?>"
                                 alt="<?php echo e($label); ?>"
                                 loading="lazy"
                                 data-fallback="<?php echo e($fallback); ?>"
                                 onerror="handleAvatarError(this)">
                            <div class="avatar-placeholder" style="display:none;">
                                <?php echo getSvg($type, 'rgba(255,255,255,0.9)'); ?>
                            </div>
                            <?php else: ?>
                            <div class="avatar-placeholder" style="display:flex;">
                                <?php echo getSvg($type, 'rgba(255,255,255,0.9)'); ?>
                            </div>
                            <?php endif; ?>
                            <span class="type-icon-badge"><?php echo getSvg($type, 'white'); ?></span>
                        </div>
                        <!-- 信息 -->
                        <div class="item-name"><?php echo e($item['name']); ?></div>
                        <?php if (!empty($qq) && !$useDefault): ?>
                        <div class="item-qq"><?php echo e($qq); ?></div>
                        <?php endif; ?>
                        <div class="item-desc"><?php echo e($item['desc']); ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- 指示器 -->
        <div class="indicators" id="indicators">
            <?php if (count($filteredItems) > 1): ?>
            <?php for ($i = 0; $i < count($filteredItems); $i++): ?>
            <span class="dot <?php echo $i === $currentIndex ? 'active' : ''; ?>" data-index="<?php echo $i; ?>"></span>
            <?php endfor; ?>
            <?php endif; ?>
        </div>

        <!-- 导航按钮 -->
        <div class="nav-buttons">
            <button class="nav-btn prev" id="prevBtn">‹ 上一项</button>
            <button class="nav-btn next" id="nextBtn">下一项 ›</button>
        </div>

        <!-- 加入按钮 -->
        <a href="<?php echo $currentItem ? e($currentItem['join_link']) : '#'; ?>"
           class="join-btn"
           id="joinBtn"
           target="_blank"
           rel="noopener noreferrer">
           🚀 立即加入
        </a>

        <!-- 底部 -->
        <div class="footer">
            <span id="footerInfo">当前 <?php echo $totalItems > 0 ? ($currentIndex + 1) : 0; ?> / <?php echo $totalItems; ?></span>
            · <a href="javascript:void(0)" onclick="refreshBackground(); return false;">换张壁纸</a>
        </div>
    </div>

    <script>
        /**
         * ============================================================
         *  JavaScript 交互逻辑
         * ============================================================
         */

        // ============================================================
        //  数据（从 PHP 传递）
        // ============================================================
        var totalItems = <?php echo $totalItems; ?>;
        var currentIndex = <?php echo $currentIndex; ?>;
        var filterType = '<?php echo $filterType; ?>';
        var filteredItems = <?php echo json_encode($filteredItems); ?>;

        // ============================================================
        //  DOM 引用
        // ============================================================
        var cardSlider = document.getElementById('cardSlider');
        var cardWrapper = document.getElementById('cardWrapper');
        var dots = document.querySelectorAll('.dot');
        var prevBtn = document.getElementById('prevBtn');
        var nextBtn = document.getElementById('nextBtn');
        var joinBtn = document.getElementById('joinBtn');
        var footerInfo = document.getElementById('footerInfo');
        var filterWrapper = document.querySelector('.filter-tabs-wrapper');

        var isAnimating = false;

        // ============================================================
        //  头像加载失败处理
        // ============================================================
        window.handleAvatarError = function(img) {
            if (img.dataset.retried) return;
            img.dataset.retried = 'true';
            if (img.dataset.fallback) {
                img.src = img.dataset.fallback;
            } else {
                img.style.display = 'none';
                var wrapper = img.parentElement;
                var placeholder = wrapper.querySelector('.avatar-placeholder');
                if (placeholder) {
                    placeholder.style.display = 'flex';
                }
            }
        };

        // ============================================================
        //  滑动控制
        // ============================================================
        function updateSlide(index, animate) {
            if (isAnimating) return;
            if (totalItems === 0) return;
            if (index < 0) index = totalItems - 1;
            if (index >= totalItems) index = 0;

            isAnimating = true;
            currentIndex = index;

            var offset = -index * 100;
            cardSlider.style.transition = animate ?
                'transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)' :
                'none';
            cardSlider.style.transform = 'translateX(' + offset + '%)';

            // 更新指示器
            document.querySelectorAll('.dot').forEach(function(dot, i) {
                dot.classList.toggle('active', i === index);
            });

            // 更新加入按钮
            if (filteredItems.length > 0 && index < filteredItems.length) {
                joinBtn.href = filteredItems[index].join_link || '#';
            }

            // 更新底部信息
            footerInfo.textContent = '当前 ' + (index + 1) + ' / ' + totalItems;

            // 更新 URL（不刷新页面）
            try {
                var url = new URL(window.location);
                url.searchParams.set('index', index);
                window.history.replaceState({}, '', url);
            } catch (e) {}

            setTimeout(function() {
                isAnimating = false;
            }, 500);
        }

        // ============================================================
        //  事件绑定
        // ============================================================

        // 导航按钮
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!isAnimating && totalItems > 0) {
                updateSlide(currentIndex - 1, true);
            }
        });

        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!isAnimating && totalItems > 0) {
                updateSlide(currentIndex + 1, true);
            }
        });

        // 圆点点击
        document.querySelectorAll('.dot').forEach(function(dot) {
            dot.addEventListener('click', function() {
                var idx = parseInt(this.getAttribute('data-index'));
                if (idx !== currentIndex && !isAnimating) {
                    updateSlide(idx, true);
                }
            });
        });

        // 触摸滑动
        var touchStartX = 0;
        var isDragging = false;

        cardWrapper.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
            isDragging = true;
        }, { passive: true });

        cardWrapper.addEventListener('touchend', function(e) {
            if (!isDragging || totalItems <= 1) return;
            var touchEndX = e.changedTouches[0].screenX;
            var diff = touchStartX - touchEndX;

            if (Math.abs(diff) > 50) {
                if (diff > 0 && currentIndex < totalItems - 1) {
                    updateSlide(currentIndex + 1, true);
                } else if (diff < 0 && currentIndex > 0) {
                    updateSlide(currentIndex - 1, true);
                } else if (diff > 0 && currentIndex === totalItems - 1) {
                    updateSlide(0, true);
                } else if (diff < 0 && currentIndex === 0) {
                    updateSlide(totalItems - 1, true);
                }
            }
            isDragging = false;
        }, { passive: true });

        // 键盘支持
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' && !isAnimating) {
                e.preventDefault();
                if (totalItems > 0) updateSlide(currentIndex - 1, true);
            } else if (e.key === 'ArrowRight' && !isAnimating) {
                e.preventDefault();
                if (totalItems > 0) updateSlide(currentIndex + 1, true);
            }
        });

        // ============================================================
        //  刷新壁纸
        // ============================================================
        window.refreshBackground = function() {
            var body = document.body;
            body.classList.remove('bg-fade-in');
            void body.offsetWidth;
            body.style.backgroundImage = 'url(https://api.yppp.net/api.php?_=' + Date.now() + ')';
            body.classList.add('bg-fade-in');
        };

        // ============================================================
        //  分类标签点击事件（PHP 已经生成链接，但我们需要阻止刷新）
        // ============================================================
        document.querySelectorAll('.filter-tab').forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                // 允许正常跳转，因为 PHP 已经生成了正确的链接
                // 不需要额外处理
            });
        });
    </script>

</body>
</html>