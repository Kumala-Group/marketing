<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|
|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|				'ssl_key'    - Path to the private key file
|				'ssl_cert'   - Path to the public key certificate file
|				'ssl_ca'     - Path to the certificate authority file
|				'ssl_capath' - Path to a directory containing trusted CA certificats in PEM format
|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not ('mysqli' only)
|
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/

$active_group = 'default';
$active_record = TRUE;

/* KMG */
$db['default']['hostname'] = '192.140.10.244';
$db['default']['username'] = 'tian';
$db['default']['password'] = '168168168kmg';
$db['default']['database'] = 'kmg';

$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = (ENVIRONMENT !== 'production');
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

/* Database HelpDesk */
$db['db_helpdesk']['hostname'] = '192.140.10.244';
$db['db_helpdesk']['username'] = 'tian';
$db['db_helpdesk']['password'] = '168168168kmg';
$db['db_helpdesk']['database'] = 'db_helpdesk';
$db['db_helpdesk']['dbdriver'] = 'mysqli';
$db['db_helpdesk']['dbprefix'] = '';
$db['db_helpdesk']['pconnect'] = FALSE;
$db['db_helpdesk']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_helpdesk']['cache_on'] = FALSE;
$db['db_helpdesk']['cachedir'] = '';
$db['db_helpdesk']['char_set'] = 'utf8';
$db['db_helpdesk']['dbcollat'] = 'utf8_general_ci';
$db['db_helpdesk']['swap_pre'] = '';
$db['db_helpdesk']['autoinit'] = TRUE;
$db['db_helpdesk']['stricton'] = FALSE;



/* Database Wuling */
$db['db_wuling']['hostname'] = '192.140.10.244';
$db['db_wuling']['username'] = 'tian';
$db['db_wuling']['password'] = '168168168kmg';
$db['db_wuling']['database'] = 'db_wuling';
$db['db_wuling']['dbdriver'] = 'mysqli';
$db['db_wuling']['dbprefix'] = '';
$db['db_wuling']['pconnect'] = FALSE;
$db['db_wuling']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_wuling']['cache_on'] = FALSE;
$db['db_wuling']['cachedir'] = '';
$db['db_wuling']['char_set'] = 'utf8';
$db['db_wuling']['dbcollat'] = 'utf8_general_ci';
$db['db_wuling']['swap_pre'] = '';
$db['db_wuling']['autoinit'] = TRUE;
$db['db_wuling']['stricton'] = FALSE;

/* Database Wuling SP */
$db['db_wuling_sp']['hostname'] = '192.140.10.244';
$db['db_wuling_sp']['username'] = 'tian';
$db['db_wuling_sp']['password'] = '168168168kmg';
$db['db_wuling_sp']['database'] = 'db_wuling_sp';
$db['db_wuling_sp']['dbdriver'] = 'mysqli';
$db['db_wuling_sp']['dbprefix'] = '';
$db['db_wuling_sp']['pconnect'] = FALSE;
$db['db_wuling_sp']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_wuling_sp']['cache_on'] = FALSE;
$db['db_wuling_sp']['cachedir'] = '';
$db['db_wuling_sp']['char_set'] = 'utf8';
$db['db_wuling_sp']['dbcollat'] = 'utf8_general_ci';
$db['db_wuling_sp']['swap_pre'] = '';
$db['db_wuling_sp']['autoinit'] = TRUE;
$db['db_wuling_sp']['stricton'] = FALSE;

/* Database Wuling AS*/
$db['db_wuling_as']['hostname'] = '192.140.10.244';
$db['db_wuling_as']['username'] = 'tian';
$db['db_wuling_as']['password'] = '168168168kmg';
$db['db_wuling_as']['database'] = 'db_wuling_as';
$db['db_wuling_as']['dbdriver'] = 'mysqli';
$db['db_wuling_as']['dbprefix'] = '';
$db['db_wuling_as']['pconnect'] = FALSE;
$db['db_wuling_as']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_wuling_as']['cache_on'] = FALSE;
$db['db_wuling_as']['cachedir'] = '';
$db['db_wuling_as']['char_set'] = 'utf8';
$db['db_wuling_as']['dbcollat'] = 'utf8_general_ci';
$db['db_wuling_as']['swap_pre'] = '';
$db['db_wuling_as']['autoinit'] = TRUE;
$db['db_wuling_as']['stricton'] = FALSE;

/* Database honda */
$db['db_honda']['hostname'] = '192.140.10.244';
$db['db_honda']['username'] = 'tian';
$db['db_honda']['password'] = '168168168kmg';
$db['db_honda']['database'] = 'db_honda';
$db['db_honda']['dbdriver'] = 'mysqli';
$db['db_honda']['dbprefix'] = '';
$db['db_honda']['pconnect'] = FALSE;
$db['db_honda']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_honda']['cache_on'] = FALSE;
$db['db_honda']['cachedir'] = '';
$db['db_honda']['char_set'] = 'utf8';
$db['db_honda']['dbcollat'] = 'utf8_general_ci';
$db['db_honda']['swap_pre'] = '';
$db['db_honda']['autoinit'] = TRUE;
$db['db_honda']['stricton'] = FALSE;

