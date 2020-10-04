# Get started
1. Create file .env connect database
```
APP_NAME=TechnicalTest
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={database_name}
DB_USERNAME={database_user_name}
DB_PASSWORD={database_password}
```
2. run migration
```
php artisan migrate
```
3. run seed
```
php artisan db:seed --class=UserTypeSeeder
php artisan db:seed --class=UserSeeder
```
4. run local server
```
php artisan serve
```
