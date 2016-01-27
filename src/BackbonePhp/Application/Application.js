/**
 * BackbonePHP main application script, initializes and starts the front-end
 * 
 * @param {jQuery} $ The jQuery library
 * @param {Object} bb BackboneJS library
 * @param {Object} _ The underscore library
 * @param {Function} Request Request class
 * @param {Function} Router Backbone router class
 * @param {Object} config Frontend configuration
 */
require([
    'jquery',
    'backbone',
    'underscore',
    'backbonePhp/Request/Request',
    'backbonePhp/Router/Router',
    'json!api/config'
], 
function($, bb, _, Request, Router, config) {
    
    "use strict";
    
    // forward global events to backbone
    $(window).on('resize', _.throttle(function(e) { bb.trigger('resize:window', e); }, 1000));
    $(window).on('scroll', _.throttle(function(e) { bb.trigger('scroll:window', e); }, 100));
    $(document).on('click', function(e) { bb.trigger('click:document', e); });
    $(document).on('keydown', function(e) { bb.trigger('keydown:document', e); });
    $(document).on('keypress', function(e) { bb.trigger('keypress:document', e); });
    $(document).on('keyup', function(e) { bb.trigger('keyup:document', e); });
    
    // init request
    bb.request = new Request(window.location);
    
    // instantiate the router
    bb.router = new Router(config);
        
    // start the application
    bb.history.start({
        pushState: true,
        root: config.appBase.replace(/\/$/, '')
    });
        
});
