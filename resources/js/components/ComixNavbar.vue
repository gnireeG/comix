<template>
<div class="navbar-container">
    <div class="comix-navbar-toggle">
        <button @click="toggleMobileNav" v-if="!mobileNavActive"><i class="bi bi-list"></i></button>
        <button class="comix-navbar-toggle-inverted" @click="toggleMobileNav" v-if="mobileNavActive"><i class="bi bi-x-circle"></i></button>
    </div>
    <div class="comix-navbar" :class="{'active' : mobileNavActive, 'genres-expanded' : genresExpanded}">
        <div :class="{'container' : !isMobile}">
            <div class="comix-navbar-nav" :class="{'d-flex justify-content-between flex-fill align-items-baseline' : !isMobile}">
                <div class="d-flex">
                    <div class="logo-container">
                        <router-link :to="{name: 'home'}"><comix-logo></comix-logo></router-link>
                    </div>
                    <div class="navbar-links">
                        <p @click="toggleGenres" class="navbar-link genre-btn">Genres</p>
                        <p class="navbar-link">Beliebt</p>
                        <p class="navbar-link">Neuheiten</p>

                    </div>
                </div>
                <div class="navbar-search">
                    <input type="text" name="search-input" id="search-input" placeholder="suchen" @input="searchComix" v-model="searchval">
                    <button @click="searchComix"><i class="bi bi-search search-icon"></i></button>
                </div>
            </div>
        </div>
    </div>
    <transition name="genre">
        <div class="genre-toggle" v-if="genresExpanded">
            <div class="container genre-toggle-container">
                <router-link class="navbar-link genre-btn" v-for="(category, index) in categories" :key="index"
                :to="{name: 'genre', params: {genre: category.title}}">{{ category.title }}</router-link>
            </div>
        </div>
    </transition>
</div>
</template>
<script>
  export default {
    mounted() {
        axios.get('/getGenres')
            .then((data) =>{
                this.categories = data.data
            }).catch((error) =>{
                this.$store.commit('showAlert')
            })
        document.addEventListener('click', (e) =>{
            if(!e.target.classList.contains('genre-toggle-container') && !e.target.classList.contains('genre-btn')){
                this.genresExpanded = false
            }
        })
        if(this.$route.name === 'search'){
            this.searchval = this.$route.params.query
            this.$store.commit('updateSearchVal', {query: this.searchval})
        }
    },
    data(){
        return {
            categories: [],
            mobileNavActive : false,
            genresExpanded: false,
            searchval: ''
        }
    },
    computed: {
        isMobile(){
            return this.$store.state.isMobile
        }
    },
    methods:{
        searchComix:debounce(function(){
            if(this.searchval.length > 2){
                this.$store.commit('updateSearchVal', {query: this.searchval})
            }
            if(this.$route.name == 'search'){
                if(this.$route.params.query !== this.searchval){
                    this.$router.push({name: 'search', params: {query: this.searchval}})
                }
            } else{
                if(this.searchval.length > 2){
                    this.$router.push({name: 'search', params: {query: this.searchval}})
                }
            }
            
        },800),
        searchComixBtn(){
            this.$store.commit('updateSearchVal', {query: ''})
            this.$store.commit('updateSearchVal', {query: this.searchval})
            if(this.searchval.length > 2){
                this.$router.push({name: 'search', params: {query: this.searchval}})
            }
        },
        toggleMobileNav(){
            this.mobileNavActive = !this.mobileNavActive
        },
        toggleGenres(){
            this.genresExpanded = !this.genresExpanded
        }
    },
    watch: {
        $route (to, from){
            this.mobileNavActive = false
        }
    }
  };
</script>
<style scoped>
.genre-enter-active, .genre-leave-active {
  transition: opacity .35s;
}
.genre-enter, .genre-leave-to{
  opacity: 0;
}
</style>