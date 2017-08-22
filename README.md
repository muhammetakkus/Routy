# Routy
Simple Routing System for PHP Projects

# Install
```
composer require mak/routy
```
# Usage
```php
//
require_once "vendor/autoload.php";

//
use Routy\Routy;

/* basic get */
Routy::get("/", function (){
    echo "<h2>home page</h2>";
});

/* post with parameter */
Routy::post("test/post/{id}", function ($id){
    echo $id;
});

/* post with parameter */

/* complicated */
Routy::get("admin/user/{id}/name/{username}", "Admin@Index");

//
Routy::check();
```

if your project inside a dir like this
```
host/dir/project
```
you must define BASE_DIR
```php
define("BASE_DIR", "your_dir_name");
```
