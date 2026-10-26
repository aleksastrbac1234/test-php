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
`mysql -u root -p` asks for your MySQL password. If your root user has no password, just press Enter.

## Test accounts

The seed script creates these accounts (password for all is `password`):

- Admin: `admin@example.com`
- Users: `john@example.com`, `emma@example.com`, `luka@example.com`

Running the seed again deletes all data and creates it from scratch, so log in again after running it.