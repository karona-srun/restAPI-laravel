## Installing 
```text
clone project and then run cmd "composer install"
```


## Prepare Database
```text 
cp .env.example .env
vim .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Database_Name
DB_USERNAME=root
DB_PASSWORD=xxx


php artisan key:generate
php artisan migrate
php artisan jwt:secret

We have successfully generated the JWT Secret key, and you can check this key inside the .env file.

JWT_SECRET=secret_jwt_string_key
```

## Any update we have to run optimize 
```text 
php artisan optimize
```