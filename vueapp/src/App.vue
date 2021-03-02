<template>
    <div class="container py-4">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card">
                    <div class="card-header">Comments Section</div>
                    <div class="card-body">
                        <CommentForm :parent_id="parent_id" />
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
import CommentForm from "./components/CommentForm.vue";

export default {
    name: "App",
    components: {
        CommentForm
    },
    data() {
        return {
            parent_id: null
        };
    },
    mounted() {
        this.$store.dispatch("load");
    },
    methods: {
        reply(comment) {
            console.log(comment);
            const textarea = document.getElementById("message");

            textarea.value = "@" + comment.username + " ";
            textarea.focus();

            this.parent_id = comment.id;
        },
        dateFormat(date) {
            return moment(date).fromNow();
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
