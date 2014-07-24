<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

//ห้ามขึ้นต้น ด้วยตัวอักษรใหญ่
$route['default_controller'] = "dashboard";
$route['404_override'] = '';


$route['signin'] = 'authentication';
$route['signout'] = 'authentication/signOut';


//Member
$route['member/add'] = 'member/memberadd';
$route['member/edit/(:any).*'] = 'member/memberedit/$1';
$route['member/delete/(:any).*'] = 'member/memberdelete/$1';

//Company
$route['company/add'] = 'company/companyadd';
$route['company/edit/(:any).*'] = 'company/companyedit/$1';
$route['company/delete/(:any).*'] = 'company/companydelete/$1';

//Device
$route['device/add'] = 'device/deviceadd';
$route['device/edit/(:any).*'] = 'device/deviceedit/$1';
$route['device/delete/(:any).*'] = 'device/devicedelete/$1';

//Issue
$route['issue/add'] = 'issue/issueadd';
$route['issue/edit/(:any).*'] = 'issue/issueedit/$1';
$route['issue/delete/(:any).*'] = 'issue/issueelete/$1';

//Settings
$route['module'] = 'setting';
$route['module/add'] = 'setting/moduleadd';
$route['module/edit/(:any).*'] = 'setting/moduleedit/$1';
$route['module/delete/(:any).*'] = 'setting/moduledelete/$1';

$route['department'] = 'setting/departmentList';
$route['department/add'] = 'setting/departmentadd';
$route['department/edit/(:any).*'] = 'setting/departmentedit/$1';
$route['department/delete/(:any).*'] = 'setting/departmentdelete/$1';

$route['position'] = 'setting/positionList';
$route['position/add'] = 'setting/positionadd';
$route['position/edit/(:any).*'] = 'setting/positionedit/$1';
$route['position/delete/(:any).*'] = 'setting/positiondelete/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */