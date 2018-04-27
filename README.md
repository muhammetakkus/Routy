# Routy
Simple Routing and View System for PHP Projects

# Install
```
composer require cooky/url-router
```
# For Nginx - default_nginx.conf
```
root your_project_dir

location ~ \.css {
    add_header  Content-Type    text/css;
}
location ~ \.js {
    add_header  Content-Type    application/x-javascript;
}
location ~ \.ico {
    add_header  Content-Type    application/x-icon;
}
location / {
    rewrite ^(.*)$ /index.php/$1 last;
}
```

# For Apache - .htaccess
```
RewriteEngine On
RewriteRule ^(.*)$ index.php/$1 [QSA,L]
```
# Configration
*vendor/cooky/url-router/config/configs/*

# Router Usage
```php
/* main index.php */
require_once 'vendor/autoload.php';

/* */
use Routy\Route;

/* basic get */
Route::get('/', function (){
    echo '<h2>home page</h2>';
});

/* controller */
Route::get('/home', 'Home@Index');

/* with parameter */
Route::get('user/profile/{id}', 'User@Profile');

Route::post('test/post/{id}', function ($id){
    echo $id;
});

Route::complete();
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

    <!-- pass data from controller -->
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
```

# Controller
```php
<?php use View\Loader;

/* Home controller - every controller must be extends with Loader for view */
class Home extends Loader
{
    public function index(){
        $data['test'] = 'hello kitty';
        $this->view('main', $data);
    }
}
```
