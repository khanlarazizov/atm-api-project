<h1 align="center">
ATM MANAGEMENT API
</h1>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Install

Clone repo

```
git clone https://github.com/khanlarazizov/atm-api-project
```

Install Composer

[Download Composer](https://getcomposer.org/download/)

composer update/install

```
composer install
```

Install Nodejs

[Download Node.js](https://nodejs.org/en/download/)

NPM dependencies

```
npm install
```

Run Vite

```
npm run dev

```

Run the migration and seed(for seeding users and banknotes)

```
php artisan migrate --seed
```

## API Docs

```
/docs/atm-project.json
```

## Roles

User:
````
    -see own account, transactions
    -withdraw money
````
Special user can:
````
    -see own account, transactions
    -withdraw money
    -delete own transactions
````
Admin:
````
    -add banknotes
````
## For testing:

User profile:

```
    'account_number' => '1234567890123452',
    'pin' => '1234'
```

Special user profile:

```
    'account_number' => '1234567890123453',
    'pin' => '1234'
```

Admin profile:

```
    'account_number' => '1234567890123451',
    'pin' => '1234'
```

