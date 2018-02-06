# Routy
Simple Routing System for PHP Projects

# Install
```
composer require cooky/url-router
```

# Usage
```php
//
require_once "vendor/autoload.php";

//
use Routy\Route;

/* basic get */
Route::get("/", function (){
    echo "<h2>home page</h2>";
});

/* get with parameter */
Route::get("user/profile/{id}", "User@Profile");

/* post with parameter */
Route::post("test/post/{id}", function ($id){
    echo $id;
});
```

this usage overlaps and work in both
```php
Routy::get("user/profile/{id}", "TestOne@Index");
Routy::get("user/profile/test", "TestTwo@Index");
```