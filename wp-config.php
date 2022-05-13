<?php
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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ecommerce' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

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
define( 'AUTH_KEY',         'hqU%;U%N^#&%|x7ttk@VSEuK#-^pE@p_o:xwCsYB B:rjh; =eYF:4@J2ki]A5@P' );
define( 'SECURE_AUTH_KEY',  ';}%(8eSdW3!(27=anxzR*Dbvm<;$h8C?@| >a0_!%eX$D~R@$aRNy[Wg9WkPlIUZ' );
define( 'LOGGED_IN_KEY',    ',>wPI3|z-uNCt0D=:|L;H4RHbxE%KOhB.!tN(Z=4%t#v@@Elc]RmL[F-g0%;o9U6' );
define( 'NONCE_KEY',        'XY!=9#:JaO+;QBst(&Hul YDs-;U#>w{E,*gP~#}uWjI,o{:Qe~.*,FXFL$CEUI&' );
define( 'AUTH_SALT',        '<:kF3l(_6M%Y3ckGgnbh@YS}{W4ZWmK;S5v3B0n0I1;pw*3J|K8wXZ.}{Iq E<Gc' );
define( 'SECURE_AUTH_SALT', '(pZ%ge}sb(1eL@swlr~Tb&^`nFMTi].*BIw`hoLb5kt}ytY9Y+@>6a]}NbQeu/.X' );
define( 'LOGGED_IN_SALT',   'j|nHgT&!EPp_X{CADwis|2L=)!z Pe2KSonVvXE:FW9Te<T=~Ehj72SMf4aHxX]l' );
define( 'NONCE_SALT',       '5y7L&uv9-ESl2GWWGQJOs-7l40qQ]vK;BJ*]t^Is#TM3shIxic?<Tyv,$ZQO4|N)' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
