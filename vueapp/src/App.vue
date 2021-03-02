<template>
    <div class="container py-4">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card">
                    <div class="card-header">Comments Section</div>
                    <div class="card-body">
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
                                    ref="message"
                                    rows="5"
                                    v-model="body"
                                    class="form-control"
                                    :disabled="isLoading"
                                ></textarea>
                            </div>
                            <div class="d-flex">
                                <div class="flex-grow-1"></div>
                                <button
                                    class="btn btn-primary"
                                    :disabled="isLoading"
                                >
                                    Post
                                </button>
                            </div>
                        </form>
                        <div class="py-4">
                            <div
                                class="card mb-3"
                                v-for="comment in comments"
                                :key="comment.id"
                            >
                                <div class="card-body">
                                    <div class="fw-bold">
                                        {{ comment.username }}
                                        <span class="text-muted small">
                                            {{ dateFormat(comment.created_at) }}
                                        </span>
                                    </div>
                                    <div class="text-body">
                                        {{ comment.body }}
                                        <div
                                            class="card mb-3"
                                            v-for="subcomment in comment.comments"
                                            :key="subcomment.id"
                                        >
                                            <div class="card-body">
                                                {{ subcomment.body }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-grow-1"></div>
                                        <a href="#" @click="reply(comment)"
                                            >Reply</a
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: "App",
    data() {
        return {
            parent_id: null,
            username: "",
            body: ""
        };
    },
    mounted() {
        this.$store.dispatch("load");
    },
    methods: {
        reply(comment) {
            this.body = "@" + comment.username + " ";

            this.$refs.message.focus();

            this.parent_id = comment.id;
        },
        dateFormat(date) {
            return moment(date).fromNow();
        },
        submitForm() {
            this.$store.dispatch("create", {
                parent_id: this.parent_id,
                username: this.username,
                body: this.body
            });
            this.parent_id = null;
            this.username = "";
            this.body = "";
        }
    },
    computed: {
        isLoading() {
            return this.$store.getters.isLoading;
        },
        comments() {
            return this.$store.getters.comments;
        }
    }
};
</script>
