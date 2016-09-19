[![Build Status][0]][1]

randomhost/steamsignature
=========================

This package reads the [Steam Web-API][2] and [community XML data][3] of Valve's
Steam platform and displays the current online status of players as PNG image,
designed to be used in forum and blog signatures.

The included link target method detects whether the player is currently playing
on a multiplayer server and returns either the URL to the player's steam profile
or the URL for joining the game using the visitor's locally installed Steam
client if this is supported by the game.

Usage
-----

A basic approach at using this package could look like this:

```php
<?php
namespace randomhost\Steam;

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
your API key from the [Steam developer website][4].

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
 
An example implementation of this script can be found in the `src/www/` folder.

License
-------

See LICENSE.txt for full license details.

[0]: https://travis-ci.org/randomhost/steamsignature.svg
[1]: https://travis-ci.org/randomhost/steamsignature
[2]: https://developer.valvesoftware.com/wiki/Steam_Web_API
[3]: https://partner.steamgames.com/documentation/community_data
[4]: http://steamcommunity.com/dev
