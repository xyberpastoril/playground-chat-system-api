# Helping Hand - API

This is the backend side of an experimental labor services booking system. It is inspired from the growth of businesses like Grab, Shopee that offer delivery services in different industries.

## Requirements
- PHP Version = 8.1 
- MySQL = 8.1.12

(may be supported in older/newer versions but not tested)

## Setup Instructions
### 1. Clone GitHub repo for this project locally.
```
git clone https://github.com/xyberpastoril/helpinghand-api.git
```

### 2. `cd` into the `helpinghand-api` project.
```
cd helpinghand-api
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

### 6. Create an empty database named `helpinghand`.
This can be done by opening XAMPP, run Apache and MySQL, then create a database to phpMyAdmin.

### 7. Update `.env` values when necessary (Optional)
Just in case your database server's configuration is different from the default `root` and blank password, or the name of the database, you may reflect those changes to the `.env` file.

### 8. Update `max_allowed_packet` and `net_buffer_length` values in MySQL. This can be done through phpMyAdmin. This is required for the `BarangaySeeder` to work.
```
set global net_buffer_length=1000000; 
set global max_allowed_packet=1000000000;
```
Reference: [Link](https://www.grepper.com/answers/282282/ERROR+1153+%2808S01%29+at+line+446%3A+Got+a+packet+bigger+than+%27max_allowed_packet%27+bytes)

### 9. Migrate and seed the database.
```
php artisan migrate --seed
```

### 10. Install Laravel Passport.
```
php artisan passport:install
```

### 11. Finally, run the app server.
```
php artisan serve
```

---

### For the users to receive emails (for testing in Mailtrap.io), kindly run this command. It works similarly as `php artisan serve`.
```
php artisan queue:work
```
