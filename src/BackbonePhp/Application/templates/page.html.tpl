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
                    promise:                'vendor/jakearchibald/es6-promise/es6-promise.min',
                    // lib
                    jquery:                 'vendor/jquery/jquery/jquery-2.2.0.min',
                    underscore:             'vendor/jashkenas/underscore/underscore-min',
                    underscore_string:      'vendor/epeli/underscore.string/underscore.string.min',
                    backbone:               'vendor/jashkenas/backbone/backbone-min',
                    velocity:               'vendor/julianshapiro/velocity/velocity.min',
                    velocity_ui:            'vendor/julianshapiro/velocity/velocity.ui.min',
                    // requireJS
                    text:                   'vendor/requirejs/text/text',
                    css:                    'vendor/dimaxweb/CSSLoader/css',
                    async:                  'vendor/millermedeiros/requirejs-plugins/src/async',
                    noext:                  'vendor/millermedeiros/requirejs-plugins/src/noext',
                    // framework
                    backbonePhp:            '{backbonePhpBase}src/BackbonePhp/'
                }
            };
        </script>
        
        <link rel="shortcut icon" href="{webIcon}" data-size="32x32"/>
        <link rel="apple-touch-icon" href="{appIcon}" data-size="152x152"/>
        
        <link rel="stylesheet" type="text/css" href="{appBase}vendor/necolas/normalize.css/normalize.css"/>
        <link rel="stylesheet" type="text/css" href="{backbonePhpBase}src/BackbonePhp/Application/css/application.css"/>
    </head>
    <body>
        {body}
        <script type="text/javascript" src="{appBase}vendor/jrburke/requirejs/require.js"></script>
        <script type="text/javascript" src="{backbonePhpBase}src/BackbonePhp/Application/Application.js"></script>
    </body>
</html>
