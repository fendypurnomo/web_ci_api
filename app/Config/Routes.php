<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {require SYSTEMPATH . 'Config/Routes.php';}

/*
|--------------------------------------------------------------------
| Router Setup
|--------------------------------------------------------------------
*/
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override('App\Controllers\Fendy\Pagenotfound::index');
$routes->setAutoRoute(false);

/*
|--------------------------------------------------------------------
| Route Definitions
|--------------------------------------------------------------------
*/
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('mac', 'Fendy\Mac');

$routes->group('/', function ($routes) {
  // Autentikasi Routes
  $routes->group('auth', function ($routes) {
    $routes->post('signin', 'Fendy\Auth\Signin');
    $routes->post('signup', 'Fendy\Auth\Signup');
    $routes->post('recovery', 'Fendy\Auth\Recovery');
    $routes->add('activation', 'Fendy\Auth\Activation');
  });

  /* Fendy Web API Routes */
  $routes->group('fendy', function ($routes) {
    // Akun Routes
    $routes->add('accounts', 'Fendy\Admin\Akun\User');

    // Berita Routes
    $routes->resource('categories', ['controller' => 'Fendy\Admin\Berita\Category']);
    $routes->resource('tags', ['controller' => 'Fendy\Admin\Berita\Tag']);
    $routes->resource('news', ['controller' => 'Fendy\Admin\Berita\News']);
    $routes->resource('comments', ['controller' => 'Fendy\Admin\Berita\Comment']);
    $routes->resource('messages', ['controller' => 'Fendy\Admin\Message']);

    // Wilayah Routes
    $routes->group('wilayah', function ($routes) {
      $routes->resource('provinsi', ['controller' => 'Fendy\Admin\Wilayah\Provinsi']);
      $routes->resource('kabupatenKota', ['controller' => 'Fendy\Admin\Wilayah\Kabupatenkota']);
      $routes->resource('kecamatan', ['controller' => 'Fendy\Admin\Wilayah\Kecamatan']);
      $routes->resource('kelurahanDesa', ['controller' => 'Fendy\Admin\Wilayah\Kelurahandesa']);
    });
  });

  $routes->group('blog', function ($routes) {
    $routes->get('categories', 'Fendy\Admin\Berita\Category');
    $routes->get('categories/(:num)', 'Fendy\Admin\Berita\Category::show/$1');
    $routes->get('tags', 'Fendy\Admin\Berita\Tag');
    $routes->get('tags/(:num)', 'Fendy\Admin\Berita\Tag::show/$1');
    $routes->get('news', 'Fendy\Admin\Berita\News');
    $routes->get('news/(:num)', 'Fendy\Admin\Berita\News::show/$1');
    $routes->get('comments', 'Fendy\Admin\Berita\comment');
    $routes->get('comments/(:num)', 'Fendy\Admin\Berita\comment::show/$1');
    $routes->post('messages', 'Fendy\Admin\Message::create');

    $routes->group('wilayah', function ($routes) {
      $routes->get('provinsi', 'Fendy\Admin\Wilayah\Provinsi');
      $routes->get('provinsi/(:num)', 'Fendy\Admin\Wilayah\Provinsi::show/$1');
      $routes->get('kabupatenKota', 'Fendy\Admin\Wilayah\KabupatenKota');
      $routes->get('kabupatenKota/(:num)', 'Fendy\Admin\Wilayah\KabupatenKota::show/$1');
      $routes->get('kecamatan', 'Fendy\Admin\Wilayah\Kecamatan');
      $routes->get('kecamatan/(:num)', 'Fendy\Admin\Wilayah\Kecamatan::show/$1');
      $routes->get('kelurahanDesa', 'Fendy\Admin\Wilayah\KelurahanDesa');
      $routes->get('kelurahanDesa/(:num)', 'Fendy\Admin\Wilayah\KelurahanDesa::show/$1');
    });
  });

  /* Bezkoder Web API Routes */
  $routes->group('bezkoder', function ($routes) {
    $routes->resource('crud', ['controller' => 'Bezkoder\Crud']);
    $routes->get('jwtauth/all', 'Bezkoder\JwtAuth::all');
    $routes->get('jwtauth/user', 'Bezkoder\JwtAuth::user');
    $routes->get('jwtauth/mod', 'Bezkoder\JwtAuth::mod');
    $routes->get('jwtauth/admin', 'Bezkoder\JwtAuth::admin');
    $routes->post('jwtauth/signin', 'Bezkoder\JwtAuth::signin');
    $routes->post('jwtauth/signup', 'Bezkoder\JwtAuth::signup');
  });

  /* Positronx Web API Routes */
  $routes->group('positronx', function ($routes) {
    $routes->resource('pagination', ['controller' => 'Positronx\Pagination']);
  });

  /* Watmore Web API Routes */
  $routes->group('watmore', function ($routes) {
    $routes->resource('reactiveforms', ['controller' => 'Watmore\ReactiveForms']);
  });
});

/*
|--------------------------------------------------------------------
| Additional Routing
|--------------------------------------------------------------------
|
| There will often be times that you need additional routing and you
| need it to be able to override any defaults in this file. Environment
| based routes is one such time. require() additional route files here
| to make that happen.
|
| You will have access to the $routes object within that file without
| needing to reload it.
*/
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';}