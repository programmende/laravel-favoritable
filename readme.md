# Favoritable

Favoritable is a package for Laravel that adds favoritable support for your models.

## Installation

### Step 1: Composer

From the command line, run:

```
composer require programmende/favoritable
```

### Step 2: Service Provider

For your Laravel app, open `config/app.php` and, within the `providers` array, append:

```
Programmende\Favoritable\FavoritableServiceProvider::class,
```

This will bootstrap the package into Laravel.

### Step 3: Migrate the database

Migrate the database to add the 'favorites' table

```
php artisan migrate
```

## Usage

### The Basics

With the package now installed, you may use the provided `favoritable` trait in your models, like so:

```php
<?php

namespace App;

use Programmende\Favoritable\Favoritable;

class Post extends Model
{
    use favoritable;

    ...
}
```
Now you have the following methods available for the model

```php
//returns true or  false in case of the actual logged in user has favoritet the given model
$model->isFavoritedBy();


//toggle the favorite status and returns true or false in case of the user has favoritet or unfavoritet the model
$model->favorite();

//returns the number of favorites for a given model
$model->favoritesCount();
```

### Scoping

You can scope the query to only return the models that are favorited by the given user
```php
$models = Model::FavoritedBy(User $user)->get();
```