<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



//webadmin
$route['webadmin'] = "App/dashboard";
$route['webadmin/login'] = "App/auth/auth/login";
$route['webadmin/([a-z]+)'] = "App/$1";
$route['webadmin/([a-z]+)/(:any)'] = "App/$1/$2";
$route['webadmin/([a-z]+)/(:any)/(:any)'] = "App/$1/$2/$3";
$route['webadmin/([a-z]+)/(:any)/(:any)/(:any)'] = "App/$1/$2/$3/$4";
$route['webadmin/([a-z]+)/(:any)/(:any)/(:any)/(:any)'] = "App/$1/$2/$3/$4/$5";

// contact
$route['contact-us'] = "home/contact";

// maichimp
$route['mailchimp'] = "home/mailchimp";

// event
$route['events/detail/(:any)'] = "store/events/index/$1";
$route['events/all-events'] = "store/events/all_events";
$route['events/all-events/(:any)'] = "store/events/all_events/$1";
$route['events-search'] = "store/events/search_events";
$route['events-search-ajax'] = "store/events/search_events_ajax";
$route['events-groups/(:any)/(:any)'] = "store/events/events_group/$1/$2";
$route['events-groups/(:any)/(:any)/(:any)'] = "store/events/events_group/$1/$2/$3";
$route['events-type/(:any)/(:any)'] = "store/events/events_type/$1/$2";
$route['events-type/(:any)/(:any)/(:any)'] = "store/events/events_type/$1/$2/$3";



// articles
$route['articles/detail/(:any)'] = "store/articles/index/$1";
$route['articles/all-articles'] = "store/articles/all_articles";
$route['articles/all-articles/(:any)'] = "store/articles/all_articles/$1";
$route['articles/category/(:any)'] = "store/articles/category_articles/$1";
$route['articles/category/(:any)/(:any)'] = "store/articles/category_articles/$1/$2";

// shopping cart
$route['events-cart']               = "store/cart/index";
$route['events-show-cart-sweet']    = "store/cart/show_cart_sweet";
$route['events-add-cart']           = "store/cart/add_cart";
$route['events-update-cart']        = "store/cart/update_cart";
$route['events-remove-cart']        = "store/cart/remove_cart";

// promotions
$route['events-apply-voucher']                      = "store/cart/apply_voucher";
$route['promotions/all-promotions']                 = "store/promotions/all_promotions";
$route['promotions/all-promotions/(:any)']          = "store/promotions/all_promotions/$1";
$route['promotions/detail-promotion/(:any)']        = "store/promotions/detail_promotions/$1";
$route['promotions/detail-promotion/(:any)/(:any)'] = "store/promotions/detail_promotions/$1/$2";


$route['shopping-cart/save']    = "store/shopping_cart/save";
$route['shopping-cart/update']  = "store/shopping_cart/update";
$route['shopping-cart/save-collectible-voucher']  = "store/shopping_cart/save_collectible_voucher";


// users
$route['account/login'] = "store/users/users/login";
$route['account/register'] = "store/users/users/register";
$route['account/lost-password'] = "store/users/users/lost_password";

$route['users/email_activation'] = "store/users/users/send_email";
$route['users/email_confirmation/(:any)/(:any)'] = "app/auth/auth/activate/$1/$2";

$route['users/dashboard'] = "store/users/dashboard";
$route['users/dashboard/(:any)'] = "store/users/dashboard/$1";
$route['users/dashboard/(:any)/(:any)'] = "store/users/dashboard/$1/$2";
$route['users/dashboard/(:any)/(:any)/(:any)'] = "store/users/dashboard/$1/$2/$3";

$route['users/profile'] = "store/users/dashboard/profile";
$route['members'] = "store/users/dashboard/members";
$route['members-edit/(:any)'] = "store/users/dashboard/edit_members/$1";

//auth users front
$route['account/auth/login'] = 'app/auth/auth/login';
$route['account/auth/register'] = 'app/auth/auth/create_user';
$route['account/auth/logout'] = 'app/auth/auth/logout';
$route['socialconnect/auth/(.+)'] = 'store/users/connect/index/$1';

