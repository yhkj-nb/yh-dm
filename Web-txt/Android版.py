import requests
import re
import os
import chardet
from datetime import datetime
from urllib.parse import urlparse

def check_and_create_special_folder():
    """检查并创建专用文件夹"""
    # 定义专用文件夹名称
    special_folder_name = "网站转TXT文件"
    
    # 可能的存储路径
    base_dirs = [
        "/storage/emulated/0",
        "/sdcard",
        "/storage/sdcard0",
        "/storage/emulated/0/Download"
    ]
    
    # 尝试在不同位置创建专用文件夹
    for base_dir in base_dirs:
        if os.path.exists(base_dir):
            special_folder_path = os.path.join(base_dir, special_folder_name)
            
            # 检查文件夹是否存在
            if not os.path.exists(special_folder_path):
                try:
                    os.makedirs(special_folder_path, exist_ok=True)
                    print(f"📁 已创建专用文件夹: {special_folder_path}")
                    
                    # 创建说明文件
                    readme_content = """# 网站转TXT文件

此文件夹由【网站转TXT工具】自动创建和管理。
所有通过该工具转换的网页文本文件将保存在此处。

文件夹结构建议:
1. 按网站分类保存
2. 按日期分类保存
3. 使用有意义的文件名便于查找

创建时间: {}
""".format(datetime.now().strftime("%Y-%m-%d %H:%M:%S"))
                    
                    readme_path = os.path.join(special_folder_path, "README.txt")
                    with open(readme_path, 'w', encoding='utf-8') as f:
                        f.write(readme_content)
                    
                except Exception as e:
                    print(f"⚠️  创建文件夹失败: {e}")
                    continue
            else:
                print(f"✅ 找到专用文件夹: {special_folder_path}")
            
            return special_folder_path
    
    # 如果上述路径都不行，使用当前目录
    print("⚠️  无法创建专用文件夹，使用当前目录")
    return os.path.join(os.getcwd(), special_folder_name)

def generate_filename_from_url(url):
    """从URL自动生成文件名"""
    try:
        parsed_url = urlparse(url)
        domain = parsed_url.netloc.replace('www.', '')
        
        # 获取域名主体部分（如baidu.com -> baidu）
        domain_parts = domain.split('.')
        if len(domain_parts) >= 2:
            main_domain = domain_parts[-2]  # 获取倒数第二部分
        else:
            main_domain = domain_parts[0] if domain_parts else "网页"
        
        # 清理域名中的特殊字符
        main_domain = re.sub(r'[^a-zA-Z0-9\u4e00-\u9fff]', '_', main_domain)
        
        # 添加时间戳
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        
        # 尝试从网页标题获取更具体的名称
        try:
            headers = {'User-Agent': 'Mozilla/5.0'}
            response = requests.get(url, headers=headers, timeout=5)
            response.encoding = response.apparent_encoding
            
            title_match = re.search(r'<title[^>]*>(.*?)</title>', response.text, re.IGNORECASE | re.DOTALL)
            if title_match:
                page_title = re.sub(r'<[^>]+>', '', title_match.group(1)).strip()
                page_title = re.sub(r'[\\/*?:"<>|]', '_', page_title)
                page_title = re.sub(r'\s+', '_', page_title)
                
                # 如果标题有效且不是默认标题
                if page_title and len(page_title) > 3 and page_title not in ['首页', '主页', 'Home']:
                    # 截取前30个字符作为文件名
                    page_title_short = page_title[:30]
                    file_name = f"{page_title_short}_{timestamp}.txt"
                    return file_name
        except:
            pass  # 如果获取标题失败，使用域名
        
        # 使用域名作为文件名
        file_name = f"{main_domain}_{timestamp}.txt"
        return file_name
        
    except Exception as e:
        # 如果URL解析失败，使用默认文件名
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        return f"网页_{timestamp}.txt"

