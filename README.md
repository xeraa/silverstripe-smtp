# PHPMailer for SilverStripe
Based on http://silverstripe.org/smtpmailer-module/ but as it's outdated and not available on GitHub I created this fork.


## Description
**silverstripe-smtp** automatically sends emails (e.g. from UserForms) to your provider's or host's SMTP server instead of using PHP's built-in ``mail()`` function.

**silverstripe-smtp** replaces the classic SilverStripe Mailer (using the ``mail()`` function) with PHPMailer 5.2.1 ([http://code.google.com/a/apache-extras.org/p/phpmailer/](http://code.google.com/a/apache-extras.org/p/phpmailer/), was [http://sourceforge.net/projects/phpmailer/](http://sourceforge.net/projects/phpmailer/)) to send emails via the SMTP protocol to a local or remote SMTP server.

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
3. If you want to fall back to the classic mailer without uninstalling the module: Edit ``smtp/_config.php`` and comment out the ``set_mailer`` statement


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
    All rights reserved.
   
    Redistribution and use in source and binary forms, with or without
    modification, are permitted provided that the following conditions are met:
        * Redistributions of source code must retain the above copyright
          notice, this list of conditions and the following disclaimer.
        * Redistributions in binary form must reproduce the above copyright
          notice, this list of conditions and the following disclaimer in the
          documentation and/or other materials provided with the distribution.
        * Neither the name of the authors nor the names of its contributors
          may be used to endorse or promote products derived from this
          software without specific prior written permission.

    THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS "AS IS" AND ANY
    EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
    WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
    DISCLAIMED. IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY
    DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
    (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
    LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
    ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
    (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
    SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.