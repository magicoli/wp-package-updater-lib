# WP Package Updater - composer-ready library.

This is a set of all needed libraries to include in a plugin, to get automatic updates from Anexandre Froger's [WP Plugin Update Server](https://github.com/froger-me/wp-plugin-update-server).

Requirements:

- WP Plugin Update Server must be installed and configured
- Your plugin must appear in WP Plugin Update Server packages list
- Composer must be configured (if not run `composer init --type=wordpress-plugin` from your plugin root folder)

Install from command-line:

```bash
# Install package with composer
composer require magicoli/wp-package-updater-lib
# Add library to lib/wp-package-updater-lib
php vendor/magicoli/wp-package-updater-lib/install.php
# You should run install.php again each time the package is updated
```

To keep library up to date with `composer update`, insert this in composer.json:

```json
"scripts": {
  "post-update-cmd": [
    "php vendor/magicoli/wp-package-updater-lib/install.php"
  ]
}
```

Include the following in your main plugin file:

```php
// Adjust with your plugin uddate server URL
$wppul_server = 'https://magiiic.com';
$wppul_licence_required = false; // optional, set to true if licence is set in WPPUS

// Use autoload to load library
require_once( __DIR__ . '/lib/wp-package-updater-lib/package-updater.php' );
```

The `$wppul_server` variable will be unset by the library afterwards to prevent conflicts with any other plugin so it is not safe to use it for other purposes.

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
