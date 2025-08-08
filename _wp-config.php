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

//Is this the production server or not?
$url =  'http://' . $_SERVER['SERVER_NAME']; 
$tld = end(explode(".", parse_url($url, PHP_URL_HOST)));

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

//if($tld == 'local'){
	define( 'DB_NAME', 'local' );
	
	/** Database username */
	define( 'DB_USER', 'root' );
	
	/** Database password */
	define( 'DB_PASSWORD', 'root' );
	
	/** Database hostname */
	define( 'DB_HOST', 'localhost' );
	/*
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
*/
/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY',         'EYjIWHG6fd4ax3XvcLXk5iYoQhjEK89fjRigjirXg24t7HvXamicmNFJDbE4uvCO');
define('SECURE_AUTH_KEY',  'qGTDmZxCEgE4KtmweR599JPCKZaK4UW99YxN5C3BGyVPdaiJu4EguBQCTUbJRT8n');
define('LOGGED_IN_KEY',    'z8lynoKu2cXfFuJrhJYzhLid6qJxD5duKpYR6uIxQ0ZBJISriQaOqinM4OWnvLqz');
define('NONCE_KEY',        'M38V9DFas4eHCDDJgtFKZmzzD73SGuDBmxTVoEayTwOeiaQ1lx9VOND0x5IHWSDN');
define('AUTH_SALT',        'MSH67B7HZsPiN1PfhiTYgCr812S0Bx9s9Mc5NCCmqBJrATh6TMPY1PyltsJVaFWS');
define('SECURE_AUTH_SALT', 'DpHgCP7j3HefvfYVyTH2RCVazFgo29c9iwvxBGAH7ZdDuSe7xwMyCitbheSzgLrt');
define('LOGGED_IN_SALT',   'euQuX1sVeoJ9ILK9OiO2fONbzeUyCYIE1nNlGntLPOwydNgIh9431kR4vFe2PNqV');
define('NONCE_SALT',       'WqXaWbJhhEkHxC7mVTCBkY54I4bEx4ZI3EVuDVbs2iSg4yXCtCkDGDHA6VUVBWfo');

/**
 * Other customizations.
 */
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');


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
$table_prefix = 'wp_';

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
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

/* Add any custom values between this line and the "stop editing" line. */
define('WP_ALLOW_MULTISITE', true);

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
