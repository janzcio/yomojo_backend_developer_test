# Yomojo Backend Developer Test
Laravel REST API with OAuth2 Authentication

# SETUP GUIDE

### Clone the project

```bash
https - https://github.com/janzcio/yomojo_backend_developer_test.git
ssh - git@github.com:janzcio/yomojo_backend_developer_test.git
```

check out the project
```bash
cd yomojo_backend_developer_test
```

Php version should be `php >8.2` above

Run composer
```bash
composer install
```

### Connection guide
Config your connection or create `.env` file.
```bash
cp .env.example .env
php artisan key:generate
```
Create a `database` file the same database name value in your `.env` file for your connection 


Config your connection or create `.env.testing` file for testing.
```bash
cp .env .env.testing
php artisan key:generate --env=testing
```
Create a `database` file the same database name value in your `.env.testing` file for your connection in testing 


### Run this to run project init
```bash
php artisan app:project-init
```


Run npm install for the doc UI
```bash
npm install
```


### Run the project
```bash
php artisan serve
```

### Run the test
```bash
php artisan test
```

### API Reference


##### Visit the auto generated docs
```bash
http://127.0.0.1:8000/docs
```

You can also import the json file to your machine 
located in root named `postman`.
