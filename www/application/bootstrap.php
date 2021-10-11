<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Europe/Moscow');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

if (isset($_SERVER['SERVER_PROTOCOL']))
{
	// Replace the default protocol.
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
        'index_file' => FALSE
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'auth'       => MODPATH.'auth',       // Basic authentication
	// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	'database'   => MODPATH.'database',   // Database access
	// 'image'      => MODPATH.'image',      // Image manipulation
	// 'minion'     => MODPATH.'minion',     // CLI Tasks
	'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	));

/**
 * Cookie Salt
 * @see  http://kohanaframework.org/3.3/guide/kohana/cookies
 * 
 * If you have not defined a cookie salt in your Cookie class then
 * uncomment the line below and define a preferrably long salt.
 */
Cookie::$salt = 125566332289898874444447777;

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

//auth
Route::set('auth', 'auth/login')
	->defaults(array(
		'controller' => 'auth',
		'action'     => 'login',
	));

Route::set('rauth', 'auth/registration')
	->defaults(array(
		'controller' => 'auth',
		'action'     => 'registration',
	));

//office - manager
Route::set('moffice', 'manager/office')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'index',
		'action'     => 'office',
	));

//journal - manager
Route::set('mprint', 'manager/print/print_order/<journal_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'print',
		'action'     => 'print_order',
	));

Route::set('mgjournal', 'manager/journal/get_journals/<office_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'journal',
		'action'     => 'get_journals',
	));
    
Route::set('mgjournallist', 'manager/journallist/get_journal_list/<office_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'journallist',
		'action'     => 'get_journal_list',
	));
        
Route::set('mjournal', 'manager/journal')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'index',
		'action'     => 'journal',
	));

//client - manager
Route::set('mpcprint', 'manager/print/print_coins/<order_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'print',
		'action'     => 'print_coins',
	));

Route::set('mpcrprint', 'manager/print/print_cash_register/<order_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'print',
		'action'     => 'print_cash_register',
	));

Route::set('mpcrfprint', 'manager/print/print_cash_register_fast/<order_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'print',
		'action'     => 'print_cash_register_fast',
	));

Route::set('msordercoins', 'manager/ordercoins/save_coins/<office_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'ordercoins',
		'action'     => 'save_coins',
	));

Route::set('meordercoins', 'manager/ordercoins/get_coins/<office_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'ordercoins',
		'action'     => 'get_coins',
	));

    
Route::set('meorder', 'manager/order/order_edit/<client_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'order',
		'action'     => 'order_edit',
	));

Route::set('morderaddauto', 'manager/order/order_add_auto/<client_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'order',
		'action'     => 'order_add_auto',
	));

Route::set('mpiprint', 'manager/print/print_invoice/<order_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'print',
		'action'     => 'print_invoice',
	));

Route::set('msordercash', 'manager/ordercash/save_cash/<office_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'ordercash',
		'action'     => 'save_cash',
	));

Route::set('meordercash', 'manager/ordercash/get_cash/<office_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'ordercash',
		'action'     => 'get_cash',
	));

Route::set('maorder', 'manager/order/order_add/<client_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'order',
		'action'     => 'order_add',
	));

Route::set('mgclientlist', 'manager/clientlist/get_client_list/<client_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'clientlist',
		'action'     => 'get_client_list',
	));

Route::set('msclient', 'manager/client/save_client/<client_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'client',
		'action'     => 'save_client',
	));

Route::set('maclient', 'manager/client/client_add')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'client',
		'action'     => 'client_add',
	));

Route::set('meclient', 'manager/client/client_edit/<client_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'client',
		'action'     => 'client_edit',
	));

Route::set('mgclient', 'manager/client/get_client/<client_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'client',
		'action'     => 'get_client',
	));

Route::set('mgorder', 'manager/order/get_orders/<client_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'order',
		'action'     => 'get_orders',
	));

