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
define( 'DB_NAME', 'mingguvillas' );

/** MySQL database username */
define( 'DB_USER', 'mingguvillas' );

/** MySQL database password */
define( 'DB_PASSWORD', 'mingguvillas' );

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
define( 'AUTH_KEY',         '/a%3gtO/CI>F QsB/Q(qa;yl}5j_uomu-<liNS3x+3O4.E;_#:G.gw6!!92y,@s7' );
define( 'SECURE_AUTH_KEY',  'N,A4ReYqS06a>qp,#*xAy&d3G~z6+a!V4$N%Fjd2#S!YyBg1A;I##%]>q/7`$ HX' );
define( 'LOGGED_IN_KEY',    'pm`O` &/hkdmTYWd%IiiZ|ARB`5_4AC^P,o:.ITn}I$Zp gM]!|l1/QI`!aH;5=Q' );
define( 'NONCE_KEY',        '|qh|:x4/2gXMOp}mK~m$5N;[`}iWax]c~.TyjntGLqHqb^cq>Wyj.I65y=|D58gj' );
define( 'AUTH_SALT',        'r4lKN_B;7/8O~Ow|8,,|Ge>rS&(%IpneW&I &1o2S.,+ua{]vsb]M6L%R,D]!uP4' );
define( 'SECURE_AUTH_SALT', '~TC>_DI}].vJT=Fnd)e}7zrFIW[ bHKwO#,}?]|r~6iXLXS2 @ptm/.4Ok9(W6;9' );
define( 'LOGGED_IN_SALT',   'B,{^m)nkgFoO[Qiq|0~E=RyeN~~9KA=sX[X8^,(V$<&hk#7M2pJ[41cTHiS4bF;7' );
define( 'NONCE_SALT',       'SLxvEImguV13%TaU|I9!awQ>X+2mcK:ue<X Is4HX|.#oc|KGd(D%407,@~{Kq!7' );

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
define( 'WP_DEBUG', false );

define( 'AUTOSAVE_INTERVAL', 300 );
define( 'WP_POST_REVISIONS', 5 );
define( 'EMPTY_TRASH_DAYS', 7 );
define( 'WP_CRON_LOCK_TIMEOUT', 120 );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
define('ALLOW_UNFILTERED_UPLOADS', true);
define( 'WP_MEMORY_LIMIT', '256M' );
