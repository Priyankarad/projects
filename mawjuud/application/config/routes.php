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
$route['reset_password/(:any)'] = 'user/resetPassword/$1';
$route['myaccount'] = 'user/myaccount';
$route['agents'] = 'user/agentList';
$route['add_property'] = 'property/toAddProperty';
$route['update_property'] = 'property/toUpdateProperty';
$route['search_properties'] = 'property/toSearchProperty';
$route['single_property'] = 'property/singlePropertyDetails';
$route['my_properties'] = 'property/myProperties';
$route['favourite_properties'] = 'property/favouriteProperties';
$route['compare_properties'] = 'property/compareProperties';
$route['hidden_properties'] = 'property/hiddenProperties';
$route['notification'] = 'user/notificationSettings';
$route['agent_info'] = 'user/agentDetails';
$route['accessibility'] = 'settings/accessibility';
$route['contact_us'] = 'settings/contactUs';
$route['privacy_policy'] = 'settings/privacyPolicy';
$route['terms_and_conditions'] = 'settings/termsConditions';
$route['cookie_policy'] = 'settings/cookiePolicy';
$route['edit_property'] = 'property/editProperty';

/*Admin*/
$route['siteadmin'] = 'admin/home';
$route['dashboard'] = 'admin/home/dashboard';
$route['adusers'] = 'admin/user';
$route['adagents'] = 'admin/user/agentList';
$route['user_edit/(:any)'] = 'admin/user/userUpdate/$1';
$route['agent_edit/(:any)'] = 'admin/user/agentUpdate/$1';
$route['afavourite_property'] = 'admin/property/favouriteProperty';
$route['scheduled_tours'] = 'admin/property/scheduledTours';
$route['listings'] = 'admin/property/listing';
$route['asearch_property'] = 'admin/property/searchedProperty';
$route['enquiries_rent'] = 'admin/property/totalEnquiriesRent';
$route['enquiries_sale'] = 'admin/property/totalEnquiriesSale';
$route['source_feeds'] = 'admin/settings/sourceFeed';
$route['add_feed'] = 'admin/settings/addFeed';
$route['edit_feed/(:any)'] = 'admin/settings/editFeed/$1';
$route['page_settings'] = 'admin/settings/pageSettingsList';
$route['page_edit/(:any)'] = 'admin/settings/pageEdit/$1';
$route['profile'] = 'admin/home/updateProfile';
$route['property_edit/(:any)'] = 'admin/property/propertyEdit/$1';
$route['property_update'] = 'admin/property/updateProperty';

