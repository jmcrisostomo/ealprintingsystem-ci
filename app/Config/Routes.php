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
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/login', 'Home::login');
$routes->get('/products', 'Home::products');
$routes->get('/about', 'Home::about');

// Auth
$routes->post('/auth/login', 'Auth::login');
$routes->post('/auth/loginTest', 'Auth::loginTest');
$routes->get('/auth/logout', 'Auth::logout');


//Admin
// $routes->get('/admin', 'Admin::index');
// $routes->get('/admin/dashboard', 'Admin::dashboard');


$routes->group('', ['filter' => 'checkSessionAdmin'], function ($routes){
    $routes->get('/admin', 'Admin::index');
    $routes->get('/admin/dashboard', 'Admin::dashboard');
    
    // PRODUCT FUNCTIONS
    $routes->get('/admin/product', 'Admin::show_product');

    $routes->post('/admin/product/add', 'Product::create_product');
    // $routes->get('/admin/product_test/add', 'Test::create');
    $routes->get('/admin/product/all', 'Product::read_product');
    $routes->get('/admin/product/(:num)', 'Product::read_product_detail/$1');
    $routes->post('/admin/product/edit', 'Product::update_product');
    $routes->post('/admin/product/remove', 'Product::delete_product');
    $routes->post('/admin/product/disable', 'Product::disable_product');
    $routes->post('/admin/product/enable', 'Product::enable_product');
    
    // CATEGORY FUNCTIONS
    $routes->get('/admin/category', 'Admin::show_product_category');
    
    $routes->get('/admin/category/all', 'Category::read_category');
    $routes->get('/admin/category/(:num)', 'Category::read_category_detail/$1');
    $routes->post('/admin/category/add', 'Category::create_category');
    $routes->post('/admin/category/edit', 'Category::update_category');
    $routes->post('/admin/category/remove', 'Category::delete_category');
    
    
    $routes->get('/products/(:any)', 'Home::products_single/$1');
    
    $routes->post('/product/add-to-cart', 'Product::add_to_cart');

    $routes->get('/cart', 'Home::cart');

});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
