
require('./bootstrap');

window.moment = require('moment');

window.Vue = require('vue');

Vue.component('vtweet', require('./components/vtweet.vue').default);

const app = new Vue({
    el: '#app',

    data: {
        allTweets: [],
        filter: '',
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

        newestTweet() {
            if (!this.allTweets.length) {
                return null
            }
            return this.allTweets.reduce((tweetA, tweetB) => (tweetA.id > tweetB.id ? tweetA : tweetB))
        },

        loadTweets() {
            var me = this
            this.stopRefresh();
            var params = {};
            var newestTweet = this.newestTweet();
            if (newestTweet) {
                params = { since_id: newestTweet.id }
            }
            axios.get('/twitter/timeline', { params: params })
                .then(response => {
                    if (response.data.errors) {
                        me.error = response.data.errors[0].message;
                    } else {
                        me.error = '';
                        if (newestTweet) {
                            me.allTweets = response.data.concat(me.allTweets)
                        } else {
                            me.allTweets = response.data
                        }
                        this.startRefresh();
                    }
                })
                .catch(error => {
                    me.error = 'Failed to retrieve tweets'
                    console.log(error)
                })
        }
    }


});
