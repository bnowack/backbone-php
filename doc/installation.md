# Installation

*  Create the following `/composer.json` file and copy it to your project's root directory (everything in require-dev is optional):

        {
            "name": "your/project",
            "require": {
                "bnowack/backbone-php": "0.1.3"
            },
            "require-dev": {
                "behat/behat": "3.0.15",
                "emuse/behat-html-formatter": "0.1.*",
                "vanare/behat-cucumber-json-formatter": "1.1.1",
                "phpspec/phpspec": "2.4.0",
                "behat/mink": "1.6.0",
                "phpunit/phpunit": "5.1.3",
                "behat/mink-goutte-driver": "1.2.0",
                "behat/mink-extension": "2.1.0",
                "behat/mink-selenium2-driver": "1.2.0",
                "henrikbjorn/phpspec-code-coverage": "2.0.1",        
                "ext-xdebug": ">=2.2.1",
                "bnowack/scss-watcher": "1.0.6"
            },
            "repositories": [
            ],
            "config": {
                "bin-dir": "bin"
            },
            "autoload": {
                "classmap": [
                ],
                "psr-4": {
                    "": "src/"
                }
            }
        }

* run `composer update` from the command line.
* For Apache users: copy `/vendor/bnowack/backbone-php/sample.htaccess` to `/.htaccess` and adjust `RewriteBase` if needed.
* Create an application configuration file in `/config/application.json`, set `appBase` to your `RewriteBase` and adjust or remove the entries:

        {
            "appBase": "/",
            "appVersion": "0.1.0",
            "appName": "My application",
            "appDescription": "it's great",
            "appLanguage": "en",
            "pageTitleDelimiter": " - ",
            "webIcon": "src/img/favicon.ico",
            "appIcon": "src/img/touch-icon.png"
        }
