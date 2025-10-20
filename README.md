retool_web

目的

给外部开发/集成团队一套可复现的测试包。包含：
	•	已脱敏的数据库导出（schema + 示例数据）
	•	网站源码（PHP + 静态资源）
	•	部署与导入说明
不包含生产密码或私钥。

⸻

仓库结构（约定）

/ 
├─ README.md
├─ MANIFEST.md
├─ sql_houtai_com_data.sanitized.sql.gz
├─ sql_okysadmin_va_data.sanitized.sql.gz
├─ web.zip                # 网站源码 (PHP + 静态)
└─ retool_upload/         # 可选：单独放重建材料
   ├─ README.md
   └─ ...


⸻

快速检查

查看导出头部：

gunzip -c sql_okysadmin_va_data.sanitized.sql.gz | head -n 80
gunzip -c sql_houtai_com_data.sanitized.sql.gz  | head -n 80


⸻

本地导入示例（直接 MySQL）
	1.	创建数据库：

mysql -u root -p -e "CREATE DATABASE retool_test_okysadmin DEFAULT CHARACTER SET utf8mb4;"

	2.	导入数据：

gunzip -c sql_okysadmin_va_data.sanitized.sql.gz | mysql -u root -p retool_test_okysadmin
gunzip -c sql_houtai_com_data.sanitized.sql.gz  | mysql -u root -p retool_test_okysadmin

如需只导入 schema，请先审阅 SQL 并移除 INSERT 语句。

⸻

推荐本地运行（Docker Compose 示例）

将下列 docker-compose.yml 放在包根，便于对方一键启动测试环境。

version: "3.8"
services:
  db:
    image: mysql:8
    environment:
      MYSQL_ROOT_PASSWORD: changeme
    volumes:
      - db_data:/var/lib/mysql

  php:
    image: php:8.1-fpm
    volumes:
      - ./web:/var/www/html

  web:
    image: nginx:stable
    volumes:
      - ./web:/var/www/html:ro
      - ./nginx.conf:/etc/nginx/conf.d/default.conf:ro
    ports:
      - "8080:80"
    depends_on:
      - php
volumes:
  db_data:

导入到容器的示例：

docker-compose up -d
gunzip -c sql_okysadmin_va_data.sanitized.sql.gz | docker exec -i $(docker-compose ps -q db) mysql -uroot -pchangeme retool_test_okysadmin


⸻

部署说明（简洁）
	1.	解压 web.zip 到 web 根目录（例如 /var/www/html）。
	2.	配置 Nginx/Apache 指向解压目录并启用 PHP-FPM。
	3.	在 config 或 .env 中设置测试用的 PPVOD_API_URL 与 PPVOD_API_KEY（见下）。

⸻

PPVOD（视频上传/播放）说明
	•	站点使用 PPVOD 做上传与播放。配置项通常在网站配置表或 .env 中（videohost、imghost）。
	•	上传接口示例（伪代码）：

POST {PPVOD_API_URL}/upload
Headers: Authorization: Bearer <PPVOD_API_KEY>
Content-Type: multipart/form-data
Body: file=@sample.mp4

	•	测试时请使用小样本 MP4。不要上传生产用户视频到外部服务。

⸻

广告后台说明
	•	广告配置存于数据库表（如 n_1_form_ad、n_1_form 等）。
	•	广告素材为外链。测试重建时保留表结构与示例数据即可。
	•	若需预览广告，请把 imghost / videohost 指向测试域或本地静态目录。

⸻

与 Retool / Workflow 对接（运维）

Start trigger 示例：

curl -X POST "https://api.retool.com/v1/workflows/<WORKFLOW_ID>/startTrigger" \
  -H "X-Workflow-Api-Key: <RETOOL_WORKFLOW_API_KEY>" \
  -H "Content-Type: application/json" \
  -d '{"payload":{"db":"retool_test_okysadmin","notes":"start from repo"}}'

系统内部 link 触发（示例）：

/cursor/launch?ak=<DIRECTORY_ACCESS_KEY>

DIRECTORY_ACCESS_KEY 应通过密钥管道单独下发，不放在仓库。

⸻

Slack / Events（运维）
	•	Slack 事件回调应指向： https://<YOUR_HOST>/slack/events
	•	Bot 已被邀请到目标频道。
	•	OAuth scopes（最小）：chat:write, channels:read, channels:history, files:write

⸻

敏感信息与注意事项（必须读）
	•	本包为脱敏导出。已移除或替换生产密码、DEFINER、MYSQL_PWD、SERVER 密钥等敏感项。
	•	上传到公开仓库前再次核查：

grep -RinE "password|pwd|secret|token|key|MYSQL_PWD|DEFINER|ROOT|SSH|PRIVATE" .

输出应为空或仅示例占位符。
	•	若需对接线上测试服务器，请通过独立安全渠道下发最小权限凭证。不要在仓库中公开凭据。

⸻

MANIFEST（简要）
	•	sql_*sanitized*.sql.gz : 脱敏数据库导出（schema + 示例数据）
	•	web.zip                : 网站源码与静态资源
	•	README.md              : 使用说明（本文件）
	•	MANIFEST.md            : 文件清单与校验方法

⸻

交付与验收清单

对方完成后应确认：
	1.	能用 docker-compose 或直接部署并访问首页（例如 http://localhost:8080）。
	2.	能登录后台（使用测试账号）。
	3.	能触发视频上传接口并在 public/uploads（或测试存储）看到文件。
	4.	广告按 DB 配置正常渲染。
	5.	Retool 能通过 startTrigger 调用成功（运维提供 WORKFLOW_ID 与 RETOOL_WORKFLOW_API_KEY）。

⸻

联系与回报

完成重建或遇到问题，请回报：
	•	可访问的测试 URL
	•	测试 DB 名称
	•	是否能上传视频（接口返回码）
	•	是否能看到广告位

