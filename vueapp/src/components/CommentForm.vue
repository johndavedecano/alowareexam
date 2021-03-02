<template>
    <form @submit.prevent="submitForm">
        <div class="form-group mb-3">
            <label for="username">Username</label>
            <input
                text="text"
                v-model="username"
                class="form-control"
                :disabled="isLoading"
            />
        </div>
        <div class="form-group mb-3">
            <label for="body">Body</label>
            <textarea
                id="message"
                rows="5"
                v-model="body"
                class="form-control"
                :disabled="isLoading"
            ></textarea>
        </div>
        <div class="d-flex">
            <div class="flex-grow-1"></div>
            <button class="btn btn-primary" :disabled="isLoading">Post</button>
        </div>
    </form>
</template>

<script>
export default {
    name: "CommentForm",
    computed: {
        isLoading() {
            return this.$store.getters.isLoading;
        }
    },
    data() {
        return { body: "", username: "" };
    },
    props() {
        return { parent_id: null };
    },
    methods: {
        submitForm() {
            if (!this.username) {
                alert("Username is required");
                return;
            }

            if (!this.body) {
                alert("Body is required");
                return;
            }

            this.$store.dispatch("create", {
                body: this.body,
                username: this.username,
                parent_id: this.parent_id || null
            });

            this.body = "";
            this.username = "";
        }
    }
};
</script>
