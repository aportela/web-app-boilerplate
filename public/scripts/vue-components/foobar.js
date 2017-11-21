var foobar = (function () {
    "use strict";

    var template = function () {
        return `
    <section class="hero is-fullheight is-light is-bold" v-if="! loading">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column is-4 is-offset-4">
                        <h1 class="title has-text-centered">Foobar</h1>
                        <h2 class="subtitle is-6 has-text-centered">success!</h2>
                        <p class="has-text-centered">
                            <a href="https://github.com/aportela/web-app-boilerplate"><span class="icon is-small"><i class="fa fa-github"></i></span>Project page</a> | <a href="mailto:766f6964+github@gmail.com">by alex</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer" v-if="apiError">
            <foobar-api-error-component v-bind:apiError="apiError" v-bind:visible="apiError"></foobar-api-error-component>
        </footer>
    </section>
    `;
    };

    var module = Vue.component('foobar-component', {
        template: template(),
        created: function () {
        },
        data: function () {
            return ({
                loading: false,
                errors: false,
                apiError: null,
            });
        },
        created: function () {
            var self = this;
            self.loading = true;
            this.poll(function (response) {
                if (response.ok) {
                    self.loading = false;
                } else {
                    self.errors = true;
                    self.apiError = response.getApiErrorData();
                    self.loading = false;
                }
            });
        },
        methods: {
            poll: function (callback) {
                var self = this;
                self.loading = true;
                foobarAPI.poll(function (response) {
                    self.loading = false;
                    callback(response);
                });
            }
        }
    });

    return (module);
})();