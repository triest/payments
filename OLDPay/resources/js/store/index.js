import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        settings:[],
    },
    getters: {
        get_settings(state){
            return state.settings;
        },
    },
    mutations: {
        settings(state,data) {
            return state.settings = data
        },
        set_settings(state, {key, value}) {
        //    return state.settings = data
            Vue.set(state.settings, key, value);
        }
    },
    actions: {
        GET_SETTINGS(context){
            axios.get("/api/settings")
                .then((response)=>{
                    context.commit("settings",response.data.settings) //categories will be run from mutation
                })
                .catch(()=>{
                    console.log("Error........")
                })
        },


        SAVE_SETTINGS ({commit},key, value) {
            console.log(key)
            let response = axios.post('/api/settings', key);
            commit('set_settings', {key,value});
            return response.data;
        },
    },
});