/* Database honda SP */
$db['db_honda_sp']['hostname'] = '192.140.10.244';
$db['db_honda_sp']['username'] = 'tian';
$db['db_honda_sp']['password'] = '168168168kmg';
$db['db_honda_sp']['database'] = 'db_honda_sp';
$db['db_honda_sp']['dbdriver'] = 'mysqli';
$db['db_honda_sp']['dbprefix'] = '';
$db['db_honda_sp']['pconnect'] = FALSE;
$db['db_honda_sp']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_honda_sp']['cache_on'] = FALSE;
$db['db_honda_sp']['cachedir'] = '';
$db['db_honda_sp']['char_set'] = 'utf8';
$db['db_honda_sp']['dbcollat'] = 'utf8_general_ci';
$db['db_honda_sp']['swap_pre'] = '';
$db['db_honda_sp']['autoinit'] = TRUE;
$db['db_honda_sp']['stricton'] = FALSE;

/* Database honda AS*/
$db['db_honda_as']['hostname'] = '192.140.10.244';
$db['db_honda_as']['username'] = 'tian';
$db['db_honda_as']['password'] = '168168168kmg';
$db['db_honda_as']['database'] = 'db_honda_as';
$db['db_honda_as']['dbdriver'] = 'mysqli';
$db['db_honda_as']['dbprefix'] = '';
$db['db_honda_as']['pconnect'] = FALSE;
$db['db_honda_as']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_honda_as']['cache_on'] = FALSE;
$db['db_honda_as']['cachedir'] = '';
$db['db_honda_as']['char_set'] = 'utf8';
$db['db_honda_as']['dbcollat'] = 'utf8_general_ci';
$db['db_honda_as']['swap_pre'] = '';
$db['db_honda_as']['autoinit'] = TRUE;
$db['db_honda_as']['stricton'] = FALSE;

/* Database Hino*/
$db['db_hino']['hostname'] = '192.140.10.244';
$db['db_hino']['username'] = 'tian';
$db['db_hino']['password'] = '168168168kmg';
$db['db_hino']['database'] = 'db_hino';
$db['db_hino']['dbdriver'] = 'mysqli';
$db['db_hino']['dbprefix'] = '';
$db['db_hino']['pconnect'] = FALSE;
$db['db_hino']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_hino']['cache_on'] = FALSE;
$db['db_hino']['cachedir'] = '';
$db['db_hino']['char_set'] = 'utf8';
$db['db_hino']['dbcollat'] = 'utf8_general_ci';
$db['db_hino']['swap_pre'] = '';
$db['db_hino']['autoinit'] = TRUE;
$db['db_hino']['stricton'] = FALSE;

/* Database mercedes*/
$db['db_mercedes']['hostname'] = '192.140.10.244';
$db['db_mercedes']['username'] = 'tian';
$db['db_mercedes']['password'] = '168168168kmg';
$db['db_mercedes']['database'] = 'db_mercedes';
$db['db_mercedes']['dbdriver'] = 'mysqli';
$db['db_mercedes']['dbprefix'] = '';
$db['db_mercedes']['pconnect'] = FALSE;
$db['db_mercedes']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_mercedes']['cache_on'] = FALSE;
$db['db_mercedes']['cachedir'] = '';
$db['db_mercedes']['char_set'] = 'utf8';
$db['db_mercedes']['dbcollat'] = 'utf8_general_ci';
$db['db_mercedes']['swap_pre'] = '';
$db['db_mercedes']['autoinit'] = TRUE;
$db['db_mercedes']['stricton'] = FALSE;


/* Database honda SP */
$db['db_mercedes_sp']['hostname'] = '192.140.10.244';
$db['db_mercedes_sp']['username'] = 'tian';
$db['db_mercedes_sp']['password'] = '168168168kmg';
$db['db_mercedes_sp']['database'] = 'db_mercedes_sp';
$db['db_mercedes_sp']['dbdriver'] = 'mysqli';
$db['db_mercedes_sp']['dbprefix'] = '';
$db['db_mercedes_sp']['pconnect'] = FALSE;
$db['db_mercedes_sp']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_mercedes_sp']['cache_on'] = FALSE;
$db['db_mercedes_sp']['cachedir'] = '';
$db['db_mercedes_sp']['char_set'] = 'utf8';
$db['db_mercedes_sp']['dbcollat'] = 'utf8_general_ci';
$db['db_mercedes_sp']['swap_pre'] = '';
$db['db_mercedes_sp']['autoinit'] = TRUE;
$db['db_mercedes_sp']['stricton'] = FALSE;

