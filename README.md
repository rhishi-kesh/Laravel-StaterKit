<p align="center">
    <h1 align="center">Laravel Stater Kit</h1>
</p>

## Introduction

<p> A Laravel stater kit with a awesome admin panel setup, user login & logout, registation, status, delete, profile settings and system information CRUD. </p>

## Contributor

-   <a href="https://github.com/rhishi-kesh" target="_blank">Rhishi kesh</a>

## Installation

To Install & Run This Project You Have To Follow Thoose Following Steps:

```sh
git clone https://github.com/rhishi-kesh/Laravel-StaterKit.git
```

```sh
cd Laravel-StaterKit
```

```sh
npm install
```

```sh
composer install
```

Open your `.env` file and change the database name (`DB_DATABASE`) to whatever you have, username (`DB_USERNAME`) and password (`DB_PASSWORD`) field correspond to your configuration

```sh
php artisan key:generate
```

```sh
php artisan migrate
```

```sh
php artisan storage:link
```

```sh
php artisan db:seed
```
Open `app/Providers/AppServiceProvider.php` file and uncomment the following text
<p>
// view()->share('systemInformation', SystemInformation::first());
</p>

```sh
php artisan optimize
```

```sh
npm run dev
```
Open another tab and run below command

```sh
php artisan serve
```
For Admin Login `http://127.0.0.1:8000/admin` <br>
Admin gmail = `admin@gmail.com` & password = `admin`
