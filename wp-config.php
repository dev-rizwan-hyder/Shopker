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
define( 'DB_NAME', 'shopker' );

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
define( 'AUTH_KEY',         'tdngu^@pkb9GLiG8^a)t]K}hBciz)U-CxOQzLSQyX.9=;a/8vM)OT)vQhj*f@gW9' );
define( 'SECURE_AUTH_KEY',  '-1y{gD6U@f+MPg<S)adn<EySP7i !gi8EPTbsu>cp}q!Tx3E{.ccugtr!nOkbl9>' );
define( 'LOGGED_IN_KEY',    ' WPIN5PvY|37g/5K^/3+J7(FR7V?Ktji;L$=(j>k%r6(0+60fVK#Q]5vGa^.;:;2' );
define( 'NONCE_KEY',        'b12-8$Y7f)hhgw{Gbac):)WK|9#58j]!.{_!|eq43,#|,VxS5kvKsroQ?:pfWLW<' );
define( 'AUTH_SALT',        'onT0$O6u1{Ef0arrgl;_];+dJ+qs )t6><?^zaj3NQ9+H_qS{=C/cE^~4$m+<&{v' );
define( 'SECURE_AUTH_SALT', 'sKi]c=8^=-6{3BNK!k4gpGd8eK.LfYEiw |g=^`yVQ?DV_oLQ_3hkoaY}3/CHyCw' );
define( 'LOGGED_IN_SALT',   '@7[~ycg@$fY`64d>uMK+vBUmP6dK<Oy?InPSk%z%f(_6#8bEM%{&ZM*wL*uVO_ q' );
define( 'NONCE_SALT',       '.Ay1#IXnom+k^r*[^![yA/EI2S>.bN3U[4xuY/QtMx6+1}LAV~]&IqxZ7I852EVU' );

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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

define('FS_METHOD', 'direct');