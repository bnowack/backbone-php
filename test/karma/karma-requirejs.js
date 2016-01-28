/* global require */

var allTestFiles = [];
var TEST_REGEXP = /(spec|test)\.js$/i;

// Get a list of all the test files to include
Object.keys(window.__karma__.files).forEach(function (file) {
    if (TEST_REGEXP.test(file)) {
        // Normalize paths to RequireJS module names.
        // If you require sub-dependencies of test files to be loaded as-is (requiring file extension)
        // then do not normalize the paths
        var normalizedTestModule = file.replace(/^\/base\/|\.js$/g, '');
        allTestFiles.push(normalizedTestModule);
    }
});

require.config({
    // Karma serves files under /base, which is the basePath from your config file
    baseUrl: '/base',
    
    paths: {
        // lib
        jquery:                 'vendor/jquery/jquery/jquery-2.2.0.min',
        qunit:                  'vendor/qunit/qunit-1.20.0',

        underscore:             'vendor/jashkenas/underscore/underscore-min',
        underscore_string:      'vendor/epeli/underscore.string/underscore.string.min',
        backbone:               'vendor/jashkenas/backbone/backbone-min',
        velocity:               'vendor/julianshapiro/velocity/velocity.min',
        velocity_ui:            'vendor/julianshapiro/velocity/velocity.ui.min',
        // requireJS
        text:                   'vendor/requirejs/text/text',
        css:                    'vendor/dimaxweb/CSSLoader/css',
        async:                  'vendor/millermedeiros/requirejs-plugins/src/async',
        json:                  'vendor/millermedeiros/requirejs-plugins/src/json',
        noext:                  'vendor/millermedeiros/requirejs-plugins/src/noext',
        // framework
        BackbonePhp:            'src/BackbonePhp'
    },
    // example of using a shim, to load non AMD libraries (such as underscore)
    shim: {
        'underscore': {
            exports: '_'
        }
    },
    // dynamically load all test files
    deps: allTestFiles,
    // we have to kickoff jasmine, as it is asynchronous
    callback: window.__karma__.start
});
