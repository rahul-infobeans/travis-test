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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'test_wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'server.123' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '+~)|8rNeeh<EXZj;S|5:]KSv{-u]YX(%{,uSWH&;f!<^W3?U*H^4Lceu5Y7T)xiy' );
define( 'SECURE_AUTH_KEY',  '[Vro1tpq]r0C5`}7xf@<9Mn0MaW2u9+XJ2VdYx$+b%_|qn&B`=-Pe<jwZ9}N6&^C' );
define( 'LOGGED_IN_KEY',    'lJi&i@hLP1YN3_spM9 @sI76<Z[|DbN8eQym]4cx e0SAt_XdcK m=4OH<CXZuy!' );
define( 'NONCE_KEY',        '9KK)vN.HGQ/HJ.bbVqf}s|[:[j7^-,U=j?uKvux:Yx>FVg~Ka-/&Jo`C.Re?sPts' );
define( 'AUTH_SALT',        '`!jgs|PjzKvN:?<]%OcLP-u[?5zGpb93[{W*DrXc|,l8EohfsS|rLtikFU>v6*bY' );
define( 'SECURE_AUTH_SALT', 'bLYCx_>}C[aCw+=H!t~` cqc#jTpkY+!3JYKWNmDYTt>sSjch&.m+f2*3{Ia[6(D' );
define( 'LOGGED_IN_SALT',   'V^Mf4PULZ/(8+`HD&&xhO& w4J]`vgC!q0R$v:+NbR/ xm)?j|}NcZ7(xNxj6zp=' );
define( 'NONCE_SALT',       '69v`nHASj;$)EN-Xxgep+Fge~*tjwQ(c6w|uX:JOL:]xD?n$K9_@=N0Y(mZwZ)zZ' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

