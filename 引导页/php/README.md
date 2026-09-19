# 🐘 引导页 · PHP 版

> 本目录是引导页的 **PHP 实现**，配置以 PHP 变量形式写在 `index.php` 顶部，**修改配置无需改动 HTML 结构**，适合需要动态配置或对接后端接口的部署。

<p align="center">
  <img src="https://img.shields.io/badge/类型-PHP-orange" alt="类型" />
  <img src="https://img.shields.io/badge/配置-变量化-blue" alt="配置" />
  <img src="https://img.shields.io/badge/版本-v1.0.0-purple" alt="版本" />
</p>

<p align="center">
  <a href="https://yh.yhkj.ddns-ip.net/QQ.html">
    <img src="https://img.shields.io/badge/QQ群-点击加入-12b7f5?logo=tencentqq&logoColor=white&style=for-the-badge" alt="点击加入QQ群" />
  </a>
</p>

---

## 📦 包含文件

- `index.php` —— 页面入口（顶部含站点配置与导航数组）
- `css/`、`js/`、`images/`、`404.html`、`favicon.ico`（同 HTML 版）

## 🔧 如何修改配置

打开 `index.php` 顶部：

```php
$nav_links = [                          // 导航按钮（引导一 ~ 引导五）
    ['name' => '引导一', 'url' => 'xxxxxxx'],
    ['name' => '引导二', 'url' => 'xxxxxxx'],
    // ...其余导航
];
function getWallpaper() {               // 背景图接口（真实地址已保留）
    return "https://api.yppp.net/api.php";
}
```

- 一言接口在 `js/main.js`：`fetch('https://v1.hitokoto.cn/')`（公共 API，无需改动）。

## 🚀 部署

需要支持 PHP 的运行环境（虚拟主机、LNMP，或本仓库 `yh-dm` 支持的 PHP 空间）。把整个 `php/` 目录放到网站根目录，访问 `index.php` 即可。

## ⚖️ 与 HTML 版的区别

| 项目 | HTML 版 | PHP 版 |
|------|---------|--------|
| 运行环境 | 任意浏览器 / 静态托管 | 需 PHP |
| 配置方式 | 直接改 HTML 文本 | 改 PHP 变量 |
| 动态能力 | 无 | 可在服务端拼配置 / 对接接口 |
| 文件入口 | index.html | index.php |

👉 想交流部署经验？欢迎 [点击加入 QQ 群](https://yh.yhkj.ddns-ip.net/QQ.html)。
