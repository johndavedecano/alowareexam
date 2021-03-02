import { createStore } from "vuex";

import axios from "axios";

axios.defaults.baseURL = "http://localhost:8000/api";

export default createStore({
    state: {
        isLoading: false,
        comments: []
    },
    mutations: {
        loading(state, isLoading) {
            state.isLoading = isLoading;
        },
        loaded(state, comments) {
            state.comments = comments;
        }
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        comments(state) {
            return state.comments;
        }
    },
    actions: {
        create(context, params) {
            context.commit("loading", true);

            axios.post("comments", params).finally(() => {
                context.commit("loading", false);
                context.dispatch("load");
            });
        },
        load(context, params) {
            context.commit("loading", true);
            axios
                .get("comments", { params })
                .then(response => response.data)
                .then(response => response.data)
                .then(response => context.commit("loaded", response))
                .finally(() => {
                    context.commit("loading", false);
                });
        }
    }
});
