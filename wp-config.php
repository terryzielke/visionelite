<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// Is this the production server or not?
$url =  'http://' . $_SERVER['SERVER_NAME']; 
$tld = end(explode(".", parse_url($url, PHP_URL_HOST)));

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
if($tld == 'local'){
	define( 'DB_NAME', 'local' );
	
	// Database username
	define( 'DB_USER', 'root' );
	
	// Database password
	define( 'DB_PASSWORD', 'root' );
	
	// Database hostname
	define( 'DB_HOST', 'localhost' );
}
else{
	define('DB_NAME', 'i10249509_r9ga1');

	// MySQL database username
	define('DB_USER', 'i10249509_r9ga1');

	// MySQL database password
	define('DB_PASSWORD', 'E.vK6iNsb0VAOYQnOfO65');

	// MySQL hostname
	define('DB_HOST', 'localhost');
}

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '@wF4f6hJnqcl./7:<P4]@Hc0cm/T_qH [*v_jTD5Ho#WX gT=ZhbD3b.R.c 4dzE' );
define( 'SECURE_AUTH_KEY',  'D,DGgeNZFYUz&#^V4gU-WL)dg[. H[7+?|~1fSw:9mhtNbeA31PcEdwjbhRz:0>(' );
define( 'LOGGED_IN_KEY',    'N4lgKXw^;/1Q=frWUBwj8jAsx-<l]:cIUZ38Ij8m%pqaQ}zW}=:DEm7>,1q;d>bn' );
define( 'NONCE_KEY',        '4b;(O4/pl%mtsO}}GG{1?3m5K?o31z3C+09,~xw>P^}(NfOXB--*WzN$b?HHW>[%' );
define( 'AUTH_SALT',        '?F<2fWhm[trb_%A|Q})@uy-woks(goDSxU]xh2md/`i%:]O|4S2TH:!ewy@{q.AN' );
define( 'SECURE_AUTH_SALT', '_RuE 5opW0|VMR3SC*Vx4&*:].x!89s]AZ+E9?~rf#wh 59]!`u#k~<fs{FWtgo[' );
define( 'LOGGED_IN_SALT',   '~n!ZjHu0 :wPIQHpImL=.e+8(73ve;nq/#&FYQI/F/QpE|u$wzv5FD]3dIpNtXEf' );
define( 'NONCE_SALT',       '/j_0r=-y;z+&X2{8&q:LFGt{7DDN^:TL>do!3`6E2UxwpB}#[~6;x0V}@lcTv2lF' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 've_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );

/* Add any custom values between this line and the "stop editing" line. */
/*
define('WP_ALLOW_MULTISITE', true);
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
define( 'DOMAIN_CURRENT_SITE', 'visionelite.local' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );
*/

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
