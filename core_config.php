<?php
/**
 * @AUTHOR Christian Marcell (chroda) <chroda@chroda.com.br>
 * @VERSION 1.0
 * @SINCE 2011-12-21
 * Configurations of Core, to work independently of project,
 * however, the core was made for run with a project, to be his core.
 */

/**
 * Core path.
 */
define( '__CORE_DIR__', str_replace('\\', '/', dirname(__FILE__)).'/' );

/**
 * Library path.
 */
define( '__LIB_DIR__', __CORE_DIR__ . 'core_library/' );

/**
 * Functions.
 */
require_once __LIB_DIR__.'functions.php';

/**
 * Controllers path.
 */
define( '__CONTROLLERS_DIR__', __CORE_DIR__ . 'core_controllers/' );

/**
 * Alias for DNS name.
 */
define( '__DNS__', $_SERVER['SERVER_NAME'] );

/**
 * Alias for IP number.
 */
define( '__IP__', $_SERVER['SERVER_ADDR'] );

/**
 * Alias for self page, usefull for forms and get anchors.
 */
define( '__HERE__', $_SERVER['REQUEST_URI'] );

/**
 * Extension for Views.
 */
define( '__VIEW_EXT__','.php' );

/**
 * Extension for Templates.
 */
define( '__TPL_EXT__', __VIEW_EXT__ );

/**
 * Extension for Rewrites.
 */
define( '__REWRITE_EXT__', '.html' );

/**
 * Primary Database.
 */
define( '__MONGO_SERVER__','master' );

/**
 * Logs Storage or not.
 */
define( '__LOGGING__',true );

/**
 * Debug active or not.
 */
define( '__DEBUG__',true );


/**
 * Rename session with engine prefix.
 */
define( '__SESSION_NAME__', 'CaffeineEngine' );

/**
 * Duration of a session.
 */
define( '__SESSION_TIMEOUT__', 3600 );

/**
 * Default language.
 */
define( '__LOCALE__','pt_BR' );

/**
 * Timezone local.
 */
define( '__TIMEZONE_LOCAL__','America/Sao_Paulo' );

/**
 * Timezone time.
 */
define( '__TIMEZONE_TIME__','Etc/GMT+3' );

//* If debug is true, start a timer (for benchmark tests).
if( __DEBUG__ === true ) { StartTimer(); }

/**
 * Headers.
 */
header( 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7"', true );
header( 'Content-Type: text/html; charset=UTF-8' );
header( 'Expires: ' . date( 'D, d m Y H:i:s' ) . ' GMT' );
header( 'X-Powered-By: CaffeineEngine/0.1' );
header( 'X-Server-Name: ' . __DNS__ );
header( 'X-Developer: Christian Marcell (chroda) <chroda@chroda.com.br>' );

/**
 * Timezone.
 */
date_default_timezone_set( __TIMEZONE_LOCAL__ );
date_default_timezone_set( __TIMEZONE_TIME__ );

/**
 * Configurações básicas do sistema.
 */
mb_internal_encoding( "UTF-8" );
if( __DEBUG__ === true ) {
  error_reporting( E_ALL );
} else {
  error_reporting( E_ALL ^ E_NOTICE );
}
ini_set( "display_errors", __DEBUG__ );
setlocale( LC_ALL, __LOCALE__ . ".UTF-8" );