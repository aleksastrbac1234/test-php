# User Activity Tracker

Simple app in vanilla PHP for tracking user activity.

## Requirements

- PHP 8.1+ (pdo_mysql)
- MySQL

## Setup

```
mysql -u root -p < database/schema.sql
cp config/config.example.php config/config.php
php -S localhost:8000 -t public public/index.php
```

Open http://localhost:8000
