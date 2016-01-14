/**
 * Request class for parsing query strings and hash values
 * 
 * @param {Object} _ The underscore library
 * @returns {Function} The request class
 */
define([
    'underscore'
],
function(_) {
    
    "use strict";

    return function() {
        
        this.params = []; // sorted list of params from query string
        
        /**
         * Parses query strings into its components
         * Supports repeated params, e.g.: ?categorie=vrij&zoekterm=kruis&categorie=persoon&zoekterm=joe&location=01&location=0102&location=010203
         * 
         * @param {string} query A query string
         * @param {Boolean} keepParams Whether to keep or replace the currently cached values
         * @returns {Object} The request instance
         */
        this.parseQuery = function(query, keepParams) {
            this.params = keepParams ? this.params : [];
            var matches = null;
            var regex = /^[?&]*([^=]+)=([^&]+)?/;
            do {
                var proceed = false;
                matches = query && query.match(regex);
                if (matches) {
                    var name = matches[1];
                    var value = matches[2] ? decodeURIComponent(matches[2].replace(/\+/g, ' ')) : '';
                    this.params.push({name: name, value: value});
                    query = query.slice(matches[0].length);
                    proceed = query.length ? true : false;
                }
            }
            while (proceed);
            return this;
        };
        
        this.parseHash = function(hash, keepParams) {
            var query = hash.replace(/^[^\?]+/, '');
            this.parseQuery(query, keepParams);
        };
        
        this.getCopy = function(value) {
            return JSON.parse(JSON.stringify(value));
        },
        
        this.get = function(name, defaultValue) {
            var result = [];
            _.each(this.params, function(param) {
                if (param.name === name) {
                    result.push(param.value);
                }
            });
            switch (_.size(result)) {
                case 0: 
                    return _.isUndefined(defaultValue) ? null : defaultValue;
                case 1: 
                    return result[0];
                default: 
                    return result;
            }
        };
        
        this.getArray = function(param) {
            var result = this.get(param, []);
            return _.isArray(result) ? result : [result];
        },
        
        this.getFirst = function(param, defaultValue) {
            var result = this.get(param, defaultValue);
            return _.isArray(result) ? _.first(result) : result;
        };
        
        this.getLast = function(param, defaultValue) {
            var result = this.get(param, defaultValue);
            return _.isArray(result) ? _.last(result) : result;
        };
        
        this.getAt = function(param, position, defaultValue) {
            var result = this.getArray(param);
            if (!_.isUndefined(result[position])) {
                return result[position];
            }
            else {
                return _.isUndefined(defaultValue) ? null : defaultValue;
            }
        };
        
        this.getAll = function() {
            return this.getCopy(this.params);
        },
        
        this.initialize = function(location) {
            this.location = location;
            this.parseQuery(this.location.search);
            this.parseHash(this.location.hash, true);
        };
        
        // constructor
        this.initialize.apply(this, arguments);        
        
    };
    
});
