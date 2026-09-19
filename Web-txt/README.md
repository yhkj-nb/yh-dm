# 网站转TXT工具 - Android版 📱
[![Python](https://img.shields.io/badge/Python-3.6+-blue?logo=python&logoColor=white)](https://python.org)
[![点击加入QQ群](https://img.shields.io/badge/点击加入-QQ群-blue)](https://yhkj-nb.github.io/QQ.html)

一个专为Android设备设计的Python脚本，可将任意网页内容提取为纯文本TXT文件，自动创建专用文件夹管理所有转换文件。

## ✨ 功能特点

- 🌐 **网页转文本** - 自动提取网页正文，移除HTML标签和脚本代码
- 🗂️ **智能文件夹管理** - 自动在手机存储创建`网站转TXT文件`专用文件夹
- 📝 **灵活命名方式** - 支持手动输入文件名，或自动从网页标题/网址生成
- 🔤 **编码自动检测** - 使用chardet自动识别网页字符编码，解决乱码问题
- 📊 **实时预览** - 转换后显示内容预览和详细文件信息
- 🔄 **批量转换** - 支持连续转换多个网页，无需重复启动
- 🚫 **防重名机制** - 自动处理重名文件，添加数字后缀避免覆盖
- 💾 **文件信息头** - 自动添加转换时间、源网址、标题等元数据

## 📱 适用环境

- **Android设备** (手机/平板)
- Python 3.6+
- 网络连接

## 📦 依赖安装

### 在Android上安装Python环境

#### 方法一：使用Pydroid 3（推荐新手）
1. 从Google Play安装[Pydroid 3](https://play.google.com/store/apps/details?id=ru.iiec.pydroid3)
2. 打开Pydroid 3，点击左上角菜单 → Pip
3. 安装依赖包，输入以下命令：

```bash
pip install requests
pip install chardet
