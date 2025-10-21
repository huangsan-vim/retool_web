# 🚂 Railway.app 部署指南（备选方案）

## 为什么选择 Railway？

- ✅ 更简单的部署流程
- ✅ 免费 $5 额度/月
- ✅ 自动 HTTPS
- ✅ 一键部署
- ✅ 优秀的开发者体验

## 快速部署步骤

### 1. 创建 Railway 账户

1. 访问 https://railway.app
2. 点击 "Login" 或 "Start a New Project"
3. 使用 GitHub 账户登录

### 2. 部署项目

#### 方法 1: 从 GitHub 部署（推荐）

1. 登录后，点击 "New Project"
2. 选择 "Deploy from GitHub repo"
3. 授权 Railway 访问您的 GitHub
4. 选择 `huangsan-vim/retool_web` 仓库
5. 选择 `refactored-version` 分支
6. Railway 会自动检测 Dockerfile 并开始部署

#### 方法 2: 一键部署按钮

点击下面的按钮直接部署：

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/new/template?template=https://github.com/huangsan-vim/retool_web/tree/refactored-version)

### 3. 配置设置

Railway 会自动配置大部分设置，但您可以调整：

**环境变量**（可选）:
```
PHP_MEMORY_LIMIT=256M
PHP_UPLOAD_MAX_FILESIZE=100M
```

**持久化存储**:
Railway 会自动处理，无需额外配置

### 4. 获取 URL

部署完成后，Railway 会自动分配一个 URL：
```
https://your-project.up.railway.app
```

## 💰 费用说明

### 免费额度
- **$5 免费额度/月**
- 适合小型项目和测试

### 付费计划
- **Hobby**: $5/月起（按使用量计费）
- **Pro**: $20/月起（更多资源）

**预计费用**: $5-10/月（取决于流量）

## 🔧 高级配置

### 1. 自定义域名

1. 在项目设置中点击 "Settings"
2. 找到 "Domains" 部分
3. 点击 "Add Domain"
4. 输入您的域名
5. 在域名注册商处添加 CNAME 记录

### 2. 环境变量

1. 点击项目
2. 进入 "Variables" 标签
3. 添加环境变量
4. 保存后自动重新部署

### 3. 查看日志

1. 在项目页面点击 "Deployments"
2. 选择最新的部署
3. 查看实时日志

## 🔄 自动部署

每次推送到 `refactored-version` 分支：
- Railway 自动检测更新
- 自动构建和部署
- 零停机时间

## 📊 监控

Railway 提供：
- CPU 使用率
- 内存使用率
- 网络流量
- 部署历史

## 🆚 Render vs Railway 对比

| 特性 | Render | Railway |
|------|--------|---------|
| 免费额度 | ❌ 无 | ✅ $5/月 |
| 起步价格 | $7/月 | $5/月起 |
| 部署速度 | 中等 | 快速 |
| 易用性 | 简单 | 非常简单 |
| 文档 | 详细 | 简洁 |
| 持久化存储 | 需配置 | 自动 |

## 🎯 我的推荐

**如果您想要**:
- 最简单的部署 → 选择 **Railway**
- 更多控制和配置 → 选择 **Render**
- 免费测试 → 选择 **Railway**（有 $5 免费额度）

## ✅ Railway 部署检查清单

- [ ] 创建 Railway 账户
- [ ] 连接 GitHub 仓库
- [ ] 选择 refactored-version 分支
- [ ] 等待自动部署（3-5分钟）
- [ ] 访问分配的 URL
- [ ] 测试所有功能
- [ ] （可选）配置自定义域名
- [ ] 监控使用情况

---

**Railway 部署更快更简单！** 🚂

**预计费用**: $5-10/月
**部署时间**: 3-5 分钟
**难度**: ⭐ 非常简单