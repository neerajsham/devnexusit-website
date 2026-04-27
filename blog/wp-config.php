<?php
define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u979076758_YOnvC' );

/** Database username */
define( 'DB_USER', 'u979076758_teUwo' );

/** Database password */
define( 'DB_PASSWORD', 'oYIvMRNqys' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',          '].@nUah.xBSy6..<0zZkOoP3gZ<wz#~;M?B+7un6(F1C$kG:S|S ;?yUpiPCiuQr' );
define( 'SECURE_AUTH_KEY',   'ztb,p~6Fla`9XwB+%kFzHpVXwY4pDAWzo00Qj;R.t2-_t!l`cRUTP,?_lC.&/Y0@' );
define( 'LOGGED_IN_KEY',     'TPiqRsyO{eMv6.JAjH}&sMiUL&sAn4d#H4*!>sH&ue4s04|Qa!n+?;N-H0cdj:(t' );
define( 'NONCE_KEY',         '4eOq7.Z?c$]KN-vvY0`g2n6Qozdx{zs/B(o>:f@a]2uG!*i8HeM{8E{`O~xHE+ri' );
define( 'AUTH_SALT',         '78[[R.xE]0NNk._W*M6m51Z$4x &Q74s;,TbyYE2IXPVKRo>>,4K__#&:c5 Q%^e' );
define( 'SECURE_AUTH_SALT',  '<`wUJ5#=KqUM~CX{sM1M+?De?*]H.}kLXhN8^O:]!&9UA 7vZF&4g@ cbRe|[z+<' );
define( 'LOGGED_IN_SALT',    'ixba`)9r?dp16f_9C3PS+hmG/.h Z;vau}0~Zlap*Tp=-sD>C&K QhJ!gW+d@BHj' );
define( 'NONCE_SALT',        '+-+J}SV|84!LFUvOq,g^Y_<y3}`rYZ,taSha+6T1%^dal23gE}!<4v,;Hb4HhW|0' );
define( 'WP_CACHE_KEY_SALT', 'sq4@njrz>^7Pkes*RM$P/5msH>VRsGfLLN+c{=R5Xu/UMS:(NN!@b:j]kOk6I1#f' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'd989846cfc004c22713e50dfc1e20153' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
