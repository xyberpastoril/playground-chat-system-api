# [Playground] - Chat System - API

This is the backend side of my own implementation of a chat system.

## Requirements
- PHP Version = 8.1
- MySQL = 8.1.12

## Setup Instructions
### 1. Clone GitHub repo for this project locally.
```
git clone https://github.com/xyberpastoril/playground-chat-system-api.git
```

### 2. `cd` into the `playground-chat-system-api` project.
```
cd playground-chat-system-api
```

### 3. Install Composer Packages required for this project.
```
composer install
```

### 4. Create a copy of `.env` file from `.env.example`. 
The `.env.example` file is already filled with default database information including the name of the database `helpinghand`.
```
cp .env.example .env
```

### 5. Generate an application encryption key.
```
php artisan key:generate
```

### 6. Create an empty database named `playground-chat-system-api`.
This can be done by opening XAMPP, run Apache and MySQL, then create a database to phpMyAdmin.

### 7. Update `.env` values when necessary (Optional)
Just in case your database server's configuration is different from the default `root` and blank password, or the name of the database, you may reflect those changes to the `.env` file.

### 8. Migrate and seed the database.
```
php artisan migrate --seed
```

### 9. Finally, run the app server.
```
php artisan serve
```
