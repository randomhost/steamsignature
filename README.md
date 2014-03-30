[![Build Status](https://travis-ci.org/Random-Host/PHP_Steam_Signature.svg)](https://travis-ci.org/Random-Host/PHP_Steam_Signature)

PHP_Steam_Signature
===================

This package reads the XML feeds of Valve's Steam platform and displays the
current online status of players as PNG image, designed to be used in forum and
blog signatures.

The included redirect function detects whether the player is currently playing
on a multiplayer server and either redirects visitors clicking the signature
image to the player's steam profile or turns into a join link which will connect
directly to the multiplayer server if Steam is running on the visitors system.

Usage
-----

The PHP_Steam_Signature package API is currently in the process of being
written. A usage example will follow once the API is considered stable enough.

System-Wide Installation
------------------------

PHP_Steam_Signature should be installed using the [PEAR Installer](http://pear.php.net).
This installer is the PHP community's de-facto standard for installing PHP
components.

    sudo pear channel-discover pear.random-host.com
    sudo pear install --alldeps randomhost/PHP_Steam_Signature

As A Dependency On Your Component
---------------------------------

If you are creating a component that relies on PHP_Steam_Signature, please make
sure that you add PHP_Steam_Signature to your component's package.xml file:

```xml
<dependencies>
  <required>
    <package>
      <name>PHP_Steam_Signature</name>
      <channel>pear.random-host.com</channel>
      <min>1.0.0</min>
      <max>1.999.9999</max>
    </package>
  </required>
</dependencies>
```

Development Environment
-----------------------

If you want to patch or enhance this component, you will need to create a
suitable development environment. The easiest way to do that is to install
phix4componentdev:

    # phix4componentdev
    sudo apt-get install php5-xdebug
    sudo apt-get install php5-imagick
    sudo pear channel-discover pear.phix-project.org
    sudo pear -D auto_discover=1 install -Ba phix/phix4componentdev

You can then clone the git repository:

    # PHP_Webcam_Overlay
    git clone https://github.com/Random-Host/PHP_Steam_Signature.git

Then, install a local copy of this component's dependencies to complete the
development environment:

    # build vendor/ folder
    phing build-vendor

To make life easier for you, common tasks (such as running unit tests,
generating code review analytics, and creating the PEAR package) have been
automated using [phing](http://phing.info).  You'll find the automated steps
inside the build.xml file that ships with the component.

Run the command 'phing' in the component's top-level folder to see the full list
of available automated tasks.

License
-------

See LICENSE.txt for full license details.
