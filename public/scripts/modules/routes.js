import { default as foobar } from './foobar.js';
import { default as apiError } from './section-api-error.js';

export const routes = [
    { path: '/foobar', name: 'foobar', component: foobar },
    { path: '/api-error', name: 'apiError', component: apiError }
]