Route::set('mgabcporder', 'manager/json/get_order_abcp/<order_abcp_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'json',
		'action'     => 'get_order_abcp',
	));

Route::set('maaorder', 'manager/order/order_add_abcp/<client_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'order',
		'action'     => 'order_add_abcp',
	));

Route::set('megabcporder', 'manager/json/get_emex_abcp/<number_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'json',
		'action'     => 'get_emex_abcp',
	));

//expenses - manager
Route::set('mdtypeexpenses', 'manager/typeexpenses/del_typeexpenses/<typeexpenses_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'typeexpenses',
		'action'     => 'del_typeexpenses',
	));

Route::set('mgtypeexpenseslist', 'manager/typeexpenseslist/get_typeexpenses_list')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'typeexpenseslist',
		'action'     => 'get_typeexpenses_list',
	));

Route::set('matypeexpenses', 'manager/typeexpenses/save_typeexpenses/<typeexpenses_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'typeexpenses',
		'action'     => 'save_typeexpenses',
	));

Route::set('mgexpenses', 'manager/expenses/get_expenses/<typeexpenses_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'expenses',
		'action'     => 'get_expenses',
	));

Route::set('mgtypeexpenses', 'manager/typeexpenses/get_typeexpenses/<typeexpenses_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'typeexpenses',
		'action'     => 'get_typeexpenses',
	));

Route::set('mexpenses', 'manager/expenses')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'index',
		'action'     => 'expenses',
	));

//discount - manager
Route::set('mcdiscounthistorys', 'manager/discounthistory/clear_discounthistory/<discount_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'discounthistory',
		'action'     => 'clear_discounthistory',
	));

Route::set('mgdiscounthistory', 'manager/discounthistory/get_discounthistorys/<discount_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'discounthistory',
		'action'     => 'get_discounthistorys',
	));

Route::set('mgdiscountchangehistory', 'manager/discountchangehistory/get_discountchangehistorys/<discount_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'discountchangehistory',
		'action'     => 'get_discountchangehistorys',
	));

Route::set('mscreditcard', 'manager/creditcard/save_creditcard')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'creditcard',
		'action'     => 'save_creditcard',
	));

Route::set('mgcreditcard', 'manager/creditcard/get_creditcard/<order_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'creditcard',
		'action'     => 'get_creditcard',
	));

Route::set('msdiscount', 'manager/discount/save_discount/<discount_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'discount',
		'action'     => 'save_discount',
	));

Route::set('madiscount', 'manager/discount/save_discount')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'discount',
		'action'     => 'save_discount',
	));

Route::set('mgldiscount', 'manager/discountlist/get_discount_list')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'discountlist',
		'action'     => 'get_discount_list',
	));

Route::set('mediscount', 'manager/discount/discount_edit/<discount_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'discount',
		'action'     => 'discount_edit',
	));

Route::set('mgdiscount', 'manager/discount/get_discount/<discount_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'discount',
		'action'     => 'get_discount',
	));

Route::set('mdiscounts', 'manager/discounts')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'index',
		'action'     => 'discounts',
	));

Route::set('mhistory_sms', 'manager/history_sms')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'index',
		'action'     => 'history_sms',
	));

Route::set('mghistorysms', 'manager/historysms/get_history/<client_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'historysms',
		'action'     => 'get_history',
	));

//bonus
Route::set('mgcreditbonus', 'manager/creditbonus/get_creditbonus/<order_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'creditbonus',
		'action'     => 'get_creditbonus',
	));

//client
Route::set('apiprint', 'admin/print/print_invoice/<order_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'print',
		'action'     => 'print_invoice',
	));

Route::set('agclientlist', 'admin/clientlist/get_client_list/<office_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'clientlist',
		'action'     => 'get_client_list',
	));

Route::set('asclient', 'admin/client/save_client/<client_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'client',
		'action'     => 'save_client',
	));

