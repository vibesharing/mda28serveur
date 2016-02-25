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
define('DB_NAME', 'wordpress2');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '2}ajExrB+&X(p ^J@#|>k=>62M|~#-F+x4KP}I:;pzKeQ-<ooP?u>96-w8z%^Zv1');
define('SECURE_AUTH_KEY',  'DHOuHQ&qp?nm^@7X`]3}5,$$_-_y)CQH#+r)7/#n79l`sNQwT%S,h(bFd`+r=hl9');
define('LOGGED_IN_KEY',    'FfO4~qMZu%#e.+o6$u.*.cnFNSR(*PS+5%b3bF1<B+9<c>nXUC?mKuS6-qS9+CCI');
define('NONCE_KEY',        'LC:sS+OH1]%<iz;R7DY|2ymqIam;V>w;HwFR/xlsYi^8+KV>-*[HO-M=Y1v+X1w]');
define('AUTH_SALT',        'IZ#58NH|L@gS$s:(0XrpL93<0VOp{W1;+sH`9w;g=c($*^Th.ZwDy{0p{n-K-e6h');
define('SECURE_AUTH_SALT', '%ep?8(Ejc=kqmXTG|mQbVP!IZhfZX1S5r~o|S9FzF_f/q-[,kQAwe{JH}(<9$D?$');
define('LOGGED_IN_SALT',   'PqOF*Y6D#sX9!<fodnXBFF]E,GI?#]*Ha^nnZ;+[V!:p.g|}(==(8U,N]4QUqn*V');
define('NONCE_SALT',       'cBw|FV2oK_n+@|I ?c_|f>>K0SfiI.TB_Ib0yZM@?^Ubq+5{Wn|5Z``!@oP^xypp');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
