# SF Chat Flotante

Contributors: santifrias
Tags: chat, floating button, multiple accounts, contact
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 1.1.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A professional WordPress plugin that adds a floating chat button with multiple accounts, configurable schedules, and advanced customization.

## Description

This plugin allows you to create a customized floating chat button on your WordPress site. It supports adding multiple contact accounts (e.g., Sales, Support), each with their own customizable schedules and availability times. 

### ✨ Main Features
- **Multiple Accounts**: Configure as many contact accounts as you need.
- **Advanced Scheduling**: Define multiple time ranges per account automatically synced to your WordPress timezone.
- **Customizable Icon**: Upload your own image from the media library.
- **Intuitive Admin Panel**: Modern and user-friendly interface.
- **Responsive Design**: Works perfectly on mobile devices and tablets.
- **Internationalization**: Ready to be translated into any language.

### 📋 Account Management
Each account can have:
- Descriptive label
- Phone number
- Default predefined message (optional)
- Active/inactive status toggle
- Multiple schedule ranges

## Installation

1. Upload the plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to 'Settings > Chat Flotante' to configure the plugin.

## Frequently Asked Questions

### How do I customize the button icon?
Navigate to Settings > Chat Flotante. Click on "Select image" and choose an image from your media library or upload a new one.

### How do I configure account schedules?
Inside each account setting, click "Add schedule". Select the days of the week and define the start and end times. You can add multiple time ranges. If no schedules are added, the account will be available 24/7.

## Extending the plugin

Everything site-specific should live in your own code, never in a modified copy
of this plugin: the same version is meant to run on every site.

### PHP filters

```php
add_filter( 'whatsapp_flotante_is_open', function ( $open, $account ) {
    return $open;  // final say on whether this account is within hours
}, 10, 2 );

add_filter( 'whatsapp_flotante_holidays', function ( $dates ) {
    $dates[] = '2026-12-25';  // closing days on top of the ones in settings
    return $dates;
} );

add_filter( 'whatsapp_flotante_available_accounts', function ( $available ) {
    return $available;
} );
```

### JavaScript event

Published in both modes, whether it opens or closes. Check the global first: if
your code runs after the event fired, you would miss it.

```js
function whenKnown( cb ) {
    if ( window.whatsappFlotanteEstado ) {
        cb( window.whatsappFlotanteEstado );
        return;
    }
    document.addEventListener( 'whatsappFlotante:estado', function ( e ) {
        cb( e.detail );
    }, { once: true } );
}

// detail: { abierto: boolean, cuentas: number, modo: "cliente"|"servidor" }
```

Note that in server mode the state is calculated when the page is generated, so
a cached page will report a stale value. Turn on the browser-side option for the
event to be reliable behind a page cache.

## Changelog

### 1.0.6
* Fixed: the plugin did not start up. The main class had lost its constructor
  and the method that loads and instantiates the other classes, so neither the
  settings page nor the floating button appeared. It raised no PHP error, it
  simply did nothing.
* Fixed the text domain, which pointed to `whatsapp-flotante` instead of
  `sf-chat-flotante`, preventing translations from loading.
* Renamed `languages/whatsapp-flotante.pot` to `sf-chat-flotante.pot`.
* Restored the release workflow and normalized CSS/JS line endings.

### 1.0.5
* Updated to meet WordPress Coding Standards.
* Security enhancements, improved sanitization and proper escaping.
* Resolved formatting and naming convention warnings.

### 1.0.4
* Addressed text domain mismatches in Admin classes.
* Added missing sanitization to admin forms.

### 1.0.0
* Initial release.
* Multiple contact accounts with advanced schedules.
* Customizable icon and responsive design.
