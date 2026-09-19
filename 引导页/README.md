# 🌐 引导页 · Guide Page

> 一个简洁优雅的「公司 / 个人引导页（Landing Page）」开源项目，原用于云痕科技。提供 **纯 HTML 静态版** 与 **PHP 版** 两种实现，页面功能完全一致。

<p align="center">
  <img src="https://img.shields.io/badge/license-开源-brightgreen" alt="开源" />
  <img src="https://img.shields.io/badge/语言-HTML5%20%7C%20PHP-blue" alt="语言" />
  <img src="https://img.shields.io/badge/版本-v1.0.0-purple" alt="版本" />
  <img src="https://img.shields.io/badge/更新-2026--09--19-orange" alt="更新" />
  <img src="https://img.shields.io/badge/响应式-支持-9cf" alt="响应式" />
</p>

<p align="center">
  <a href="https://yh.yhkj.ddns-ip.net/QQ.html">
    <img src="https://img.shields.io/badge/QQ群-点击加入-12b7f5?logo=tencentqq&logoColor=white&style=for-the-badge" alt="点击加入QQ群" />
  </a>
</p>

---

## 🚀 快速开始

- **HTML 版**：进入 [`html/`](./html/) 目录，直接双击 `index.html` 即可预览，或部署到任意静态托管。
- **PHP 版**：进入 [`php/`](./php/) 目录，放到支持 PHP 的服务器访问 `index.php`。

👉 **想交流 / 反馈？欢迎 [点击加入 QQ 群](https://yh.yhkj.ddns-ip.net/QQ.html)**。

## ✨ 功能特性

- **品牌展示**：居中圆形头像（Logo）+ 公司名称 + 副标题 + 简介，带渐入动画。
- **导航入口**：5 个可配置的导航按钮（引导一 ~ 引导五），点击新窗口打开。
- **动态壁纸**：自动拉取 Bing 每日壁纸作为全屏背景，带本地缓存（`sessionStorage`）。
- **一言文案**：描述区随机展示「一言」名句（公共接口 https://v1.hitokoto.cn/）。
- **音乐播放器**：右下角内置 xf-MusicPlayer 音乐播放器，支持随机播放与记忆上次播放。
- **浏览器兼容提示**：检测到 IE 等老旧浏览器时引导升级。
- **响应式布局**：自适应桌面与移动端。

## 📁 目录结构

```
引导页/
├── README.md        # 本文件（总说明）
├── html/            # 纯 HTML 静态版（无需服务器，双击即可打开）
│   ├── index.html
│   ├── css/  js/  images/  404.html  favicon.ico
│   └── README.md
└── php/             # PHP 版（需 PHP 运行环境，配置更灵活）
    ├── index.php
    ├── css/  js/  images/  404.html  favicon.ico
    └── README.md
```

## 🛠 使用

- **HTML 版**：直接双击 `html/index.html` 即可预览；部署到任意静态托管（GitHub Pages / Nginx / 对象存储）。
- **PHP 版**：放到支持 PHP 的服务器（如本仓库根目录的 `引导页/php/`），访问 `index.php`。

## 🔗 关于链接

- **导航按钮链接**（引导一 ~ 引导五）在开源版本中统一替换为占位符 `xxxxxxx`，便于你替换成自己的站点。
- **其余链接均保留真实可用地址**：背景图接口、一言接口 https://v1.hitokoto.cn/（公共 API）、第三方 CDN（jsDelivr、Bing 壁纸、xf-MusicPlayer 等）。
- **QQ 群入口**：https://yh.yhkj.ddns-ip.net/QQ.html （欢迎加入交流）。

## 📜 开源说明

本目录随 [`yhkj-nb/yh-dm`](https://github.com/yhkj-nb/yh-dm)（杂七杂八的代码合集）开源，仅供学习与二次开发参考。
