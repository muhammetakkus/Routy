# Routy
Simple Routing System for PHP Projects

# Install
```
composer require mak/routy
```
# Usage
```php
require_once "vendor/autoload.php";

use Routy\Routy;

/**/
Routy::get("/", function (){
    echo "<h2>home page</h2>";
});

Routy::post("test/post/{id}", function ($id){
    echo $id;
});

Routy::get("admin/user/{id}/name/{username}", "Admin@Index");
/**/

Routy::check();
```

if your project inside a dir like host/dire/project you must set like this
```php
define("BASE_DIR", "your_dir_name");
```
