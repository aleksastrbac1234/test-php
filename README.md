# User Activity Tracker

PHP app for tracking user activity.

## Requirements

- PHP 8.1+
- MySQL

## Setup

```
mysql -u root -p < database/schema.sql
cp config/config.example.php config/config.php
php database/seed.php
php -S localhost:8000 -t public public/index.php
```
If your MySQL user or password is different, update `config/config.php` before running the seed. Then open http://localhost:8000.

Open http://localhost:8000
