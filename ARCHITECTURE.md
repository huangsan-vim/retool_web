# Architecture Documentation - Retool Video Platform

## 🏗️ System Architecture Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                         CLIENT LAYER                             │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐          │
│  │   Browser    │  │    Mobile    │  │   API Client │          │
│  │   (HTML/CSS) │  │   (Responsive)│  │   (REST)     │          │
│  └──────┬───────┘  └──────┬───────┘  └──────┬───────┘          │
└─────────┼──────────────────┼──────────────────┼─────────────────┘
          │                  │                  │
          └──────────────────┴──────────────────┘
                             │
                    ┌────────▼────────┐
                    │   WEB SERVER    │
                    │  (Nginx/Apache) │
                    └────────┬────────┘
                             │
          ┌──────────────────┴──────────────────┐
          │                                     │
    ┌─────▼─────┐                      ┌───────▼────────┐
    │   Static  │                      │   PHP-FPM      │
    │   Assets  │                      │   (PHP 8.2)    │
    │ (CSS/JS)  │                      └───────┬────────┘
    └───────────┘                              │
                                    ┌──────────▼──────────┐
                                    │  APPLICATION LAYER  │
                                    │                     │
                                    │  ┌───────────────┐  │
                                    │  │   Router      │  │
                                    │  │ (index.php)   │  │
                                    │  └───────┬───────┘  │
                                    │          │          │
                                    │  ┌───────▼───────┐  │
                                    │  │ Controllers   │  │
                                    │  │ - Home        │  │
                                    │  │ - API         │  │
                                    │  └───────┬───────┘  │
                                    │          │          │
                                    │  ┌───────▼───────┐  │
                                    │  │   Models      │  │
                                    │  │ - Video       │  │
                                    │  │ - Category    │  │
                                    │  │ - Ad          │  │
                                    │  │ - Database    │  │
                                    │  └───────┬───────┘  │
                                    │          │          │
                                    │  ┌───────▼───────┐  │
                                    │  │    Views      │  │
                                    │  │ - Templates   │  │
                                    │  └───────────────┘  │
                                    └──────────┬──────────┘
                                               │
                                    ┌──────────▼──────────┐
                                    │   DATA LAYER        │
                                    │                     │
                                    │  ┌───────────────┐  │
                                    │  │   SQLite DB   │  │
                                    │  │ - videos      │  │
                                    │  │ - categories  │  │
                                    │  │ - ads         │  │
                                    │  │ - users       │  │
                                    │  │ - config      │  │
                                    │  └───────────────┘  │
                                    └─────────────────────┘
```

## 📦 Component Architecture

### 1. Presentation Layer (Views)

**Purpose:** Render HTML templates with dynamic data

**Components:**
- `header.php` - Common header with navigation
- `footer.php` - Common footer
- `home.php` - Homepage with video grid
- `video.php` - Video player page
- `category.php` - Category listing page
- `search.php` - Search results page
- `404.php` - Error page

**Technologies:**
- PHP templating
- HTML5
- CSS3 (Custom styling)
- Vanilla JavaScript

### 2. Application Layer (Controllers)

**Purpose:** Handle HTTP requests and business logic

**Components:**

#### HomeController
```php
- index()          // Homepage with video listing
- video($id)       // Single video display
- category($slug)  // Category-filtered videos
- search()         // Search functionality
```

#### ApiController
```php
- videos()         // GET /api/videos
- video($id)       // GET /api/video/{id}
- categories()     // GET /api/categories
- search()         // GET /api/search
- latest()         // GET /api/latest
- popular()        // GET /api/popular
```

### 3. Business Logic Layer (Models)

**Purpose:** Data access and business rules

**Components:**

#### Database Model
- Singleton pattern for connection management
- PDO-based SQLite connection
- Query execution and error handling
- Transaction support

#### Video Model
```php
- getAll($limit, $offset)
- getById($id)
- getByCategory($category, $limit, $offset)
- search($keyword, $limit, $offset)
- getLatest($limit)
- getPopular($limit)
- incrementViews($id)
- create($data)
- update($id, $data)
- delete($id)
```

#### Category Model
```php
- getAll()
- getById($id)
- getBySlug($slug)
- create($data)
- update($id, $data)
- delete($id)
```

#### Advertisement Model
```php
- getByPosition($position)
- getAll()
- getById($id)
- create($data)
- update($id, $data)
- delete($id)
```

### 4. Data Layer (Database)

**Database:** SQLite (file-based)

**Schema:**

```sql
videos
├── id (PRIMARY KEY)
├── title
├── description
├── thumbnail
├── video_url
├── category
├── tags
├── views
├── duration
├── status
├── created_at
└── updated_at

categories
├── id (PRIMARY KEY)
├── name
├── slug (UNIQUE)
├── description
├── display_order
└── created_at

advertisements
├── id (PRIMARY KEY)
├── title
├── position
├── image_url
├── link_url
├── display_order
├── status
├── created_at
└── updated_at

users
├── id (PRIMARY KEY)
├── username (UNIQUE)
├── password
├── email
├── role
└── created_at

site_config
├── id (PRIMARY KEY)
├── config_key (UNIQUE)
├── config_value
└── updated_at
```

## 🔄 Request Flow

### Standard Page Request Flow

```
1. User Request
   ↓
2. Nginx/Web Server
   ↓
3. PHP-FPM
   ↓
