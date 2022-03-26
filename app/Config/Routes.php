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
    $routes->add('accounts', 'Fendy\Akun\User');

    // Berita Routes
    $routes->resource('categories', ['controller' => 'Fendy\Berita\Categories']);
    $routes->resource('tags', ['controller' => 'Fendy\Berita\Tags']);
    $routes->resource('news', ['controller' => 'Fendy\Berita\News']);
    $routes->resource('comments', ['controller' => 'Fendy\Berita\Comments']);
    $routes->resource('messages', ['controller' => 'Fendy\Messages']);

    // Wilayah Routes
    $routes->group('wilayah', function ($routes) {
      $routes->resource('provinsi', ['controller' => 'Fendy\Wilayah\Provinsi']);
      $routes->resource('kabupatenKota', ['controller' => 'Fendy\Wilayah\Kabupatenkota']);
      $routes->resource('kecamatan', ['controller' => 'Fendy\Wilayah\Kecamatan']);
      $routes->resource('kelurahanDesa', ['controller' => 'Fendy\Wilayah\Kelurahandesa']);
    });
  });

  $routes->group('blog', function ($routes) {
    $routes->get('categories', 'Blog::categories');
    $routes->get('tags', 'Blog::tags');
    $routes->get('news', 'Blog::news');
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