Route::set('aeclient', 'admin/client/client_edit/<client_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'client',
		'action'     => 'client_edit',
	));

Route::set('agclient', 'admin/client/get_client/<client_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'client',
		'action'     => 'get_client',
	));

Route::set('aclient', 'admin/client')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'index',
		'action'     => 'client',
	));

Route::set('agorder', 'admin/order/get_orders/<client_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'order',
		'action'     => 'get_orders',
	));

Route::set('aeorder', 'admin/order/order_edit/<client_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'order',
		'action'     => 'order_edit',
	));

Route::set('mgjorder', 'manager/json/get_order/<order_id>')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'json',
		'action'     => 'get_order',
	));

//journal
Route::set('agjournallist', 'admin/journallist/get_journal_list/<office_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'journallist',
		'action'     => 'get_journal_list',
	));

Route::set('agjournal', 'admin/journal/get_journals/<office_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'journal',
		'action'     => 'get_journals',
	));

Route::set('ajournal', 'admin/journal')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'index',
		'action'     => 'journal',
	));

//typeoper
Route::set('adtypeoper', 'admin/typeoper/del_typeoper/<typeoper_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'typeoper',
		'action'     => 'del_typeoper',
	));

Route::set('astypeoper', 'admin/typeoper/save_typeoper/<typeoper_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'typeoper',
		'action'     => 'save_typeoper',
	));

Route::set('aetypeoper', 'admin/typeoper/typeoper_edit/<typeoper_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'typeoper',
		'action'     => 'typeoper_edit',
	));

Route::set('aatypeoper', 'admin/typeoper/typeoper_add')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'typeoper',
		'action'     => 'typeoper_add',
	));

Route::set('agtypeoperlist', 'admin/typeoperlist/get_typeoper_list')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'typeoperlist',
		'action'     => 'get_typeoper_list',
	));

Route::set('atypeoper', 'admin/typeoper')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'index',
		'action'     => 'typeoper',
	));

//statistic
Route::set('agostatistic', 'admin/statistic/get_order_list/<id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'statistic',
		'action'     => 'get_order_list',
	));

Route::set('agstatistic', 'admin/statistic/get_statistic/<statistic_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'statistic',
		'action'     => 'get_statistic',
	));

Route::set('aestatistic', 'admin/action/export_csv/<str_code>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'action',
		'action'     => 'export_csv',
	));

Route::set('astatistic', 'admin/statistic')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'index',
		'action'     => 'statistic',
	));

//salary
Route::set('agsalary', 'admin/salary/get_salarys/<user_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'salary',
		'action'     => 'get_salarys',
	));

Route::set('assalary', 'admin/salary/save_salary')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'salary',
		'action'     => 'save_salary',
	));

Route::set('aasalary', 'admin/salary/salary_add')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'salary',
		'action'     => 'salary_add',
	));

Route::set('aesalaryuser', 'admin/salaryuser/user_edit/<user_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'salaryuser',
		'action'     => 'user_edit',
	));

Route::set('adsalaryuser', 'admin/salaryuser/del_user/<user_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'salaryuser',
		'action'     => 'del_user',
	));

Route::set('agsalaryuserlist', 'admin/salaryuserlist/get_user_list')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'salaryuserlist',
		'action'     => 'get_user_list',
	));

Route::set('aasalaryuser', 'admin/salaryuser/save_user/<user_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'salaryuser',
		'action'     => 'save_user',
	));

Route::set('agsalaryuser', 'admin/salaryuser/get_user/<user_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'salaryuser',
		'action'     => 'get_user',
	));

Route::set('asalary', 'admin/salary')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'index',
		'action'     => 'salary',
	));

//expenses
Route::set('adtypeexpenses', 'admin/typeexpenses/del_typeexpenses/<typeexpenses_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'typeexpenses',
		'action'     => 'del_typeexpenses',
	));

