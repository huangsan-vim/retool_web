#!/bin/bash

echo "🚂 Railway 一键部署脚本"
echo "================================"
echo ""

# 检查是否安装了 Railway CLI
if ! command -v railway &> /dev/null; then
    echo "📦 正在安装 Railway CLI..."
    
    # 检测操作系统
    if [[ "$OSTYPE" == "darwin"* ]]; then
        # macOS
        brew install railway
    elif [[ "$OSTYPE" == "linux-gnu"* ]]; then
        # Linux
        curl -fsSL https://railway.app/install.sh | sh
    else
        echo "❌ 请手动安装 Railway CLI："
        echo "   npm i -g @railway/cli"
        echo "   或访问: https://docs.railway.app/develop/cli"
        exit 1
    fi
fi

echo "✅ Railway CLI 已安装"
echo ""

# 登录 Railway
echo "🔐 正在登录 Railway..."
echo "   (会打开浏览器，请在浏览器中完成登录)"
railway login

if [ $? -ne 0 ]; then
    echo "❌ 登录失败，请重试"
    exit 1
fi

echo "✅ 登录成功"
echo ""

# 初始化项目
echo "🚀 正在初始化项目..."
railway init

if [ $? -ne 0 ]; then
    echo "❌ 初始化失败"
    exit 1
fi

echo "✅ 项目初始化成功"
echo ""

# 部署
echo "📦 正在部署到 Railway..."
railway up

if [ $? -ne 0 ]; then
    echo "❌ 部署失败"
    exit 1
fi

echo ""
echo "🎉 部署成功！"
echo ""
echo "📋 获取网站 URL："
railway domain

echo ""
echo "✅ 完成！您的网站已上线！"
echo ""
echo "💡 提示："
echo "   - 查看日志: railway logs"
echo "   - 查看状态: railway status"
echo "   - 打开控制台: railway open"