def get_user_input():
    """获取用户输入"""
    print("=" * 60)
    print("📄 网站转TXT工具 v1.0")
    print("=" * 60)
    
    # 获取链接
    print("\n📎 请输入网页链接:")
    print("   示例: https://example.com")
    url = input("   > ").strip()
    
    if not url:
        print("❌ 链接不能为空！")
        return None, None, None
    
    # 检查链接格式
    if not url.startswith(('http://', 'https://')):
        url = 'https://' + url
        print(f"📝 已自动添加https:// -> {url}")
    
    # 获取文件名（如果用户不输入，自动生成）
    print("\n📄 请输入文件名（直接回车自动生成）:")
    print("   可直接输入完整文件名（如: 文档.txt）")
    print("   或只输入名称部分（如: 文档）")
    print("   不输入则自动从网址生成")
    
    file_input = input("   > ").strip()
    
    # 如果用户没有输入文件名，自动生成
    if not file_input:
        file_name = generate_filename_from_url(url)
        print(f"📝 自动生成文件名: {file_name}")
    elif not file_input.endswith('.txt'):
        file_name = file_input + '.txt'
        print(f"📝 已添加.txt后缀: {file_name}")
    else:
        file_name = file_input
    
    # 检查专用文件夹
    download_dir = check_and_create_special_folder()
    
    # 显示确认信息
    print("\n" + "=" * 60)
    print("🔍 转换信息确认：")
    print(f"   链接: {url}")
    print(f"   文件: {file_name}")
    print(f"   位置: {download_dir}")
    print(f"   时间: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
    print("=" * 60)
    
    # 用户确认
    confirm = input("\n✅ 确认开始转换？(y/n): ").strip().lower()
    if confirm in ['y', 'yes', '是', '确认']:
        return url, download_dir, file_name
    else:
        print("❌ 操作已取消")
        return None, None, None

def convert_webpage_to_txt(url, download_dir, file_name):
    """将网页转换为TXT文件"""
    try:
        print(f"\n{'='*60}")
        print("🔄 开始转换...")
        print(f"{'='*60}")
        
        # 连接网页
        print("🌐 正在连接服务器...")
        headers = {
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language': 'zh-CN,zh;q=0.9,en;q=0.8',
            'Accept-Encoding': 'gzip, deflate',
            'Connection': 'keep-alive'
        }
        
        response = requests.get(url, headers=headers, timeout=15)
        response.raise_for_status()
        
        # 自动检测编码
        if response.encoding == 'ISO-8859-1':
            try:
                encoding = chardet.detect(response.content)['encoding']
                response.encoding = encoding if encoding else 'utf-8'
                print(f"✅ 使用chardet检测编码: {response.encoding}")
            except:
                response.encoding = 'utf-8'
                print("⚠️  chardet检测失败，使用utf-8编码")
        else:
            print(f"✅ 服务器返回编码: {response.encoding}")
        
        # 提取网页标题作为备用文件名
        title_match = re.search(r'<title[^>]*>(.*?)</title>', response.text, re.IGNORECASE | re.DOTALL)
        page_title = "网页内容"
        if title_match:
            page_title = re.sub(r'<[^>]+>', '', title_match.group(1)).strip()
            page_title = re.sub(r'[\\/*?:"<>|]', '_', page_title)[:50]  # 清理非法字符并截断
            print(f"📝 网页标题: {page_title}")
        
        # HTML标签清理
        print("🧹 正在清理HTML标签...")
        
        # 移除脚本和样式
        clean_text = re.sub(r'<script.*?>.*?</script>', '', response.text, flags=re.DOTALL | re.IGNORECASE)
        clean_text = re.sub(r'<style.*?>.*?</style>', '', clean_text, flags=re.DOTALL | re.IGNORECASE)
        clean_text = re.sub(r'<!--.*?-->', '', clean_text, flags=re.DOTALL)
        
        # 移除所有HTML标签
        clean_text = re.sub(r'<[^>]+>', '', clean_text)
        
        # 清理空白字符
        clean_text = re.sub(r'\n\s*\n', '\n\n', clean_text)
        clean_text = re.sub(r'[ \t]+', ' ', clean_text)
        
        # 移除多余的空行
        lines = [line.strip() for line in clean_text.split('\n') if line.strip()]
        clean_text = '\n'.join(lines)
        
        print(f"📊 提取到 {len(clean_text)} 个字符")
        
        # 如果内容太短，可能提取失败
        if len(clean_text) < 100:
            print("⚠️  提取到的内容较少，可能HTML结构特殊")
        
        # 添加文件头部信息
        file_header = f"""# 网页转TXT文件
# 生成时间: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}
# 源网址: {url}
# 网页标题: {page_title}
# 字符数: {len(clean_text)}
# 编码: {response.encoding}
{'='*50}

"""
        
        final_text = file_header + clean_text
        
        # 确保文件夹存在
        if not os.path.exists(download_dir):
            os.makedirs(download_dir, exist_ok=True)
        
        file_path = os.path.join(download_dir, file_name)
        
        # 处理文件重名
        original_name = file_name
        counter = 1
        while os.path.exists(file_path):
            name_part, ext_part = os.path.splitext(original_name)
            new_name = f"{name_part}_{counter}{ext_part}"
            file_path = os.path.join(download_dir, new_name)
            counter += 1
        
        if counter > 1:
            print(f"📝 文件重命名: {original_name} -> {os.path.basename(file_path)}")
        
        # 保存文件
        print("💾 正在保存文件...")
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(final_text)
        
        # 显示成功信息
        print(f"\n{'='*60}")
        print("🎉 转换成功！")
        print(f"{'='*60}")
        print(f"📌 源网址: {url}")
        print(f"📄 文件名: {os.path.basename(file_path)}")
        print(f"📁 保存到: {download_dir}")
        print(f"📊 文件大小: {len(final_text)} 字符")
        print(f"📅 生成时间: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
        print(f"{'='*60}")
        
        # 显示文件内容预览
        print("\n📋 内容预览（前500字符）:")
        print("-" * 40)
        preview = clean_text[:500] + ("..." if len(clean_text) > 500 else "")
        print(preview)
        print("-" * 40)
        
        return True
        
    except requests.exceptions.Timeout:
        print("❌ 连接超时，请检查网络或稍后重试")
        return False
    except requests.exceptions.ConnectionError:
        print("❌ 连接失败，请检查网址是否正确或网络连接")
        return False
    except requests.exceptions.HTTPError as e:
        print(f"❌ HTTP错误: {e}")
        return False
    except Exception as e:
        print(f"❌ 处理过程中出错: {e}")
        return False

def show_folder_info(folder_path):
    """显示文件夹信息"""
    if os.path.exists(folder_path):
        files = [f for f in os.listdir(folder_path) if f.endswith('.txt')]
        file_count = len(files)
        
        print(f"\n📊 专用文件夹信息:")
        print(f"   位置: {folder_path}")
        print(f"   TXT文件数量: {file_count}")
        
        if file_count > 0:
            print(f"   最近文件:")
            txt_files = []
            for f in files:
                file_path = os.path.join(folder_path, f)
                if os.path.isfile(file_path):
                    mtime = os.path.getmtime(file_path)
                    txt_files.append((f, mtime))
            
            # 按修改时间排序，显示最近的3个
            txt_files.sort(key=lambda x: x[1], reverse=True)
            for i, (filename, mtime) in enumerate(txt_files[:3]):
                time_str = datetime.fromtimestamp(mtime).strftime('%Y-%m-%d %H:%M')
                print(f"     {i+1}. {filename} ({time_str})")

def main():
    """主程序"""
    print("=" * 60)
    print("🌐 网站转TXT工具 v1.2")
    print("   自动创建专用文件夹，安全保存转换文件")
    print("   不输入文件名自动从网址生成")
    print("=" * 60)
    
    # 先检查并创建专用文件夹
    print("\n📁 正在检查专用文件夹...")
    special_folder = check_and_create_special_folder()
    show_folder_info(special_folder)
    
    try:
        while True:
            # 获取用户输入
            result = get_user_input()
            if result[0] is None:
                continue_choice = input("\n是否重新输入？(y/n): ").strip().lower()
                if continue_choice not in ['y', 'yes', '是', '确认']:
                    break
                continue
            
            url, download_dir, file_name = result
            
            # 执行转换
            success = convert_webpage_to_txt(url, download_dir, file_name)
            
            if success:
                # 更新文件夹信息
                show_folder_info(download_dir)
            
            # 询问是否继续
            print("\n" + "=" * 60)
            continue_choice = input("是否继续转换其他网页？(y/n): ").strip().lower()
            if continue_choice not in ['y', 'yes', '是', '确认']:
                print("\n👋 感谢使用网站转TXT工具！")
                print(f"💡 提示：所有文件已保存在: {special_folder}")
                break
            
            print("\n" + "=" * 60)
            print("🔄 准备下一次转换...")
            
    except KeyboardInterrupt:
        print("\n\n❌ 程序被用户中断")
    except Exception as e:
        print(f"\n❌ 程序运行出错: {e}")

# 启动程序
if __name__ == "__main__":
    main()