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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'vlnp_db' );

/** Database username */
define( 'DB_USER', 'vlnp' );

/** Database password */
define( 'DB_PASSWORD', 'vlnppassword' );

/** Database hostname */
define( 'DB_HOST', 'mariadb' );

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
define( 'AUTH_KEY',         'm/zauxdOUA6oY@BE4{D`2RHIvwK}/eDSo<ce*z?GHFJD`fYed{IZAs3|#EjWu)Cb' );
define( 'SECURE_AUTH_KEY',  ' eS.~ju/dCE0Xoc6JV7Equ4dQt ?mmhc{CTh]L2lxjJHO/jT4(SX/-Zeg3!IyJa.' );
define( 'LOGGED_IN_KEY',    'Ma,6o,!FKh[~!?p1d.f;^phXHDCkR8?i3_+~sU;t380b2SZ0&#r~c]unc6[3v lw' );
define( 'NONCE_KEY',        'd*ghs5$#us%>A|0I5v,i.%utS;.xNhF/^uk7:R|.ifuxI@46N}=gN~U*|cey:>0t' );
define( 'AUTH_SALT',        '#RE+vM@ac35e^$18}aIfw[ScR{qJO%sL4<C9w^ O!Y{u/![#fJ%;qw(PkW~90nM&' );
define( 'SECURE_AUTH_SALT', '8l|.hCaaFAs!f+$P*7DKhaIKe_ r<8KP0xnrwH$D4yo<#[[)|HQ3|xet=6u=zkPB' );
define( 'LOGGED_IN_SALT',   '?^,II,74L,VU~d}dyfo6EuQsccVcBwzcWsTT~$Gvp#b~R$<Ddj-^a%RpBDIta }y' );
define( 'NONCE_SALT',       'MsrS#{#i(X-P^iJhAL6wwofB!WO%+[dI*<p[}o0LC#^s Mmr%(XVl2*W9yPueH/p' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