Route::set('agtypeexpenseslist', 'admin/typeexpenseslist/get_typeexpenses_list')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'typeexpenseslist',
		'action'     => 'get_typeexpenses_list',
	));

Route::set('aatypeexpenses', 'admin/typeexpenses/save_typeexpenses/<typeexpenses_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'typeexpenses',
		'action'     => 'save_typeexpenses',
	));

Route::set('agexpenses', 'admin/expenses/get_expenses/<typeexpenses_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'expenses',
		'action'     => 'get_expenses',
	));

Route::set('agtypeexpenses', 'admin/typeexpenses/get_typeexpenses/<typeexpenses_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'typeexpenses',
		'action'     => 'get_typeexpenses',
	));

Route::set('aexpenses', 'admin/expenses')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'index',
		'action'     => 'expenses',
	));

//user
Route::set('auserlist', 'admin/user/get_user_list')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'userlist',
		'action'     => 'get_user_list',
	));

Route::set('auser', 'admin/user/get_user/<user_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'user',
		'action'     => 'get_user',
	));

Route::set('asuser', 'admin/user/save_user/<user_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'user',
		'action'     => 'save_user',
	));

Route::set('aduser', 'admin/user/del_user/<user_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'user',
		'action'     => 'del_user',
	));

Route::set('aeuseremex', 'admin/user/user_edit_emex/<user_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'user',
		'action'     => 'user_edit_emex',
	));

//access
Route::set('aaccess', 'admin/access')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'index',
		'action'     => 'access',
	));

Route::set('agaccess', 'admin/access/get_accesses/<user_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'access',
		'action'     => 'get_accesses',
	));

Route::set('aacaccess', 'admin/access/access_check/')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'access',
		'action'     => 'access_check',
	));

//settings
Route::set('asettingslist', 'admin/settings/get_settings_list')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'settingslist',
		'action'     => 'get_settings_list',
	));

Route::set('aesettings', 'admin/settings/setting_edit/<setting_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'settings',
		'action'     => 'setting_edit',
	));

Route::set('assettings', 'admin/settings/save_setting/<setting_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'settings',
		'action'     => 'save_setting',
	));

Route::set('asettings', 'admin/settings')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'index',
		'action'     => 'settings',
	));

Route::set('agsettings', 'admin/settings/get_settings/<settings_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'settings',
		'action'     => 'get_settings',
	));

//officelist
Route::set('aofficelist', 'admin/officelist/get_office_list/')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'officelist',
		'action'     => 'get_office_list',
	));

Route::set('agjorder', 'admin/json/get_order/<order_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'json',
		'action'     => 'get_order',
	));

//office
Route::set('alkoffice', 'admin/office/office_link/<office_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'office',
		'action'     => 'office_link',
	));

Route::set('asoffice', 'admin/office/save_office/<office_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'office',
		'action'     => 'save_office',
	));

Route::set('aeoffice', 'admin/office/office_edit/<office_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'office',
		'action'     => 'office_edit',
	));

Route::set('adoffice', 'admin/office/del_office/<office_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'office',
		'action'     => 'del_office',
	));

//officecash
Route::set('agofficecash', 'admin/officecash/get_cash/<office_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'officecash',
		'action'     => 'get_cash',
	));

Route::set('asofficecash', 'admin/officecash/save_cash/<office_id>')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'officecash',
		'action'     => 'save_cash',
	));

//all
Route::set('admin', 'admin(/<controller>(/<action>))')
	->defaults(array(
                'directory'  => 'admin',
		'controller' => 'index',
		'action'     => 'index',
	));

Route::set('manager', 'manager(/<controller>(/<action>))')
	->defaults(array(
                'directory'  => 'manager',
		'controller' => 'index',
		'action'     => 'index',
	));

Route::set('index', '(<controller>(/<action>))')
	->defaults(array(
		'controller' => 'index',
		'action'     => 'index',
	));

Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'index',
		'action'     => 'index',
	));
