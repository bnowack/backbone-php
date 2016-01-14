/**
 * BackbonePHP main application script 
 * 
 * Sets up the application
 * 
 * @param {jQuery} $ The jQuery library
 * @param {Object} backbone BackboneJS library
 * @param {Object} garbageCollection Garbage collection library
 * @param {Object} events Global events library
 * @param {Function} Request Request class
 * @param {Function} Router Backbone router class
 */
require([
    'jquery',
    'backbone',
    'backbonePhp/Utils/garbageCollection',
    'backbonePhp/Utils/events',
    'backbonePhp/Request/Request',
    'backbonePhp/Router/Router',
    'text',
    'css'
], 
function($, backbone, garbageCollection, events, Request, Router) {
    
    // start garbage collection
    garbageCollection.start();
    
    // activate global events
    events.initialize();
    
    // init request
    backbone.request = new Request(window.location);
    
    // load config
    $.get('config', function(config) {
        backbone.config = config;
        // instantiate router and start the application
        (new Router())
            .enablePushStateLinks(config.appBase)
            .setExternalLinkTargetFor('body', '_ext')
            .activateRoutes()
            .start(config.appBase)
        ;
    });
    return;
    

});
