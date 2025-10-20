# retool_web

简要说明  
本仓库包含：网站前端/后端源码（PHP + 静态资源）和用于重建测试环境的**脱敏**数据库导出（`*_sanitized.sql.gz`）。目标是给外部团队一个可复现的测试环境（不含生产凭据）。

---

## 目录结构（示例）

retool_upload/
├─ sql_okysadmin_va_data.sanitized.sql.gz
├─ sql_houtai_com_data.sanitized.sql.gz
├─ README.md
└─ MANIFEST.md

web/
├─ index.php
├─ public/
└─ …（PHP, JS, CSS 等）

---

## 快速准备（给重构/集成方）
1. 在测试主机创建空数据库（示例名 `test_okysadmin_va`, `test_houtai_com`）。  
2. 解压并查看（确认无敏感信息）：
   ```bash
   gunzip -c sql_okysadmin_va_data.sanitized.sql.gz | head -n 80

	3.	导入到测试 MySQL：

mysql -u root -p test_okysadmin_va < <(gunzip -c sql_okysadmin_va_data.sanitized.sql.gz)
mysql -u root -p test_houtai_com  < <(gunzip -c sql_houtai_com_data.sanitized.sql.gz)


	4.	在 web/ 下创建 .env 或 config.php（示例变量）：

DB_HOST=127.0.0.1
DB_NAME=test_okysadmin_va
DB_USER=root
DB_PASS=<testing-db-password>
VIDEOPLAYER=ppvod
AD_BACKEND_ENABLED=true

切勿在仓库提交真实生产密码。

	5.	启动（本地快速测试示例，推荐用 Docker Compose）：

# docker-compose.yml (示例)
version: "3.8"
services:
  php:
    image: php:8.1-fpm
    volumes: ["./web:/var/www/html"]
  db:
    image: mysql:8
    environment:
      MYSQL_DATABASE: test_okysadmin_va
      MYSQL_ROOT_PASSWORD: rootpass
    volumes: ["db_data:/var/lib/mysql"]
  nginx:
    image: nginx:stable
    volumes: ["./web:/var/www/html","./nginx/conf.d:/etc/nginx/conf.d"]
    ports: ["8080:80"]
volumes:
  db_data:

然后 docker compose up -d。

	6.	验证：
	•	打开 http://<host>:8080，确认首页可访问。
	•	登录（若有默认账号信息请在 MANIFEST 中说明）。
	•	测试视频上传（参考 PPVOD 配置段）。

⸻

关于广告后台 / 视频（给重构方说明）
	•	广告配置表：n_1_form_ad、n_1_form、n_site 等（见 SQL）。
	•	视频上载使用 PPVOD，配置点：
	•	视频存储域名（videohost/imghost）在 n_site.param 或配置文件。
	•	上传接口路径请参照 web/public 中的上传脚本。
	•	要求：重建测试环境时，PPVOD 可替换为本地静态存储或 S3 模拟端点。

⸻

交付清单（MANIFEST）
	•	sql_okysadmin_va_data.sanitized.sql.gz — schema + 部分测试数据
	•	sql_houtai_com_data.sanitized.sql.gz — schema + 部分测试数据
	•	web/ — PHP + 前端代码（需配置 DB 与上传存储）
	•	README.md — 使用说明（本文件）
	•	MANIFEST.md — 文件清单与注意事项

⸻

敏感信息与注意事项
	•	本包不应包含生产密码、私钥或未脱敏的 PII。
	•	若需公开仓库前先再次确认脱敏并移除 config、.env 等。
	•	导入后不要把测试 DB 直接指向生产资源。

⸻

联系与验收
	•	若有问题，请在仓库 issue 中提交：描述步骤、失败日志与期望结果。
	•	建议交付时同时提供：
	•	可用的测试 DB 账号（仅测试权限）
	•	PPVOD 测试端点或说明如何切换为模拟存储

我还可以同时生成 `MANIFEST.md` 与 `retool_upload/README.md`（短版说明）文件内容。如果要我直接把这两份写入你本地的打包目录，告诉我 `~/Desktop/web` 路径下确认无误，我会给出可粘贴的 shell 命令。
