# 🖥️ 引导页 · HTML 静态版

> 本目录是引导页的 **纯 HTML 静态实现**，所有配置已固化为字面值，**不需要任何 PHP / 后端服务器**，双击 `index.html` 即可在浏览器打开。

<p align="center">
  <img src="https://img.shields.io/badge/类型-纯静态-green" alt="类型" />
  <img src="https://img.shields.io/badge/依赖-零后端-blue" alt="依赖" />
  <img src="https://img.shields.io/badge/响应式-支持-9cf" alt="响应式" />
</p>

<p align="center">
  <a href="https://yh.yhkj.ddns-ip.net/QQ.html">
    <img src="https://img.shields.io/badge/QQ群-点击加入-12b7f5?logo=tencentqq&logoColor=white&style=for-the-badge" alt="点击加入QQ群" />
  </a>
</p>

---

## 📦 包含文件

- `index.html` —— 页面入口（已固化站点标题、导航、背景图等配置）
- `css/` —— 样式（style.css、iconfont.css、font.css）
- `js/` —— 脚本（jquery.min.js、fetch.min.js、main.js）
- `images/` —— Logo 与图标
- `404.html`、`favicon.ico`

## ✨ 功能

与总说明一致：品牌展示、导航入口（引导一 ~ 引导五）、Bing 动态壁纸、一言文案、音乐播放器、浏览器兼容提示、响应式布局。

## 🔧 如何修改导航链接

开源版中 5 个导航按钮链接已替换为 `xxxxxxx`，其余（背景图、一言接口 https://v1.hitokoto.cn/ ）保留真实地址。改成你自己的：

1. 打开 `index.html`，搜索 `xxxxxxx`，把导航 `href` 改成真实地址。
2. 导航名字（引导一 ~ 引导五）如需改，同样在 `index.html` 中修改 `<div>引导一</div>` 等文本。

## 🚀 部署

- 本地预览：双击 `index.html`。
- 静态托管：把整个 `html/` 目录上传到 GitHub Pages / Nginx / 对象存储即可，无需构建。

👉 使用中遇到问题？欢迎 [点击加入 QQ 群](https://yh.yhkj.ddns-ip.net/QQ.html) 交流。
