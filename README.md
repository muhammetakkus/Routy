# Routy
Simple Routing System for PHP Projects
[![GitHub release](https://img.shields.io/github/release/qubyte/rubidium.svg)]()

# Install
```
composer require cooky/url-router
```
# For Nginx - your_nginx.conf
```
root your_project_dir
location / {
    rewrite ^(.*)$ /index.php/$1 last;
}
```

# For Apache - .htaccess
```
RewriteEngine On
RewriteRule ^(.*)$ index.php/$1 [QSA,L]
```

# Router Usage
```php
/* main index.php */
require_once 'vendor/autoload.php';

/* CONFIG */
use Routy\Config;
(new Config())->set([
    'controller' => 'app/my_controller_path',
    'view' => 'app/my_views'
]);

/* */
use Routy\Route;

/* basic get */
Route::get('/', function (){
    echo '<h2>home page</h2>';
});

Route::get('/', 'Home@Index');

/* get with parameter */
Route::get('user/profile/{id}', 'User@Profile');

/* post with parameter */
Route::post('test/post/{id}', function ($id){
    echo $id;
});
```
# Templating
```php
/* layout.php */
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/default.css">
    <!-- Custom Css -->
    @yield(css)

    <title>routy basic templating</title>
</head>
<body>

    <!-- NAV -->
    <nav>NAV</nav>

    <!-- Dynamic Content -->
    @yield(content)

    <!-- FOOTER -->
    <footer>FOOTER</footer>

    <script src="node_modules/vue/dist/vue.js"></script>
    <!-- Dynamic Script -->
    @yield(script)
</body>
</html>

/* home.php */
<?php include "layout.php"; ?>

@section(css)
    <link rel="stylesheet" href="css/home.css">
@stop

@section(content)
    <div class="container" id="app">
        {{message}}
    </div>

    <!-- pass data -->
    <div><?php echo $test; ?></div>
@stop

@section(script)
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                message: 'Hello Vue!'
            }
        })
    </script>
@stop

/* Home controller - ever controller must be extends with Loader for view */
<?php use View\Loader;
class Home extends Loader
{
    public function index(){
        $data['test'] = 'hello kitty';
        $this->view('main', $data);
    }
}
```

this usage overlaps and the first one works so not recommended
```php
Routy::get('user/profile/{id}', 'TestOne@Index');
Routy::get('user/profile/test', 'TestTwo@Index');
```