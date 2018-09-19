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
define('DB_NAME', 'tanktracker');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '1r00mP3*KT%J9O31inJJZ3LlMcpWvDGm9#KTo59QEjtF!z1jFSmoaX&xNgPnckfU');

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
define('AUTH_KEY',         'n@@U&.qN%d vvR5v5=`#XD_}OT4,- 9OX&?{R&)#ff2Ci |;RN2}A|{hWDL;h%j}');
define('SECURE_AUTH_KEY',  'iBBOl_=bID5R)x:I{1/<8%RzcY<4;=-QIF`cV*.hUAnzSGDjeR<s<ALR(XB|=-Lz');
define('LOGGED_IN_KEY',    'Kf1Fa7o)4)DqSy=DVv/TAu|/TYlX0WKzh?WUlQq@LasvyQETc}_znRo/s6;jY4/[');
define('NONCE_KEY',        ':.>#Lz:FJ6Hc2s<$(6C;Za`NLy-fHV86FEdm!/.O&3d_].~IEq1<prwY(VlK=>Ya');
define('AUTH_SALT',        'IZEDj.o2<ot;fgX-lRNo[^9Tc#VQ(RAxM0ae&T%=+]&tw1C+MA _*hAHq9{rLmDo');
define('SECURE_AUTH_SALT', 'D}#KICZSbhKO/wDFj=Rl?8R ^D6eg:8I/983HaRheM,$$v9azdU8?NW<dINYnA3%');
define('LOGGED_IN_SALT',   '<=P3:9pT-#Z*<9ErTS)T&2MA-@o:WxXAuGqq C#2Oh_yySP{vL$ed1/tnsIg^q01');
define('NONCE_SALT',       '8VNa1KI{n7hyK#AEz1i.-!Q[w>n7ouIDWpWY3Ng=&au)BeF<d>0JCS$^97Vj8lZ{');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tt_';

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
