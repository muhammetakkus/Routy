<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

/*  */
require '../vendor/autoload.php';

use Routy\Route;
/* Route::get('/', function(){
    echo '</br>welcome to index</br>';
});
 */
Route::get('/test', function(){
    echo 'test route runned';
});
 
Route::get('/', 'Home@Index');

/* Route::get('test', 'Home@Index');
Route::get('test/{asd}', 'Home@Index');
Route::get('test/{asd}/{id}', 'Home@Index'); */

/*Route::config([
    'base_url' => 'http://localhost:80/routy/',
    '404' => ''
]);*/

// exploda temizlenmiş urı ve route vermeli
$test = explode('/', 'test');
echo "<pre>";
//print_r($test);
echo "</pre>";
//echo count($test);
/*

test/id/{2}  test/id/ | test/id/1
test/id      test/id
test/id/     test/id
- eğer route parametresiz ise route'ı slashlardan her türlü arındır
- eğer route parametreli ise route'ın parametrelerden ayrılmış halinin sonuna / koy ve uri ile match et

parametreli rout'ı clean eden fonk. ->  if / veya '' ise  return / else trim(val) . /

*/


/* fonksiyona parametre göndermeli - bğtğn uri lerin sonuna / koydun? eğer son karakter / ise temizle ve/ koy
route /{slug}
uri /
segment  1 - 1 | segment parametreli üzerinden yapılıyor 

 eşleşmez 
route /test/
uri /test
segment 1 - 1


 eşleşir 
route test/
uri test/

 eşleşir ve boş parametre gönderilir
route test/{slug}
uri test/

 eşleşmez 
route test/{slug}
uri test 

*/

// bunu packagiste yenile ve composer.json dan kaldır tekrar require et
// vendor sil tekrar update et
// Routy Route olarak değişecek