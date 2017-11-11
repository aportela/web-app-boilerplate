"use strict";

/**
 * common object for interact with API
 * all methods return callback with vue-resource response object
 */
const foobarAPI = {
    poll: function (callback) {
        Vue.http.get(siteUrl + "/api/poll").then(
            response => {
                callback(response);
            },
            response => {
                callback(response);
            }
        );
    }
};