/* Database mercedes AS*/
$db['db_mercedes_as']['hostname'] = '192.140.10.244';
$db['db_mercedes_as']['username'] = 'tian';
$db['db_mercedes_as']['password'] = '168168168kmg';
$db['db_mercedes_as']['database'] = 'db_mercedes_as';
$db['db_mercedes_as']['dbdriver'] = 'mysqli';
$db['db_mercedes_as']['dbprefix'] = '';
$db['db_mercedes_as']['pconnect'] = FALSE;
$db['db_mercedes_as']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_mercedes_as']['cache_on'] = FALSE;
$db['db_mercedes_as']['cachedir'] = '';
$db['db_mercedes_as']['char_set'] = 'utf8';
$db['db_mercedes_as']['dbcollat'] = 'utf8_general_ci';
$db['db_mercedes_as']['swap_pre'] = '';
$db['db_mercedes_as']['autoinit'] = TRUE;
$db['db_mercedes_as']['stricton'] = FALSE;

/* Database KPP*/
$db['db_kpp']['hostname'] = '192.140.10.244';
$db['db_kpp']['username'] = 'tian';
$db['db_kpp']['password'] = '168168168kmg';
$db['db_kpp']['database'] = 'db_kpp';
$db['db_kpp']['dbdriver'] = 'mysqli';
$db['db_kpp']['dbprefix'] = '';
$db['db_kpp']['pconnect'] = FALSE;
$db['db_kpp']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_kpp']['cache_on'] = FALSE;
$db['db_kpp']['cachedir'] = '';
$db['db_kpp']['char_set'] = 'utf8';
$db['db_kpp']['dbcollat'] = 'utf8_general_ci';
$db['db_kpp']['swap_pre'] = '';
$db['db_kpp']['autoinit'] = TRUE;
$db['db_kpp']['stricton'] = FALSE;

/* Database KSA*/
$db['db_ksa']['hostname'] = '192.140.10.244';
$db['db_ksa']['username'] = 'tian';
$db['db_ksa']['password'] = '168168168kmg';
$db['db_ksa']['database'] = 'db_ksa';
$db['db_ksa']['dbdriver'] = 'mysqli';
$db['db_ksa']['dbprefix'] = '';
$db['db_ksa']['pconnect'] = FALSE;
$db['db_ksa']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_ksa']['cache_on'] = FALSE;
$db['db_ksa']['cachedir'] = '';
$db['db_ksa']['char_set'] = 'utf8';
$db['db_ksa']['dbcollat'] = 'utf8_general_ci';
$db['db_ksa']['swap_pre'] = '';
$db['db_ksa']['autoinit'] = TRUE;
$db['db_ksa']['stricton'] = FALSE;

/* Database KSS*/
$db['db_kss']['hostname'] = '192.140.10.244';
$db['db_kss']['username'] = 'tian';
$db['db_kss']['password'] = '168168168kmg';
$db['db_kss']['database'] = 'db_kss';
$db['db_kss']['dbdriver'] = 'mysqli';
$db['db_kss']['dbprefix'] = '';
$db['db_kss']['pconnect'] = FALSE;
$db['db_kss']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_kss']['cache_on'] = FALSE;
$db['db_kss']['cachedir'] = '';
$db['db_kss']['char_set'] = 'utf8';
$db['db_kss']['dbcollat'] = 'utf8_general_ci';
$db['db_kss']['swap_pre'] = '';
$db['db_kss']['autoinit'] = TRUE;
$db['db_kss']['stricton'] = FALSE;

/* Database KSA SP*/
$db['db_ksa_sp']['hostname'] = '192.140.10.244';
$db['db_ksa_sp']['username'] = 'tian';
$db['db_ksa_sp']['password'] = '168168168kmg';
$db['db_ksa_sp']['database'] = 'db_ksa_sp';
$db['db_ksa_sp']['dbdriver'] = 'mysqli';
$db['db_ksa_sp']['dbprefix'] = '';
$db['db_ksa_sp']['pconnect'] = FALSE;
$db['db_ksa_sp']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_ksa_sp']['cache_on'] = FALSE;
$db['db_ksa_sp']['cachedir'] = '';
$db['db_ksa_sp']['char_set'] = 'utf8';
$db['db_ksa_sp']['dbcollat'] = 'utf8_general_ci';
$db['db_ksa_sp']['swap_pre'] = '';
$db['db_ksa_sp']['autoinit'] = TRUE;
$db['db_ksa_sp']['stricton'] = FALSE;

/* Database mazda*/
$db['db_mazda']['hostname'] = '192.140.10.244';
$db['db_mazda']['username'] = 'tian';
$db['db_mazda']['password'] = '168168168kmg';
$db['db_mazda']['database'] = 'db_mazda';
$db['db_mazda']['dbdriver'] = 'mysqli';
$db['db_mazda']['dbprefix'] = '';
$db['db_mazda']['pconnect'] = FALSE;
$db['db_mazda']['db_debug'] = (ENVIRONMENT !== 'production');
$db['db_mazda']['cache_on'] = FALSE;
$db['db_mazda']['cachedir'] = '';
$db['db_mazda']['char_set'] = 'utf8';
$db['db_mazda']['dbcollat'] = 'utf8_general_ci';
$db['db_mazda']['swap_pre'] = '';
$db['db_mazda']['autoinit'] = TRUE;
$db['db_mazda']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */
