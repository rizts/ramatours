<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
  |    example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

$route['default_controller'] = "welcome";
// Master link url
$route["staffs/(:num)/families/index"] = "families/index";
$route["staffs/(:num)/families/index/(:num)"] = "families/index";
$route["staffs/(:num)/families/add"] = "families/add";
$route["staffs/(:num)/families/edit/(:num)"] = "families/edit/";
$route["staffs/(:num)/families/delete/(:num)"] = "families/delete";
$route["staffs/(:num)/families/save"] = "families/save";
$route["staffs/(:num)/families/update"] = "families/update";

$route["staffs/(:num)/educations/index"] = "educations/index";
$route["staffs/(:num)/educations/index/(:num)"] = "educations/index";
$route["staffs/(:num)/educations/add"] = "educations/add";
$route["staffs/(:num)/educations/edit/(:num)"] = "educations/edit";
$route["staffs/(:num)/educations/delete/(:num)"] = "educations/delete";
$route["staffs/(:num)/educations/save"] = "educations/save";
$route["staffs/(:num)/educations/update"] = "educations/update";

$route["staffs/(:num)/work_histories/index"] = "work_histories/index";
$route["staffs/(:num)/work_histories/index/(:num)"] = "work_histories/index";
$route["staffs/(:num)/work_histories/add"] = "work_histories/add";
$route["staffs/(:num)/work_histories/edit/(:num)"] = "work_histories/edit";
$route["staffs/(:num)/work_histories/delete/(:num)"] = "work_histories/delete";
$route["staffs/(:num)/work_histories/save"] = "work_histories/save";
$route["staffs/(:num)/work_histories/update"] = "work_histories/update";

$route["staffs/(:num)/medical_histories/index"] = "medical_histories/index";
$route["staffs/(:num)/medical_histories/index/(:num)"] = "medical_histories/index";
$route["staffs/(:num)/medical_histories/add"] = "medical_histories/add";
$route["staffs/(:num)/medical_histories/edit/(:num)"] = "medical_histories/edit";
$route["staffs/(:num)/medical_histories/delete/(:num)"] = "medical_histories/delete";
$route["staffs/(:num)/medical_histories/save"] = "medical_histories/save";
$route["staffs/(:num)/medical_histories/update"] = "medical_histories/update";

$route["staffs/(:num)/salary_components/index"] = "salary_components/index";
$route["staffs/(:num)/salary_components/index/(:num)"] = "salary_components/index";
$route["staffs/(:num)/salary_components/add"] = "salary_components/add";
$route["staffs/(:num)/salary_components/edit/(:num)"] = "salary_components/edit";
$route["staffs/(:num)/salary_components/delete/(:num)"] = "salary_components/delete";
$route["staffs/(:num)/salary_components/save"] = "salary_components/save";
$route["staffs/(:num)/salary_components/update"] = "salary_components/update";

// Assets
$route["assets/(:num)/details/index"] = "assets_details/index";
$route["assets/(:num)/details/index/(:num)"] = "assets_details/index";
$route["assets/(:num)/details/add"] = "assets_details/add";
$route["assets/(:num)/details/edit/(:num)"] = "assets_details/edit";
$route["assets/(:num)/details/delete/(:num)"] = "assets_details/delete";
$route["assets/(:num)/details/save"] = "assets_details/save";
$route["assets/(:num)/details/update"] = "assets_details/update";
$route["assets/(:num)/details/report"] = "assets_details/report";

// Assets Transaction
$route["assets/(:num)/handover/index"] = "assets_handover/index";
$route["assets/(:num)/handover/index/(:num)"] = "assets_handover/index";
$route["assets/(:num)/handover/detail"] = "assets_handover/detail";
$route["assets/(:num)/handover/detail/(:num)"] = "assets_handover/detail";
$route["assets/(:num)/handover/add"] = "assets_handover/add";
$route["assets/(:num)/handover/edit/(:num)"] = "assets_handover/edit";
$route["assets/(:num)/handover/delete/(:num)"] = "assets_handover/delete";
$route["assets/(:num)/handover/save"] = "assets_handover/save";
$route["assets/(:num)/handover/update"] = "assets_handover/update";
$route["assets/(:num)/handover/report"] = "assets_handover/report";

// Salaries and Sub Table Salarie
$route["salaries/(:num)/sub_salaries/index"] = "sub_salaries/index";
$route["salaries/(:num)/sub_salaries/index/(:num)"] = "sub_salaries/index";
$route["salaries/(:num)/sub_salaries/add"] = "sub_salaries/add";
$route["salaries/(:num)/sub_salaries/edit/(:num)"] = "sub_salaries/edit";
$route["salaries/(:num)/sub_salaries/delete/(:num)"] = "sub_salaries/delete";
$route["salaries/(:num)/sub_salaries/save"] = "sub_salaries/save";
$route["salaries/(:num)/sub_salaries/update"] = "sub_salaries/update";

//User role detail
$route["users/roles/(:num)/role_details/index"] = "role_details/index";
$route["users/roles/(:num)/role_details/index/(:num)"] = "role_details/index";
$route["users/roles/(:num)/role_details/add"] = "role_details/add";
$route["users/roles/(:num)/role_details/edit/(:num)"] = "role_details/edit";
$route["users/roles/(:num)/role_details/delete/(:num)"] = "role_details/delete";
$route["users/roles/(:num)/role_details/save"] = "role_details/save";
$route["users/roles/(:num)/role_details/update"] = "role_details/update";


//Config Controller


$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
