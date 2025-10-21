@echo off
echo 🚂 Railway 一键部署脚本 (Windows)
echo ================================
echo.

REM 检查是否安装了 Node.js
where node >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ❌ 请先安装 Node.js: https://nodejs.org
    pause
    exit /b 1
)

REM 检查是否安装了 Railway CLI
where railway >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo 📦 正在安装 Railway CLI...
    npm install -g @railway/cli
    if %ERRORLEVEL% NEQ 0 (
        echo ❌ 安装失败
        pause
        exit /b 1
    )
)

echo ✅ Railway CLI 已安装
echo.

REM 登录 Railway
echo 🔐 正在登录 Railway...
echo    (会打开浏览器，请在浏览器中完成登录)
railway login

if %ERRORLEVEL% NEQ 0 (
    echo ❌ 登录失败，请重试
    pause
    exit /b 1
)

echo ✅ 登录成功
echo.

REM 初始化项目
echo 🚀 正在初始化项目...
railway init

if %ERRORLEVEL% NEQ 0 (
    echo ❌ 初始化失败
    pause
    exit /b 1
)

echo ✅ 项目初始化成功
echo.

REM 部署
echo 📦 正在部署到 Railway...
railway up

if %ERRORLEVEL% NEQ 0 (
    echo ❌ 部署失败
    pause
    exit /b 1
)

echo.
echo 🎉 部署成功！
echo.
echo 📋 获取网站 URL：
railway domain

echo.
echo ✅ 完成！您的网站已上线！
echo.
echo 💡 提示：
echo    - 查看日志: railway logs
echo    - 查看状态: railway status
echo    - 打开控制台: railway open
echo.
pause