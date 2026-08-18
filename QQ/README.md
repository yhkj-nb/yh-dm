# 🚀 云痕选择入口 · 通用导航页

一个简洁、优雅的「选择入口」导航页面，支持 **QQ群 / 机器人 / 频道 / 个人好友** 四种类型的展示与跳转。

---

## ✨ 特性

- 📱 移动端优先，完美适配手机、平板、桌面端
- 🎨 毛玻璃效果，现代化 UI 设计
- 🔄 左右滑动切换，支持触摸、按钮、键盘
- 🏷️ 顶部横向分类筛选标签
- 🖼️ QQ群 / 机器人 / 好友自动拉取 QQ 头像
- 🎲 内置随机壁纸 API，一键换背景
- 📦 提供 HTML 和 PHP 两个版本
- 🔗 URL 参数同步，分享保留状态

---

## 📁 文件说明

| 文件 | 说明 |
|------|------|
| index.html | HTML + JavaScript 版本，适合任意静态服务器 |
| index.php | PHP 版本，适合需要 PHP 环境的服务器 |

---

## 🛠️ 快速开始

### 📄 HTML 版本

1. ⬇️ 下载 index.html
2. ✏️ 用文本编辑器打开
3. 🔍 找到 itemsData 数组，修改其中的示例数据
4. 💾 保存并打开

### 📄 PHP 版本

1. ⬇️ 下载 index.php
2. ✏️ 用文本编辑器打开
3. 🔍 找到 $itemsData 数组，修改其中的示例数据
4. 📤 上传到 PHP 服务器并访问

---

## 📝 数据配置模板

### 🌐 HTML 版本（复制到 index.html 的 itemsData 中）

```javascript
const itemsData = [
    // ===== 💬 QQ群 =====
    {
        type: 'group',
        type_name: 'QQ群',
        qq: 'xxxxxxxxxx',
        name: '示例QQ群1',
        desc: '请修改为你的群简介',
        join_link: 'https://qm.qq.com/q/xxxxxxxxxx'
    },
    {
        type: 'group',
        type_name: 'QQ群',
        qq: 'xxxxxxxxxx',
        name: '示例QQ群2',
        desc: '请修改为你的群简介',
        join_link: 'https://qm.qq.com/q/xxxxxxxxxx'
    },
    // ===== 🤖 机器人 =====
    {
        type: 'robot',
        type_name: '机器人',
        qq: 'xxxxxxxxxx',
        name: '示例机器人',
        desc: '请修改为你的机器人简介',
        join_link: 'https://q.qq.com/qqbot/profile/?robot_uin=xxxxxxxxxx'
    },
    // ===== 📢 频道（使用默认SVG头像） =====
    {
        type: 'channel',
        type_name: '频道',
        qq: '',
        name: '示例频道',
        desc: '请修改为你的频道简介',
        join_link: 'https://pd.qq.com/s/xxxxxxxxxx',
        use_default_avatar: true
    },
    // ===== 👤 个人好友 =====
    {
        type: 'friend',
        type_name: '好友',
        qq: 'xxxxxxxxxx',
        name: '示例好友',
        desc: '请修改为你的好友简介',
        join_link: 'https://qm.qq.com/q/xxxxxxxxxx'
    }
];
```

### 🐘 PHP 版本（复制到 index.php 的 $itemsData 中）

```php
$itemsData = [
    // ===== 💬 QQ群 =====
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
    // ===== 🤖 机器人 =====
    [
        'type' => 'robot',
        'type_name' => '机器人',
        'qq' => 'xxxxxxxxxx',
        'name' => '示例机器人',
        'desc' => '请修改为你的机器人简介',
        'join_link' => 'https://q.qq.com/qqbot/profile/?robot_uin=xxxxxxxxxx'
    ],
    // ===== 📢 频道（使用默认SVG头像） =====
    [
        'type' => 'channel',
        'type_name' => '频道',
        'qq' => '',
        'name' => '示例频道',
        'desc' => '请修改为你的频道简介',
        'join_link' => 'https://pd.qq.com/s/xxxxxxxxxx',
        'use_default_avatar' => true
    ],
    // ===== 👤 个人好友 =====
    [
        'type' => 'friend',
        'type_name' => '好友',
        'qq' => 'xxxxxxxxxx',
        'name' => '示例好友',
        'desc' => '请修改为你的好友简介',
        'join_link' => 'https://qm.qq.com/q/xxxxxxxxxx'
    ]
];
```

---

## 📋 字段说明

| 字段 | 必填 | 说明 |
|------|------|------|
| type | ✅ | group / robot / channel / friend |
| type_name | ✅ | 显示名称，如"QQ群" |
| qq | ⚠️ 部分 | QQ号，频道可留空 |
| name | ✅ | 条目名称 |
| desc | ✅ | 简短描述 |
| join_link | ✅ | 跳转链接 |
| use_default_avatar | ❌ | true=使用默认SVG头像 |

---

## 🎯 类型说明

| 类型 | 标识 | 头像来源 | 图标 |
|------|------|----------|------|
| QQ群 | group | QQ群头像接口 | 💬 |
| 机器人 | robot | 个人QQ头像 | 🤖 |
| 频道 | channel | 默认SVG图标 | 📢 |
| 好友 | friend | 个人QQ头像 | 👤 |

---

## 🖼️ 自定义壁纸

### 修改壁纸 API（两处都要改）

**位置1：CSS 背景**

```css
background-image: url('https://api.yppp.net/api.php');
```

替换为：

```css
background-image: url('你的壁纸API地址');
```

**位置2：JavaScript 换壁纸功能**

```javascript
body.style.backgroundImage = 'url(https://api.yppp.net/api.php?_=' + Date.now() + ')';
```

替换为：

```javascript
body.style.backgroundImage = 'url(你的壁纸API地址?_=' + Date.now() + ')';
```

---

## 🎮 交互方式

- ⬅️ ➡️ 点击「上一项 / 下一项」按钮切换卡片
- 👆 在卡片区域左右滑动（移动端）
- ⌨️ 按键盘 ← / → 方向键（桌面端）
- ⚪ 点击底部圆点快速跳转
- 🏷️ 点击顶部标签筛选分类
- 🎲 点击「换张壁纸」更换背景

---

## 📄 开源协议

📝 MIT License，可自由使用、修改、分发

---

## 🙏 致谢

- 🖼️ 随机壁纸 API：api.yppp.net
- 💬 QQ 头像接口：QQ官方
- **由云痕科技开发**
