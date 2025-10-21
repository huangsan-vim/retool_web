# 🚀 一键部署指南 - 超级简单！

## 📋 您只需要 3 步

### 第 1 步：下载项目
```bash
git clone https://github.com/huangsan-vim/retool_web.git
cd retool_web
git checkout refactored-version
```

### 第 2 步：运行部署脚本

#### 如果您使用 Mac 或 Linux：
```bash
chmod +x deploy-railway.sh
./deploy-railway.sh
```

#### 如果您使用 Windows：
双击运行 `deploy-railway.bat`

### 第 3 步：等待完成
- 脚本会自动安装 Railway CLI
- 打开浏览器让您登录 Railway（只需登录一次）
- 自动部署您的网站
- 显示网站 URL

**就这么简单！** 🎉

---

## 🎯 详细说明

### 脚本会自动完成：

1. ✅ 检查并安装 Railway CLI
2. ✅ 打开浏览器让您登录 Railway
3. ✅ 初始化项目
4. ✅ 上传代码
5. ✅ 构建 Docker 镜像
6. ✅ 部署到云端
7. ✅ 显示网站 URL

### 您只需要：

1. 运行脚本
2. 在浏览器中登录 Railway（用 GitHub 账户）
3. 等待 3-5 分钟
4. 完成！

---

## 💰 费用

- **免费额度**: $5/月
- **预计费用**: $5-10/月
- 小流量网站可能完全免费

---

## 🔧 如果遇到问题

### 问题 1：没有安装 Node.js

**解决方案**：
- 访问 https://nodejs.org
- 下载并安装 Node.js
- 重新运行脚本

### 问题 2：Railway CLI 安装失败

**解决方案**：
```bash
npm install -g @railway/cli
```

### 问题 3：登录失败

**解决方案**：
- 确保浏览器已打开
- 在浏览器中完成 GitHub 授权
- 重新运行脚本

---

## 📞 需要帮助？

如果脚本运行出错：
1. 截图错误信息
2. 发给我
3. 我会立即帮您解决

---

## 🎊 部署成功后

您会看到类似这样的输出：
```
🎉 部署成功！

📋 您的网站 URL：
https://retool-web-production-xxxx.up.railway.app

✅ 完成！您的网站已上线！
```

点击 URL 即可访问您的视频平台！

---

**这是最简单的部署方式！** 🚀