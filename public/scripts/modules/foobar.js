import { mixinErrors as mixinErrors } from './mixins.js';
import { default as foobarAPI } from './api.js';

const template = `
    <section class="hero is-fullheight is-light is-bold" v-if="! loading">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column is-4 is-offset-4">
                        <h1 class="title has-text-centered">Foobar</h1>
                        <h2 class="subtitle is-6 has-text-centered">success!</h2>
                        <p class="has-text-centered">
                            <a href="https://github.com/aportela/web-app-boilerplate" target="_blank"><span class="icon is-small"><i class="fab fa-github"></i></span>Project page</a> | <a href="mailto:766f6964+github@gmail.com">by alex</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
`;

export default {
    name: 'foobar-component',
    template: template,
    data: function () {
        return ({
            loading: false
        });
    },
    mixins: [
        mixinErrors
    ],
    created: function () {
        this.poll();
    },
    methods: {
        poll: function () {
            var self = this;
            self.loading = true;
            foobarAPI.poll(function (response) {
                self.loading = false;
                if (response.ok) {
                } else {
                    self.showApiError(response.getApiErrorData());
                }
            });
        }
    }
}
