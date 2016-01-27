<!doctype html>
<html lang="{appLanguage}">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="x-ua-compatible" content="ie=edge"/>
        <title>{pageTitle}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content="{appDescription}"/>
        <base href="{appBase}" /><!--[if IE]></base><![endif]-->

        <meta name="og:site_name" content="{appName}"/>
		<meta name="og:title" content="{pageTitle}"/>
		<meta name="og:type" content="website"/>
		<meta name="og:image" content="{appIcon}"/>
        
        <!--[if lte IE 9]>
            <script type="text/javascript">
                window.useXDomainRequest = true;
                window.rewriteToHash = true;
            </script>
        <![endif]-->
        
        <script type="text/javascript">
            var require = {
                urlArgs: 'v=' + (location.host.match(/(local|192.168)/) ? Math.random() : '{appVersion}'),
                baseUrl: "{appBase}", // required for IE9
                paths: {
                    // polyfills
                    promise:                '{backbonePhpBase}vendor/jakearchibald/es6-promise/es6-promise.min',
                    // lib
                    jquery:                 '{backbonePhpBase}vendor/jquery/jquery/jquery-2.2.0.min',
                    underscore:             '{backbonePhpBase}vendor/jashkenas/underscore/underscore-min',
                    underscore_string:      '{backbonePhpBase}vendor/epeli/underscore.string/underscore.string.min',
                    backbone:               '{backbonePhpBase}vendor/jashkenas/backbone/backbone-min',
                    velocity:               '{backbonePhpBase}vendor/julianshapiro/velocity/velocity.min',
                    velocity_ui:            '{backbonePhpBase}vendor/julianshapiro/velocity/velocity.ui.min',
                    // requireJS
                    text:                   '{backbonePhpBase}vendor/requirejs/text/text',
                    css:                    '{backbonePhpBase}vendor/dimaxweb/CSSLoader/css',
                    async:                  '{backbonePhpBase}vendor/millermedeiros/requirejs-plugins/src/async',
                    json:                   '{backbonePhpBase}vendor/millermedeiros/requirejs-plugins/src/json',
                    noext:                  '{backbonePhpBase}vendor/millermedeiros/requirejs-plugins/src/noext',
                    // framework
                    backbonePhp:            '{backbonePhpBase}src/BackbonePhp/'
                }
            };
        </script>
        
        <link rel="shortcut icon" href="{webIcon}" data-size="32x32"/>
        <link rel="apple-touch-icon" href="{appIcon}" data-size="152x152"/>
        
        <link rel="stylesheet" type="text/css" href="{backbonePhpBase}vendor/necolas/normalize.css/normalize.css"/>
        <link rel="stylesheet" type="text/css" href="{backbonePhpBase}src/BackbonePhp/Application/css/application.css"/>
    </head>
    <body>
        {body}
        <script type="text/javascript" src="{backbonePhpBase}vendor/jrburke/requirejs/require.js"></script>
        <script type="text/javascript" src="{backbonePhpBase}src/BackbonePhp/Application/Application.js"></script>
    </body>
</html>
