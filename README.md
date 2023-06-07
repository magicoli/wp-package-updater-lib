# WP Package Updater - composer-ready library.

This is a set of all needed libraries to include in a plugin, to get automatic updates from Anexandre Froger's [WP Plugin Update Server](https://github.com/froger-me/wp-plugin-update-server).

**Warning**: TBH, I didn't test it yet, the purpose of the first commit is to make the necessary tests. I hope I remember to remove this line afterwards.

Requirements:

- WP Plugin Update Server must be installed and configured
- Your package must be configured in WP Plugin Update Server

To get automatic updates from your plugin, run:

```bash
composer require magicoli/wp-package-updater-lib
php vendor/magicoli/wp-package-updater-lib/install.php
```

This will get the package and install needed libraries in lib/wp-package-updater-lib/

Then in your main plugin file, add the following code:

```php
// Adjust with your plugin uddate server URL
$wppul_server = 'https://magiiic.com';
$wppul_licence_required = false;

// Use autoload to load library
require_once 'vendor/autoload.php';
```

Alternatively you can load the library directly, without autoload

```php
require_once( 'lib/wp-package-updater-lib/wp-package-updater-lib.php' );
```

The `$wppul_server` variable will be unset by the library afterwards to prevent conflicts with any other plugin so it is not safe to use inside you plugin.

WP Plugin Update Server allows to provide automatic updates for plugins hosted on github or

## Original README

### Description

Used to enable updates for plugins and themes distributed via WP Plugin Update Server.

### Requirements

The library must sit in a `lib` folder at the root of the plugin or theme directory.

Before deploying the plugin or theme, make sure to change the following value:

- `https://your-update-server.com` => The URL of the server where WP Plugin Update Server is installed.
- `$prefix_updater` => Change this variable's name with your plugin or theme prefix

### Code to include in main plugin file

#### Simple update

```php
require_once plugin_dir_path( __FILE__ ) . 'lib/wp-package-updater/class-wp-package-updater.php';

$prefix_updater = new WP_Package_Updater(
  'https://your-update-server.com',
  wp_normalize_path( __FILE__ ),
  wp_normalize_path( plugin_dir_path( __FILE__ ) ),
);
```

#### Update with license check

```php
require_once plugin_dir_path( __FILE__ ) . 'lib/wp-package-updater/class-wp-package-updater.php';

$prefix_updater = new WP_Package_Updater(
  'https://your-update-server.com',
  wp_normalize_path( __FILE__ ),
  wp_normalize_path( plugin_dir_path( __FILE__ ) ),
  true
);
```

### Code to include in functions.php

#### Simple update

```php
require_once get_stylesheet_directory() . '/lib/wp-package-updater/class-wp-package-updater.php';

$prefix_updater = new WP_Package_Updater(
  'https://your-update-server.com',
  wp_normalize_path( __FILE__ ),
  get_stylesheet_directory(),
);
```

#### Update with license check

```php
require_once get_stylesheet_directory() . '/lib/wp-package-updater/class-wp-package-updater.php';

$prefix_updater = new WP_Package_Updater(
  'https://your-update-server.com',
  wp_normalize_path( __FILE__ ),
  get_stylesheet_directory(),
  true
);
```
