<?php

//Begin Really Simple Security session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple Security cookie settings
//Begin Really Simple Security key
define('RSSSL_KEY', 'xnk1O9oPBZK8fbgBniO0i2SMqa0DU5U1Jr08fbJA24jQ9oYPltQavQggQa55EG82');
//END Really Simple Security key
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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          ',P?3H{> v_~`{{&J%.SEFL4?(&nxtberZ45oqH_AOz)}69%Jc$k!QUoOSklRL}S|' );
define( 'SECURE_AUTH_KEY',   '~>smpe/fW9rd=wg2;,%lz+<@zbc/&]xz(1piOlFLu)X1(#cYRpd#=%pIL<qZMi),' );
define( 'LOGGED_IN_KEY',     'U! ~?t- )x}.jkW(T3FQSlgut-+`;R6e{_Q{AdJW*m%dz|`;Rssk;My>6!_^=K%(' );
define( 'NONCE_KEY',         'QcAo:,v~zq8 &#vy#qbB7!0BVYj=3GLJ(_E*:M[.EwVE:W7pa}-[;b@9yD]RIBc&' );
define( 'AUTH_SALT',         '@qkpcZ|QQ<Izc?|>SN-9f{CCv^LG1Rv5x?]JbuwIsKzcZ8oYEnHSK<D=Rq~ 4e&x' );
define( 'SECURE_AUTH_SALT',  '$qN<6y,e/|6TD$%4w~YH_1[zpH^Q+;_2G>Kmu`w$f{J: /*U/EB6REVg#-y@>}Qq' );
define( 'LOGGED_IN_SALT',    '$piORI>w)=fpLW4~bku{v5Mg1-f5Q|ohsa-_h:7}0|=|!XAP~`-DAkIysseo}%i|' );
define( 'NONCE_SALT',        'jpoSkO;=&Rr4_rSUTlgXF S&G@D40]Ric8&qOv=p<8<<fouD1-DtF wC:}i3|aMI' );
define( 'WP_CACHE_KEY_SALT', 'pTS+#q0iaFg,xe_?#j-L2P<GNZl:bi[;*JTarCoFdgoqz?%]w|:|oCi% r`:BrU}' );


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

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
