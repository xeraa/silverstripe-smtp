# PHPMailer for SilverStripe
Based on http://silverstripe.org/smtpmailer-module/ but as it's outdated and not available on GitHub I created this fork.


## Description
silverstripe-smtp automatically sends emails (e.g. from UserForms) to your provider's or host's SMTP server instead of using PHP's built-in ``mail()`` function.

silverstripe-smtp replaces the classic SilverStripe Mailer (using the ``mail()`` function) with PHPMailer (http://sourceforge.net/projects/phpmailer/) to send emails via the SMTP protocol to a local or remote SMTP server.

When would you use this module:

* If your provider disabled ``mail()``
* If you have troubles sending emails because of the DNS configuration and the way some mail servers discard emails if the domain names don't match
* If you want to send emails from your local web server without having to install a mail server, using an external SMTP server instead
* If you want to send encrypted emails (using SSL or TLS protocols)


## Requirements
SilverStripe 2.4+ (might work with 2.3, but only tested on 2.4)


## Installation
1. Extract the ``silverstripe-smtp`` folder into the top level of your site and rename it to ``smtp``
2. Without any configuration, the module is going to connect to the mail server on localhost without authentication
3. If you want to fall back to the classic Mailer without uninstalling the module: edit ``smtp/_config.php`` and comment out the ``set_mailer`` statement


## Configuration
Configure the module by editing ``mysite/_config.php`` and set the following constants:

    //Required:
    define('SMTPMAILER_SMTP_SERVER_ADDRESS', 'smtp.gmail.com'); //SMTP server address
    define('SMTPMAILER_DO_AUTHENTICATE', true); //Turn on SMTP server authentication. Set to false for an anonymous connection
    define('SMTPMAILER_USERNAME', 'foo@gmail.com'); //SMTP server username, if SMTPAUTH == true
    define('SMTPMAILER_PASSWORD', 'bar'); //SMTP server password, if SMTPAUTH == true

    //Optional:
    define('SMTPMAILER_CHARSET_ENCODING', 'utf-8'); //Email characters encoding, e.g. : 'utf-8' or 'iso-8859-1'
    define('SMTPMAILER_USE_SECURE_CONNECTION', 'ssl'); //SMTP encryption method : Set to '', 'tls', or 'ssl'
    define('SMTPMAILER_SMTP_SERVER_PORT', 465); //SMTP server port. Set to 25 if no encryption is used, 465 if ssl or tls is activated
    define('SMTPMAILER_DEBUG_MESSAGING_LEVEL', 0); //Print debugging informations. 0 = no debuging, 1 = print errors, 2 = print errors and messages, 4 = print full activity
    define('SMTPMAILER_LANGUAGE_OF_MESSAGES', 'de'); //Language for messages. Look into smtp/code/vendor/language/ for available languages


## License
    Copyright (c) 2008 Renaud Merle, 2011 Philipp Krenn

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.