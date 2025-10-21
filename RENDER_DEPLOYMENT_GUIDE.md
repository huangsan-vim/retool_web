# 🚀 Render.com 部署指南

## 快速部署步骤

### 1. 创建 Render 账户

1. 访问 https://render.com
2. 点击 "Get Started" 或 "Sign Up"
3. 使用 GitHub 账户登录（推荐）

### 2. 连接 GitHub 仓库

1. 登录后，点击 "New +" 按钮
2. 选择 "Web Service"
3. 点击 "Connect a repository"
4. 授权 Render 访问您的 GitHub
5. 选择 `huangsan-vim/retool_web` 仓库
6. 选择 `refactored-version` 分支

### 3. 配置部署设置

Render 会自动检测到 `render.yaml` 配置文件，但您也可以手动配置：

**基本设置：**
- **Name**: `retool-video-platform` (或您喜欢的名称)
- **Region**: 选择离您最近的区域（如 Singapore 或 Oregon）
- **Branch**: `refactored-version`
- **Environment**: `Docker`

**实例类型：**
- **Free**: $0/月（有限制，适合测试）
- **Starter**: $7/月（推荐，适合生产）
- **Standard**: $25/月（更高性能）

**推荐选择 Starter 计划**

### 4. 添加持久化存储（重要！）

为了保存数据库数据：

1. 在服务设置中，找到 "Disks" 部分
2. 点击 "Add Disk"
3. 配置：
   - **Name**: `retool-data`
   - **Mount Path**: `/var/www/html/database`
   - **Size**: 1 GB（足够使用）

### 5. 环境变量（可选）

如果需要自定义配置，可以添加环境变量：

```
PHP_MEMORY_LIMIT=256M
PHP_UPLOAD_MAX_FILESIZE=100M
PHP_POST_MAX_SIZE=100M
```

### 6. 部署

1. 点击 "Create Web Service"
2. Render 会自动：
   - 拉取代码
   - 构建 Docker 镜像
   - 部署应用
   - 分配 URL

**部署时间**: 约 5-10 分钟

### 7. 访问您的网站

部署完成后，您会获得一个 URL，格式如：
```
https://retool-video-platform.onrender.com
```

## 📊 费用说明

### Starter 计划（推荐）
- **费用**: $7/月
- **包含**:
  - 512 MB RAM
  - 0.5 CPU
  - 自动 SSL 证书
  - 自定义域名支持
  - 持久化存储
  - 自动部署

### 额外费用
- **持久化存储**: 1 GB 免费，超出部分 $0.25/GB/月
- **带宽**: 100 GB/月免费，超出部分 $0.10/GB

**预计总费用**: $7-10/月

## 🔧 部署后配置

### 1. 自定义域名（可选）

如果您有自己的域名：

1. 在 Render 控制台，进入您的服务
2. 点击 "Settings" → "Custom Domains"
3. 添加您的域名
4. 在您的域名注册商处添加 CNAME 记录：
   ```
   CNAME: your-domain.com → your-service.onrender.com
   ```

### 2. 环境变量更新

如果需要修改配置：

1. 进入服务设置
2. 点击 "Environment"
3. 添加或修改环境变量
4. 保存后会自动重新部署

### 3. 查看日志

1. 在服务页面点击 "Logs"
2. 可以实时查看应用日志
3. 用于调试和监控

## 🔄 自动部署

配置完成后，每次您推送代码到 `refactored-version` 分支：
1. Render 会自动检测更新
2. 自动构建新的 Docker 镜像
3. 自动部署新版本
4. 零停机时间

## 🛠️ 故障排除

### 问题 1: 部署失败

**解决方案**:
1. 检查 Logs 查看错误信息
2. 确认 Dockerfile 正确
3. 检查环境变量配置

### 问题 2: 数据库文件丢失

**解决方案**:
1. 确认已添加持久化磁盘
2. 检查挂载路径是否正确：`/var/www/html/database`

### 问题 3: 网站访问慢

**解决方案**:
1. 升级到更高的实例类型
2. 选择离用户更近的区域
3. 启用 CDN（Render 自带）

## 📈 监控和维护

### 查看性能指标

1. 在服务页面查看：
   - CPU 使用率
   - 内存使用率
   - 请求数量
   - 响应时间

### 备份数据库

定期备份数据库文件：
1. 使用 Render Shell 访问容器
2. 下载 `/var/www/html/database/retool.db`
3. 保存到本地

## 🎯 优化建议

### 1. 启用 CDN
Render 自动提供 CDN，无需额外配置

### 2. 配置缓存
已在代码中实现，无需额外配置

### 3. 监控性能
使用 Render 内置的监控工具

## 📞 支持

如果遇到问题：
1. 查看 Render 文档: https://render.com/docs
2. 联系 Render 支持: support@render.com
3. 查看项目文档: README.md, DEPLOYMENT.md

## ✅ 部署检查清单

- [ ] 创建 Render 账户
- [ ] 连接 GitHub 仓库
- [ ] 选择 refactored-version 分支
- [ ] 配置实例类型（推荐 Starter）
- [ ] 添加持久化存储（1 GB）
- [ ] 点击部署
- [ ] 等待部署完成（5-10分钟）
- [ ] 访问分配的 URL
- [ ] 测试所有功能
- [ ] （可选）配置自定义域名
- [ ] 设置监控和告警

---

**部署完成后，您的视频平台将在几分钟内上线！** 🎉

**预计费用**: $7-10/月
**部署时间**: 5-10 分钟
**维护**: 自动化，无需手动干预