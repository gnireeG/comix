import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
window.Vue = Vue;
window.debounce = require('debounce')
require('./bootstrap');

Vue.use(Vuex);
Vue.use(VueRouter);

Vue.component('vue-container', require('./components/VueContainer.vue').default);
Vue.component('comix-wrapper', require('./components/pages/ComixWrapper.vue').default);
Vue.component('comix-overview', require('./components/pages/ComixOverview.vue').default);
Vue.component('comix-navbar', require('./components/ComixNavbar.vue').default);
Vue.component('comix-alert', require('./components/ComixAlert.vue').default);
Vue.component('comix-genre-overview', require('./components/ComixGenreOverview.vue').default);
Vue.component('comix-teaser', require('./components/ComixTeaser.vue').default);
Vue.component('comix-carousel', require('./components/ComixCarousel.vue').default);
Vue.component('comix-logo', require('./components/ComixLogo.vue').default);
Vue.component('comix-genre', require('./components/pages/ComixGenre.vue').default);
Vue.component('comix-breadcrumbs', require('./components/ComixBreadcrumbs.vue').default);
Vue.component('comix-loading-div', require('./components/ComixLoadingDiv.vue').default);
Vue.component('comix-reader', require('./components/pages/ComixReader.vue').default);
Vue.component('comix-music-player', require('./components/ComixMusicPlayer.vue').default);

// VUEX STORE
const store = new Vuex.Store({
    state: {
        alertShowError: false,
        isMobile: false,
        comicGenres: [],
        allComics: [],
        width: 0,
        searchVal: '',
        audioSource: '',
        volume: .5
    },
    mutations : {
        showAlert (state){
            state.alertShowError = true
        },
        hideAlert(state){
            state.alertShowError = false
        },
        deviceMobile(state){
            state.isMobile = true
        },
        deviceDesktop(state){
            state.isMobile = false
        },
        updateComicGenres(state, payload){
            state.comicGenres = payload.genres
        },
        updateComics(state, payload){
            state.allComics = payload.comics
        },
        updateWidth(state, payload){
            state.width = payload.width
        },
        updateSearchVal(state, payload){
            state.searchVal = payload.query
        },
        updateAudioSource(state, payload){
            state.audioSource = payload.audioSource
        },
        updateVolume(state, payload){
            state.volume = payload.volume
        }
    }
})

// ROUTER

const routes = [
    {name: 'home', path: '/', component: require('./components/pages/ComixOverview.vue').default},
    {name: 'search', path: '/search/:query', component: require('./components/pages/ComixSearch.vue').default},
    {name: 'genre', path: '/genre/:genre', component: require('./components/pages/ComixGenre.vue').default},
    {path: '/genre/', redirect: '/'},
    {name: 'comic', path: '/comic/:id/:title', component: require('./components/pages/ComixDetail.vue').default},
    {path: '/coimc', redirect: '/'},
    {name: 'reader', path: '/reader/:id/:title', component: require('./components/pages/ComixReader.vue').default},
    {name: '404', path: '/404', component: require('./components/pages/Comix404.vue').default},
    {path: '*', redirect: '/404'}
]
/*
<router-link to="/">Home</router-link>
<router-link to="/test/parameterjuhe" exact>Test</router-link>
*/
const router = new VueRouter({
    routes
})

const app = new Vue({
    el: '#app',
    store,
    router,
    created(){
        function calcIfMobile(){
            
            let width = viewport()
            store.commit('updateWidth', {width})
            if(width >= 991){
                store.commit('deviceDesktop')
            } else{
                store.commit('deviceMobile')
            }
        }
        function viewport() {
            var e = window, a = 'inner';
            if (!('innerWidth' in window )) {
                a = 'client';
                e = document.documentElement || document.body;
            }
            return e[ a+'Width' ];
        }
        calcIfMobile()
        window.addEventListener('resize', calcIfMobile)
    }
})