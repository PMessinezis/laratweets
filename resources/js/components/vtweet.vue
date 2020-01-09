<template>
    <div class="container wrapper">
        <div>
            <div class="logo-wrapper">
                <img :src="tweet.user.profile_image_url" />
            </div>
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
            <span v-if="hasUrls">
                <a :href="firstUrlTarget" target="_blank">{{ firstUrlDisplay }}</a>
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
        },

        hasUrls() {
            return this.tweet.entities.urls.length;
        },

        firstUrl() {
            return this.tweet.entities.urls[0];
        },

        firstUrlTarget() {
            return this.firstUrl.url;
        },

        firstUrlDisplay() {
            return this.firstUrl.display_url;
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

.wrapper:first-child {
    padding: 15px;
    margin: 0px 5px 0px 0px;
    border-radius: 15px;
    border: 1px solid gray;
}

.logo-wrapper {
    display: inline;
    width: 2em;
    height: 2em;
    position: relative;
    overflow: hidden;
    border-radius: 50%;
}

.logo-wrapper img {
    object-fit: cover;
    border-radius: 50%;
    height: 2em;
    width: 2em;
    overflow: hidden;
}
</style>