# Routy
Simple Routing System for PHP Projects

# Install
```
composer require cooky/url-router (or url-router=dev-master)
```

# Settings
-set your controller path in `vendor/cooky/url-router/src/config.php`

# Usage
```php
//
require_once "vendor/autoload.php";

//
use Routy\Route;

/* basic get */
Routy::get("/", function (){
    echo "<h2>home page</h2>";
});

/* get with parameter */
Routy::get("user/profile/{id}", "User@Profile");

/* post with parameter */
Routy::post("test/post/{id}", function ($id){
    echo $id;
});

/* more complicated */
Routy::get("admin/user/{id}/name/{username}", "Admin@Index");

//
Routy::check();
```

-if you want to redirect to a non-existent router
```php
if (!Routy::check()){
    //redirect
}
```

this usage overlaps and work in both
```php
Routy::get("user/profile/{id}", "TestOne@Index");
Routy::get("user/profile/x", "TestTwo@Index");
```