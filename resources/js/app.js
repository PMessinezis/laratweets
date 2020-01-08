/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.moment = require('moment');
window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('vtweet', require('./components/vtweet.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        allTweets: [],
        filter: '',
        refreshCounter: 0,
        interval: 0,
        error: '',
    },
    computed: {
        tweets() {
            filter = this.filter.toLowerCase();
            filterTweets = function (tweet) {
                return tweet.text.toLowerCase().includes(filter) ||
                    tweet.user.name.toLowerCase().includes(filter) ||
                    tweet.user.screen_name.toLowerCase().includes(filter)
            }
            return filter ? this.allTweets.filter(filterTweets) : this.allTweets;
        },
    },
    created() {
        this.loadTweets()
    },
    methods: {
        stopRefresh() {
            clearInterval(this.interval);
        },

        startRefresh() {
            this.interval = setInterval(this.loadTweets, 180000);
        },

        loadTweets() {
            var me = this
            this.stopRefresh();
            axios.get('/twitter/timeline')
                .then(response => {
                    if (response.data.errors) {
                        me.error = response.data.errors[0].message;
                    } else {
                        me.error = '';
                        me.allTweets = response.data
                        this.startRefresh();
                    }
                })
                .catch(error => {
                    console.log('error ', response.data)
                    me.error = error.message
                    console.log(error)
                })
        }
    }


});
