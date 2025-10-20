# retool_web

**目的**  
给外部团队一套可复现的测试包。包含：前端/后端源码（PHP + 静态资源）、脱敏的数据库导出，和导入/运行说明。**不含生产密码**。

---

## 仓库结构（约定）

/
├─ README.md
├─ MANIFEST.md
├─ sql_houtai_com_data.sanitized.sql.gz
├─ sql_okysadmin_va_data.sanitized.sql.gz
├─ web.zip                # 你的 web 程序打包（PHP + 静态）
└─ retool_upload/         # （可选）单独放重建材料
├─ README.md
└─ …

---

## 快速说明（对外团队）
1. 解压 web 程序 `web.zip` 到 web 根目录（例如 `/var/www/html`）。  
2. 解压并检查数据库文件：
```bash
gunzip -c sql_okysadmin_va_data.sanitized.sql.gz | head -n 80
gunzip -c sql_houtai_com_data.sanitized.sql.gz | head -n 80

	3.	在本地 MySQL 中创建测试库并导入（示例）：

mysql -u root -p -e "CREATE DATABASE retool_test_okysadmin DEFAULT CHARACTER SET utf8mb4;"
gunzip -c sql_okysadmin_va_data.sanitized.sql.gz | mysql -u root -p retool_test_okysadmin

如需只导入 schema，可先审阅并移除 INSERT。导入时请确保 --default-character-set=utf8mb4。

⸻

推荐本地运行（Docker Compose 示例）

把下面写成 docker-compose.yml 供测试团队使用（示例，仅供参考）：

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

导入脱敏 SQL 到 db 容器：

docker-compose up -d
gunzip -c sql_okysadmin_va_data.sanitized.sql.gz | docker exec -i $(docker-compose ps -q db) mysql -uroot -pchangeme retool_test_okysadmin


⸻

与 Retool / Workflow 对接（给运维）
	•	Retool startTrigger（替换占位符）：

curl -X POST "https://api.retool.com/v1/workflows/<WORKFLOW_ID>/startTrigger" \
  -H "X-Workflow-Api-Key: <RETOOL_WORKFLOW_API_KEY>" \
  -H "Content-Type: application/json" \
  -d '{"payload":{"db":"retool_test_okysadmin","notes":"start from repo"}}'

	•	链接触发（你系统中的 /cursor/launch?ak=...）应使用 DIRECTORY_ACCESS_KEY 作为 ak 查询参数。

⸻

Slack / Events
	•	确认 Slack 事件回调指向：
https://<YOUR_HOST>/slack/events
	•	Bot 在目标频道已被邀请。必要 OAuth scope 与 events：chat:write,channels:read,channels:history,files:write。

⸻

视频上传 / PPVOD（说明给开发）
	•	目前站点使用 PPVOD 做上传与播放。关键点：
	•	上传接口：/api/upload（示例，请在 web 源码中查找具体实现）
	•	存储应指向测试对象存储或本地 public/uploads 目录
	•	播放使用 PPVOD 播放器配置，确认 videohost、imghost 在 config 表中（已包含在导出数据）
	•	请勿上传真实用户视频到外部测试服务。测试时使用小样本 MP4 文件。

⸻

广告后台（说明）
	•	广告配置存在 n_1_form_ad、n_1_form 类表，广告素材是外链。
	•	重建时：
	•	保持广告表结构和示例数据即可。
	•	若需要播放/预览，请把 imghost / videohost 指向测试域或本地静态资源。

⸻

敏感信息与注意事项（必须读）
	•	本包不应包含生产服务器密码或私钥。
	•	我已移除/脱敏 DEFINER、直接可用的 DB 密码、服务器 root 密码等。
	•	仓库公开前再次确认：grep -i -E "password|pwd|secret|token|key" -R . 返回为空或仅示例值。
	•	如果需要对方上线到你方测试服务器，请通过安全密钥管道单独下发最小权限凭证，不在此仓库中公开。

⸻

MANIFEST（简要）
	•	sql_*sanitized*.sql.gz : 脱敏数据库导出（schema + 部分数据）。
	•	web.zip : 网站代码与静态资源。
	•	README.md : 本文件。
	•	MANIFEST.md : 列表与校验方法。

⸻

交付说明 / 验收点
	1.	对方在本地能用 docker-compose 起通环境并导入 SQL。
	2.	能在浏览器访问首页（如 http://localhost:8080）。
	3.	能触发视频上传接口并确认文件出现在 public/uploads（测试文件）。
	4.	Retool 能通过 startTrigger 调用打通（运维提供 workflow id 与 api key 测试）。

⸻
