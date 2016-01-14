/**
 * Backbone Router class for push-state-enabled apps
 * 
 * @param {Object} backbone BackboneJS
 * @param {function} require RequireJS
 * @param {jQuery} $ The jQuery library
 * @param {Object} _ The underscore library
 * @returns {Backbone.Router} A backbone router
 */
define([
    'backbone',
    'require',
    'jquery',
    'underscore'
],
function(backbone, require, $, _) {
    
    "use strict";

    var Router = {
        
        /**
         * Starts the route dispatching
         * 
         */
        start: function(appBase) {
            console.log('start')
            backbone.history.start({
                pushState: true,
                root: appBase.replace(/\/$/, '')
            });
            return this;
        },
        
        /**
         * Called when a route change was detected
         * 
         * @param {type} callback
         * @param {type} args
         * @returns {undefined}
         */
        execute: function(callback, args) {
            backbone.trigger('route:beforeChange');
            if (callback) {
                callback.apply(this, args);
            }
            return this;
        },
        
        /**
         * Passes local link clicks to the router instead of the browser
         * 
         * @param {String} selector A CSS selector
         * @returns {Router} A Backbone Router instance
         */
        enablePushStateLinks: function(appBase) {
            var self = this;
            $('body').on('click', 'a', function(e) {
                var el = $(this);
                var href = el.attr('href');
                if (!href) {
                    return;
                }
                var path = href.slice(appBase.length);
                if (path && href.match(/^\/[^\/]/)) {// local path
                    e.preventDefault();
                    // allow views to cancel the event and handle it themselves
                    setTimeout(function() {
                        if (el.attr('data-ignore-click') !== 'true') {
                            var trigger = el.attr('data-route') === 'false' ? false : true;
                            self.navigate(path, {trigger: trigger});
                        }
                    }, 50);
                }
            });
            return this;
        },
        
        /**
         * Opens external links matching the given selector in the specified target window/tab
         * @param {String} selector A CSS selector
         * @param {String} target A window/tab name
         * @returns {Router} A Backbone Router instance
         */
        setExternalLinkTargetFor: function(selector, target) {
            $('body').on('click', selector, function(e) {
                if (e.target.hostname && e.target.hostname !== location.hostname) {
                    $(e.target).attr('target', target);
                }
            });
            return this;
        },
        
        activateRoutes: function(routes) {
            var self = this;
            _.each(routes, function(route) {
                self.route(route.pattern, route.name, function() {
                    self.executeCommand(route.command, {arguments: _.toArray(arguments)});
                });
            });
            return this;
        },
        
        executeCommand: function(commandName, options) {
            options = options || {};
            require([commandName], function(Command) {
                var command = new Command(options);
                command.execute(); 
            });
            return this;
        },
        
        initialize: function() {
            var self = this;
            // ie hack
            if (window.rewriteToHash && location.search && !location.hash) {
                var hashUrl = location.href.replace('?', '#?');
                location.replace(hashUrl);
            }
            this.listenTo(backbone, 'route:change', function(path) {
                self.navigate(path, {trigger: true});
            });
        }        
        
    };
    
    return backbone.Router.extend(Router);
    
});
