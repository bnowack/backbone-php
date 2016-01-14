/**
 * Garbage collection for BackboneJS applications
 * 
 * @param {Object} Backbone BackboneJS
 * @returns {Object} Garbage collection library
 */
define([
    'backbone'
],
function(Backbone) {

    "use strict";
    
    var lib = {
        
        viewRegistry: {},

        start: function() {
            Backbone.View.prototype.destruct = function() {};// make extensible
            Backbone.View.prototype.destructView = function() {
                this.destruct();
                this.stopListening();
                this.off();
                this.undelegateEvents();
                this.$el
                    .html('')
                    .attr('data-view-id', '')
                ;
            };
            // collect garbage on render
            Backbone.listenTo(Backbone, 'view:render', lib.registerView);
        },

        registerView: function(newView) {
            lib.destructSubViews(newView.$el);
            lib.destructView(newView.$el);
            // register new view
            lib.viewRegistry[newView.cid] = newView;
            // mark container with new view id
            newView.$el.attr('data-view-id', newView.cid);
        },

        destructSubViews: function(containerEl) {
            containerEl.find('[data-view-id]').each(function(el) {
                lib.destructView($(el));
            });
        },

        destructView: function(viewEl) {
            var viewId = viewEl.attr('data-view-id');
            if (lib.viewRegistry[viewId]) {
                lib.viewRegistry[viewId].destructView();
                delete lib.viewRegistry[viewId];
            }
        }
        
    };
    
    return lib;
});
