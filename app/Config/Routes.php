<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
  require SYSTEMPATH . 'Config/Routes.php';
}

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

    $routes->group('recovery', function ($routes) {
      $routes->post('checkEmailAddress', 'Fendy\Auth\Recovery::checkEmailAddress');
      $routes->post('checkOTPCode', 'Fendy\Auth\Recovery::checkOTPCode');
      $routes->post('createNewPassword', 'Fendy\Auth\Recovery::createNewPassword');
    });

    $routes->group('activation', function ($routes) {
      $routes->get('confirmActivation', 'Fendy\Auth\Activation::confirmActivation');
      $routes->post('requestActivation', 'Fendy\Auth\Activation::requestActivation');
    });
  });

  /* Fendy Web API Routes */
  $routes->group('fendy', function ($routes) {
    // Akun Routes
    $routes->group('accounts', function ($routes) {
      $routes->get('/', 'Fendy\Admin\User\User');
      $routes->put('updatePersonalInformation', 'Fendy\Admin\User\User::updatePersonalInformation');
      $routes->put('updatePassword', 'Fendy\Admin\User\User::updatePassword');
      $routes->get('getCurrentPhotoProfile/(:num)', 'Fendy\Admin\User\UserPhoto::getCurrentPhotoProfile/$1');
      $routes->get('getAllPhotoProfile/(:num)', 'Fendy\Admin\User\UserPhoto::getAllPhotoProfile/$1');
      $routes->post('uploadPhotoProfile', 'Fendy\Admin\User\UserPhoto::uploadPhotoProfile');
    });

    // Berita Routes
    $routes->resource('categories', ['controller' => 'Fendy\Admin\Blog\Category']);
    $routes->resource('tags', ['controller' => 'Fendy\Admin\Blog\Tag']);
    $routes->resource('news', ['controller' => 'Fendy\Admin\Blog\News']);
    $routes->resource('comments', ['controller' => 'Fendy\Admin\Blog\Comment']);
    $routes->resource('messages', ['controller' => 'Fendy\Admin\Message']);

    // Wilayah Routes
    $routes->group('wilayah', function ($routes) {
      $routes->resource('provinsi', ['controller' => 'Fendy\Admin\Wilayah\Provinsi']);
      $routes->resource('kabupatenKota', ['controller' => 'Fendy\Admin\Wilayah\KabupatenKota']);
      $routes->resource('kecamatan', ['controller' => 'Fendy\Admin\Wilayah\Kecamatan']);
      $routes->resource('kelurahanDesa', ['controller' => 'Fendy\Admin\Wilayah\KelurahanDesa']);
    });
  });

  $routes->group('blog', function ($routes) {
    $routes->get('categories', 'Fendy\Admin\Blog\Category');
    $routes->get('categories/(:num)', 'Fendy\Admin\Blog\Category::show/$1');
    $routes->get('tags', 'Fendy\Admin\Blog\Tag');
    $routes->get('tags/(:num)', 'Fendy\Admin\Blog\Tag::show/$1');
    $routes->get('news', 'Fendy\Admin\Blog\News');
    $routes->get('news/(:num)', 'Fendy\Admin\Blog\News::show/$1');
    $routes->get('news/category/(:any)', 'Fendy\Admin\Blog\News::getDataByCategory/$1');
    $routes->get('comments', 'Fendy\Admin\Blog\comment');
    $routes->get('comments/(:num)', 'Fendy\Admin\Blog\comment::show/$1');
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
  require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}