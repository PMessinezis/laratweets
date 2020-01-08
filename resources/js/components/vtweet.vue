<template>
    <div class="container wrapper">
        <div>
            <a
                :href=" 'https://twitter.com/' + tweet.user.screen_name"
                style="weight:bold"
                v-html="tweet.user.name"
            ></a>
            <a
                :href=" 'https://twitter.com/' + tweet.user.screen_name"
                v-html="'@' + tweet.user.screen_name"
            ></a>
            <span class="since pull-right">{{ since }}</span>
        </div>
        <div>
            @{{ tweet.text }}
            <span v-if="tweet.entities.urls.length">
                <a
                    :href="tweet.entities.urls[0].url"
                    target="_blank"
                >{{ tweet.entities.urls[0].display_url }}</a>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: ["tweet"],
    computed: {
        since() {
            return moment(
                this.tweet.created_at,
                "dd MMM DD HH:mm:ss ZZ YYYY",
                "en"
            ).fromNow();
        }
    }
};
</script>

<style scoped>
.since {
    font-size: 0.7em;
}
.wrapper {
    padding: 15px;
    margin: 15px 5px 0px 0px;
    border-radius: 15px;
    border: 1px solid gray;
}
</style>