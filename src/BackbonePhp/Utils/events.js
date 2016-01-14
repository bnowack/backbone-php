/**
 * Events library for BackboneJS applications
 * 
 * @param {jQuery} $ The jQuery library
 * @param {Object} _ The underscore library
 * @param {Object} Backbone The Backbone library
 * @returns {events_L12.lib}
 */
define([
    'jquery',
    'underscore',
    'backbone'
],
function($, _, Backbone) {

    "use strict";

    var lib = {
        
        initialize: function() {
            // proxy resize events to Backbone
            $(window).on('resize', _.throttle(function(e) {
                Backbone.trigger('window.resize', e);
            }, 1000));

            // proxy scroll events to Backbone
            $(window).on('scroll', _.throttle(function(e) {
                Backbone.trigger('window.scroll', e);
            }, 100));

            // proxy document clicks to Backbone
            $('body').on('click', function(e) {
                Backbone.trigger('body.click', e);
            });

            // proxy special keyboard events to Backbone
            $(document).on('keydown', function(e) {
                switch (e.which) {
                    case 9  : Backbone.trigger('keydown.tab', e); break;
                    case 13 : Backbone.trigger('keydown.enter', e); break;
                    case 108: Backbone.trigger('keydown.enter', e); break;
                    case 27 : Backbone.trigger('keydown.escape', e); break;
                    case 37 : Backbone.trigger('keydown.left', e); break;
                    case 38 : Backbone.trigger('keydown.up', e); break;
                    case 39 : Backbone.trigger('keydown.right', e); break;
                    case 40 : Backbone.trigger('keydown.down', e); break;
                }
            });

            // proxy keyup to Backbone
            $(document).on('keyup', _.debounce(function(e) {
                Backbone.trigger('keyup', e);
            }, 500));
        }
        
    };
    
    return lib;
});
