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

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'db_wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'ijHvh?$`zG9k {6e-=Vt[UjXD~6|gB+tzF?!5sc7X~/%i>0`2]N=_5,e~]rGz6>d' );
define( 'SECURE_AUTH_KEY',  'Tqqw-ov-g/k8T5!p1p8vm:Ew>J^Y*f^ZQAs/E7wW@yiwz9FX[s!SZYZ@Z{q;.A<t' );
define( 'LOGGED_IN_KEY',    'UMs!2^:0?B @n=Zs<are)ZFMLY8aUTK(5MAyg)>yAzi)Q?f^@pV?HT%7jwm:=Prl' );
define( 'NONCE_KEY',        '/;Lz:HceVg04eCZ:fiHRN_T&HkY`N/=KkG{@geK+yZ2c%y88Dv1R4iW&R&E|TwPD' );
define( 'AUTH_SALT',        'Q)t:l9VyF4>f1KKQc}QH~Uzx*R_)Y1|_ISm>@( XoY[#><0`}r>WFpW$lxNsRF%B' );
define( 'SECURE_AUTH_SALT', '2s<FZM+*e3e>WX7&{N>]`3SU7~bx.F@ 7T}k(%3vk2@_C`{ZnR(D-|-o6|Zsu87}' );
define( 'LOGGED_IN_SALT',   'Wl4%k)c?yx$5DmG%ONK#2RbvbIZhtg>Xfv10H:5l~_0zn9}_-`Kdx4ZU!_#a.aA/' );
define( 'NONCE_SALT',       'u8P1j`Aq&SWZHBmPbqyROnAR}e9|uKiu!;&]#PSgcra}U8eIa/LcZT84|klb~pR6' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */


define('WP_ALLOW_MULTISITE', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
