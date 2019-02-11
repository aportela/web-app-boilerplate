export const mixinErrors = {
    methods: {
        showApiError: function (error) {
            this.$router.push({ name: "apiError", params: { error: error } });
        }
    }
}
