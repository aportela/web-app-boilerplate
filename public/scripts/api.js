"use strict";

/**
 * common object for interact with API
 * all methods return callback with vue-resource response object
 */
const foobarAPI = {
    poll: function (callback) {
        Vue.http.get("api/poll").then(
            response => {
                if (callback && typeof callback === "function") {
                    callback(response);
                }
            },
            response => {
                if (callback && typeof callback === "function") {
                    callback(response);
                }
            }
        );
    }
};