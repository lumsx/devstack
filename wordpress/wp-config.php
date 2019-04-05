<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress001' );

/** MySQL database password */
define( 'DB_PASSWORD', 'password' );

/** MySQL hostname */
define( 'DB_HOST', 'edx.devstack.mysql' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );


/* That's all, stop editing! Happy blogging. */
// Edly specific settings
define('DISCOVERY_API_URL', 'edx.devstack.discovery:18381/api/v1');
define('LMS_BASE_URL', 'edx.devstack.lms:18000');
define('EOX_CLIENT_ID', 'edunext');
define('EOX_CLIENT_SECRET', 'edunext-secret');
define('IS_LOGGED_IN_COOKIE', 'edxloggedin');
define('USER_INFO_COOKIE', 'edx-user-info');


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'R[SnKK;AVTOdXAWR(O+wRp;[,jbUi5w92m M*_GwNTS}3mC#FL(&?8psa!!Q^5v+' );
define( 'SECURE_AUTH_KEY',  'ly$@o_3w>*YY(I;jk1{$fmwa)6,uC.E^wmz`#,lu84+cS==3&8AWA<I0?H=!E!n(' );
define( 'LOGGED_IN_KEY',    ']iUPD0aBi+:`cg__LsjrfW{eV}w)|jMFt/gMr@!NuK g,$`hpDzI3aT J+=iQw ;' );
define( 'NONCE_KEY',        '%VF*Zxb:Ei Hqx=n}F=X-,+,){!31%Sow$s=<WWEJ34c2fjjO8/?Ay}vqt^-wTW-' );
define( 'AUTH_SALT',        ']WUZ~v`|No!7=#,$+_v}h2/5,lVDO:~1]3s3kP<c)2k`aB.T9}n$:`DxMS&M/yd ' );
define( 'SECURE_AUTH_SALT', '@!aNiQPN)p_zx0G-SxHz8$<IbjART%|O%3Z?}]6x&S=!rEF7{Nv?xq>Cm46dR,xD' );
define( 'LOGGED_IN_SALT',   'rOM$`9qHquu]7G480r@Y1$ FzHHIOFf<o5X]^Twk5 `PZxDstu(0<%B(?^mM>!&;' );
define( 'NONCE_SALT',       'vMi-o84Ytb$#Ui4C)N:%iFZM2#/U-g^~[3Jki~.;Vgt}9XIuZ4TC&P0VcWb2{@oF' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
