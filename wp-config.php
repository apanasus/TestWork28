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
define( 'DB_NAME', 'trustproj' );

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
define( 'AUTH_KEY',         'A|{jB%n9V2R*%&<z*:*#~Rc5fH[Au5fzH5hzILWrmA{b/H0HXAE%zrdzoC_Gm}bG' );
define( 'SECURE_AUTH_KEY',  'chr awzka`O-&=T+(u8S^~Op<D[m:IV:nP>UPU(Va3zt5|@Kk}#*%*tUY!E;ZQRc' );
define( 'LOGGED_IN_KEY',    '3lb1?5/!Iwq{mRzJPi=puC>x!mzC6+E?n>NK_,a{t6ERZ^Fa:G4*-jRzYU&7xB8W' );
define( 'NONCE_KEY',        'p{Fk,(<ao/8=/8b=j+-(zeGGaw]XCJse(FdG5RHw*MPTjmMm_m80[. R,c# GTD%' );
define( 'AUTH_SALT',        'j!`LQGQWpk?6` .pRy5Zlj&.LP&B5|ovvcHZ>3X(vX0@4fDpk-Gv,{<1AsPzR@)J' );
define( 'SECURE_AUTH_SALT', 'U&g!>(8ONbwdW>6whb+Tz}ftIY85o@bOV}tJ^$>eb]9Bn=yFP#MV*O8A:mV|N#0.' );
define( 'LOGGED_IN_SALT',   '_8A}3Nj40t2AiIEGRHg`!V1V1=ODqdEtRp.B5e^=1S2.BNd6--$;{?P;PLu*zW%m' );
define( 'NONCE_SALT',       'N&+[._VrrSAAMq;K{fureRL+{?[:65Dm6c`^YzyO9[GJ]j;b!q:QUvc.SBxNRAid' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