4. index.php (Router)
   ↓
5. Controller (HomeController)
   ↓
6. Model (Video, Category, etc.)
   ↓
7. Database Query (SQLite)
   ↓
8. Data Processing
   ↓
9. View Rendering
   ↓
10. HTML Response
    ↓
11. Browser Display
```

### API Request Flow

```
1. API Request (GET /api/videos)
   ↓
2. Nginx/Web Server
   ↓
3. PHP-FPM
   ↓
4. index.php (Router)
   ↓
5. ApiController
   ↓
6. Model (Video)
   ↓
7. Database Query
   ↓
8. JSON Response
   ↓
9. Client Processing
```

## 🎯 Design Patterns Used

### 1. MVC (Model-View-Controller)
- **Model:** Data access and business logic
- **View:** Presentation layer (templates)
- **Controller:** Request handling and coordination

### 2. Singleton Pattern
- Database connection management
- Ensures single instance across application

### 3. Repository Pattern
- Models act as repositories for data access
- Abstraction layer over database operations

### 4. Front Controller Pattern
- Single entry point (index.php)
- Centralized request routing

## 🔐 Security Architecture

### Input Validation
- All user inputs sanitized
- SQL injection prevention via prepared statements
- XSS protection via output escaping

### Authentication (Future)
- Password hashing with bcrypt
- Session management
- Role-based access control

### Security Headers
```nginx
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
```

## 📊 Data Flow Diagrams

### Video Display Flow

```
User clicks video
    ↓
HomeController::video($id)
    ↓
Video::getById($id)
    ↓
Database query
    ↓
Video::incrementViews($id)
    ↓
Video::getByCategory() [related videos]
    ↓
Advertisement::getByPosition('sidebar')
    ↓
Render video.php template
    ↓
Display to user
```

### Search Flow

```
User enters search term
    ↓
HomeController::search()
    ↓
Video::search($keyword)
    ↓
Database LIKE query
    ↓
Results processing
    ↓
Render search.php template
    ↓
Display results
```

## 🚀 Deployment Architecture

### Docker Deployment

```
┌─────────────────────────────────────┐
│         Docker Container            │
│                                     │
│  ┌──────────────────────────────┐  │
│  │      Supervisor              │  │
│  │  ┌────────┐    ┌──────────┐ │  │
│  │  │ Nginx  │    │ PHP-FPM  │ │  │
│  │  └────┬───┘    └────┬─────┘ │  │
│  └───────┼─────────────┼────────┘  │
│          │             │            │
│  ┌───────▼─────────────▼────────┐  │
│  │    Application Files         │  │
│  │  - public/                   │  │
│  │  - src/                      │  │
│  │  - database/                 │  │
│  └──────────────────────────────┘  │
│                                     │
│  ┌──────────────────────────────┐  │
│  │    Volumes (Persistent)      │  │
│  │  - database/retool.db        │  │
│  │  - cache/                    │  │
│  │  - uploads/                  │  │
│  └──────────────────────────────┘  │
└─────────────────────────────────────┘
         │
         ↓ Port 80
    [Host Machine]
         ↓ Port 8080
    [Public Access]
```

## 📈 Scalability Considerations

### Current Architecture
- Single server deployment
- File-based SQLite database
- Suitable for small to medium traffic

### Future Scalability Options

1. **Database Migration:**
   - Move to MySQL/PostgreSQL
   - Enable read replicas
   - Implement connection pooling

2. **Caching Layer:**
   - Add Redis/Memcached
   - Cache database queries
   - Cache rendered pages

3. **Load Balancing:**
   - Multiple application servers
   - Nginx load balancer
   - Session sharing

4. **CDN Integration:**
   - Serve static assets via CDN
   - Video streaming optimization
   - Geographic distribution

## 🔧 Configuration Management

### Configuration Hierarchy

```
src/Config/config.php
    ↓
Environment Variables (optional)
    ↓
Runtime Configuration
```

### Key Configuration Areas
- Database connection
- Application settings
- Cache configuration
- Upload settings
- Security settings

## 📝 API Architecture

### RESTful Endpoints

```
GET  /api/videos              - List videos
GET  /api/video/{id}          - Get single video
GET  /api/categories          - List categories
GET  /api/search?q={keyword}  - Search videos
GET  /api/latest?limit={n}    - Latest videos
GET  /api/popular?limit={n}   - Popular videos
```

### Response Format

```json
{
    "success": true,
    "data": [...],
    "pagination": {
        "current_page": 1,
        "per_page": 24,
        "total": 100,
        "total_pages": 5
    }
}
```

## 🎨 Frontend Architecture

### Asset Organization

```
assets/
├── css/
│   └── style.css          - Main stylesheet
├── js/
│   └── main.js            - Main JavaScript
└── images/
    └── [static images]
```

### JavaScript Features
- Lazy image loading
- Search form enhancement
- Video card interactions
- Smooth scrolling
- API helper functions

## 📚 Technology Stack Summary

| Layer | Technology |
|-------|-----------|
| Frontend | HTML5, CSS3, Vanilla JavaScript |
| Backend | PHP 8.2 |
| Database | SQLite 3 |
| Web Server | Nginx / Apache |
| Containerization | Docker, Docker Compose |
| Process Manager | Supervisor |

---

**This architecture provides a solid foundation for a modern video platform with room for growth and enhancement.**