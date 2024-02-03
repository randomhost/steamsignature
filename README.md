[![Build Status][1]][2]

# randomhost/steamsignature

<!-- TOC -->
* [1. Purpose](#1-purpose)
* [2. Example](#2-example)
* [3. Requirements](#3-requirements)
* [4. Installation](#4-installation)
* [5. Usage](#5-usage)
* [6. License](#6-license)
<!-- TOC -->

## 1. Purpose

This package reads the [Steam Web-API][3] and [community XML data][4] of Valve's
Steam platform and displays the current online status of players as PNG image,
designed to be used in forum and blog signatures.

The included link target method detects whether the player is currently playing
on a multiplayer server and returns either the URL to the player's steam profile
or the URL for joining the game using the visitor's locally installed Steam
client if this is supported by the game.

## 2. Example

[![Example Signature][5]][6]

## 3. Requirements

* PHP 8.x
* `mbstring` extension for handling international characters and emojis
* `GD` extension for rendering the images
* [Composer][7]
* basic knowledge of executing shell commands on a server

**Note:** The only **officially** supported way to install this package is via
Composer. However, it is theoretically possible to install PHP 8 and Composer
on a local computer, run the installation there and then upload the `vendor`
folder created by Composer to the server, in case shell access is not available.

## 4. Installation

**Important:** This package uses the [Composer][7] dependency manager for
PHP to check system requirements and to install package dependencies. Please
make sure it is installed before trying to use this package.

The following example assumes that your web server is running under the user
account `www-data`, that `composer` is installed into the system `$PATH`, and
that you have a working `sudo` setup to run shell commands as a different user.

In this case, you simply have to run this command within the same directory
which contains this `README.md` on your server:

```bash
sudo -u www-data composer install
```

## 5. Usage

A basic approach at using this package could look like this:

```php
<?php

declare(strict_types=1);

use randomhost\Steam\API;
use randomhost\Steam\Signature;

require_once '/path/to/vendor/autoload.php';

// setup directories
$imageDir = '/path/to/images/';
$fontsDir = '/path/to/fonts/';
$cacheDir = '/path/to/cache/';

// init an API instance for talking to the Steam Web API
$api = new API('yourSteamApiKey');

// resolve custom URL into steam ID
$steamId = $api->resolveVanityUrl('yourCustomProfileUrl');

// init Signature instance
$signature = new Signature($api, $steamId, $imageDir, $fontsDir, $cacheDir);

// renders the picture
$signature->render();

// returns a link to the user's profile page or a Steam join link
$signature->getLinkTarget();
```

The example above should be mostly self-explanatory.

The `API` class must be initialized with a personalized API key. You can obtain
your API key from the [Steam developer website][8].

The `API` class is a very limited implementation of the Steam Web-API and is not
supposed to be used directly, except for one method:

1. `API::resolveVanityUrl($vanityUrl)`  
    Resolves the given vanity URL into a 64-Bit Steam ID, ready to be passed to
    the `Signature` class constructor.

The `Signature` class provides two public methods:

1. `Signature::render()`  
    Outputs the signature image directly to the web browser.  
      
    **Note:** This method must be the only code which sends output to the web
    browser. If you receive `Cannot modify header information` errors, please
    ensure that your application does **not** generate any output **before**
    `Signature::render()` is called. Additionally, no output may be generated
    **after** calling this method as it would break the image.
    
2. `Signature::getLinkTarget()`  
    Returns a link to the Steam user's profile page or a join link to join the
    game the user is currently playing if the game supports joining through
    Steam.
 
An example implementation of this script can be found in the [`src/www/`](src/www)
folder.

## 6. License

See [LICENSE.txt](LICENSE.txt) for full license details.


[1]: https://github.com/randomhost/steamsignature/actions/workflows/php.yml/badge.svg
[2]: https://github.com/randomhost/steamsignature/actions/workflows/php.yml
[3]: https://developer.valvesoftware.com/wiki/Steam_Web_API
[4]: https://partner.steamgames.com/documentation/community_data
[5]: src/data/images/example.png
[6]: https://steamcommunity.com/id/randomhosttv
[7]: https://getcomposer.org
[8]: http://steamcommunity.com/dev
