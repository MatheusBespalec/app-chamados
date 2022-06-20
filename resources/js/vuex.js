// Vuex
import { createStore } from 'vuex';
export default createStore({
    state: {
        menuOpen: true
    },
    getters: {
        menoOpen (state) {
            return state.menuOpen;
        }
    },
    mutations: {
        closeMenu(state) {
            state.menuOpen = false;
        },
        openMenu(state) {
            state.menuOpen = true;
        }
    },
    actions: {
        switchMenuState (context) {
            if (context.state.menuOpen) {
                context.commit('closeMenu')
            } else {
                context.commit('openMenu')
            }
        }
    }
})
