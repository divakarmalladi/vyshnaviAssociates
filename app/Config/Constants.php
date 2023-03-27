<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);



$rbChecklist = [
    0 => 'Documents',
    1 => 'Link Documents',
    2 => 'Encumbrance Certificate (EC)',
    3 => 'Vacant Tax/Property Tax Receipt',
    4 => 'Aadhar Card Xerox',
    5 => 'Old Plan Approval (If available)',
    6 => 'LCC (if Required)',
    7 => 'Market Value',
    8 => 'Application And Drawing (to be prepared)',
    9 => 'Road Settlement Deed (to be given by applicant)',
    10 => 'Mortgage ( to be given by Applicant)',
    11 => 'Autocad Attachment',
    12 => 'Others',
];

$abChecklist = [
    0 => 'Documents',
    1 => 'Link Documents',
    2 => 'Encumbrance Certificate (EC)',
    3 => 'Vacant Land/ Property Tax Receipt',
    4 => 'Aadhar Card Xerox',
    5 => 'Old Plan Approval (If Available)',
    6 => 'LCC (if Required)',
    7 => 'Market Value',
    8 => 'Soil Test Reports',
    9 => 'Contractor’s All Risk Policy',
    10 => 'Structural Stability Certificate',
    11 => 'Structural Designs and  drawings',
    13 => 'Engineer’s Degree Certificate',
    14 => '3 Years ITR',
    15 => 'Firm Registration Certificate if available ',
    16 => 'Bank account pass book',
    17 => 'Pass port photo (All Partners) ',
    18 => 'Partnership deed ( if Required)',
    19 => 'Application And Drawing (to be prepared)',
    20 => 'Road Settlement Deed (to be given by applicant)',
    21 => 'Mortgage ( to be given by Applicant)',
    22 => 'Autocad Attachment',
    23 => 'Others',
];

$cbChecklist = [
    0 => 'Documents',
    1 => 'Link Documents',
    2 => 'Encumbrance Certificate (EC)',
    3 => 'Vacant Land/ Property Tax Receipt',
    4 => 'Aadhar Card Xerox',
    5 => 'Old Plan Approval (If Available)',
    6 => 'LCC (if Required)',
    7 => 'Market Value',
    8 => 'Soil Test Reports',
    9 => 'Contractor’s All Risk Policy',
    10 => 'Structural Stability Certificate',
    11 => 'Structural Designs and  drawings',
    13 => 'Engineer’s Degree Certificate',
    14 => '3 Years ITR',
    15 => 'Firm Registration Certificate if available ',
    16 => 'Bank account pass book',
    17 => 'Pass port photo (All Partners) ',
    18 => 'Partnership deed ( if Required)',
    19 => 'Application And Drawing (to be prepared)',
    20 => 'Road Settlement Deed (to be given by applicant)',
    21 => 'Mortgage ( to be given by Applicant)',
    22 => 'Fire NOC (if required)',
    23 => 'ECBC Certificate (If required)',
    24 => 'Autocad Attachment',
    25 => 'Others',
];

$cppChecklist = [
    0 => 'Site Measurements',
    1 => 'Document',
    2 => 'Autocad Attachment',
    3 => 'Others',
];

$layoutChecklist = [
    0 => 'Documents',
    1 => 'Link Documents',
    2 => 'LCC',
    3 => 'Adangal',
    4 => '1B',
    5 => 'Surveyor’s Sketch – FMB',
    6 => 'Combined Sketch',
    7 => 'Village Revenue Map',
    8 => 'Blue Prints',
    9 => 'EC',
    10 => 'Applicant letter',
    11 => 'Panchayat Resolution',
    12 => 'Panchayat Secretary’s letter address to DTCP',
    13 => 'Annexure',
    14 => 'Challans paid to panchayat',
    15 => 'Scrunity fee ',
    16 => 'Autocad Attachment',
    17 => 'Others',
];

$estimationChecklist = [
    0 => 'Approved building Plan',
    1 => 'Documents (if Required)',
    2 => 'Autocad Attachment',
    3 => 'Others',
];

$valuationChecklist = [
    0 => 'Approved building Plan',
    1 => 'Documents ',
    2 => 'Building Photos',
    3 => 'House Tax receipt',
    4 => 'Market value taken form Registered office ',
    5 => 'Current bill previous month',
    6 => 'Autocad Attachment',
    7 => 'Others',
];

$elevationChecklist = [
    0 => 'Existing constructed Buildings  Photos all sides',
    1 => 'Existing Construction Plan',
    2 => 'Autocad Attachment',
    3 => 'Others'
];
$checkListSubItems = [
    'check_list_of_residential_building' => $rbChecklist,
    'check_list_of_apartment_building' => $abChecklist,
    'check_list_of_commercial_building' => $cbChecklist,
    'conceptual_plan_or_presentation' => $cppChecklist,
    'layout' => $layoutChecklist,
    'estimation' => $estimationChecklist,
    'valuation' => $valuationChecklist,
    'elevation' => $elevationChecklist
];

define('CHECK_LIST', ['check_list_of_apartment_building' => 'Check list of Apartment building', 'check_list_of_commercial_building' => 'Check list of Commercial building', 'check_list_of_residential_building' => 'Check list of Residential Building', 'conceptual_plan_or_presentation' => 'Conceptual Plan/Presentation', 'layout' => 'Layout', 'estimation' => 'Estimation', 'valuation' => 'Valuation', 'elevation' => 'Elevation']);

define('CHECK_LIST_SUB_ITEMS', $checkListSubItems);

define('USER_TYPE_LIST', ['1' => 'Admin', '2' => 'Assistant', '3' => 'Employee']);

define('USER_TYPES', ['admin' => '1', 'assistant' => '2', 'employee' => '3']);

$host = $_SERVER['HTTP_HOST'];
$http_https = isset($_SERVER['HTTPS']) ? "https://" : "http://";
$baseURL = $http_https . $host.'/vyshnavi-associates/public/';
define('BASE_URL_S', $baseURL);
