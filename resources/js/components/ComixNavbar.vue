<template>
<div class="navbar-container">
    <div class="comix-navbar-toggle">
        <div class="container">
            <router-link v-if="isMobile" :to="{name: 'home'}"  class="mobile-comix-logo"><comix-logo></comix-logo></router-link>
            <div class="mobile-nav-buttons">
                <button v-if="isMobile" @click="toggleMobileSearch"><i class="bi bi-search search-icon mobile-search-icon"></i></button>
                <button @click="toggleMobileNav" v-if="!mobileNavActive"><i class="bi bi-list"></i></button>
                <button class="comix-navbar-toggle-inverted" @click="toggleMobileNav" v-if="mobileNavActive"><i class="bi bi-x-circle"></i></button>
            </div>
        </div>
        <!-- MOBILE MENU -->
        <div class="container mt-3" v-if="mobileNavActive && isMobile">
            <div class="mobile-nav-links">
                <p @click="toggleMobileGenres" class="navbar-link genre-btn">Genres</p>
                <div class="mobile-genre-container" v-show="mobileGenresExpanded">
                    <router-link class="navbar-link genre-btn" v-for="(category, index) in categories" :key="index"
                    :to="{name: 'genre', params: {genre: category.title}}">{{ category.title }}</router-link>
                </div>
                <p class="navbar-link">Trending</p>
                <p class="navbar-link">New</p>
            </div>
            
        </div>
        <div class="navbar-search" v-show="mobileSearchActive">
            <div class="container"><input type="text" name="search-input" id="search-input" placeholder="search" @input="searchComix" v-model="searchval"></div>
        </div>
    </div>
    <!-- DESKTOP MENU -->
    <div v-if="!isMobile" class="comix-navbar" :class="{'genres-expanded' : genresExpanded}">
        <div class="container">
            <div class="comix-navbar-nav d-flex justify-content-between flex-fill align-items-baseline">
                <div class="d-flex">
                    <div class="logo-container">
                        <router-link :to="{name: 'home'}"><comix-logo></comix-logo></router-link>
                    </div>
                    <div class="navbar-links">
                        <p @click="toggleGenres" class="navbar-link genre-btn">Genres</p>
                        <p class="navbar-link">Trending</p>
                        <p class="navbar-link">New</p>

                    </div>
                </div>
                <div class="navbar-search">
                    <input type="text" name="search-input" id="search-input" placeholder="search" @input="searchComix" v-model="searchval">
                    <button @click="searchComix"><i class="bi bi-search search-icon"></i></button>
                </div>
            </div>
        </div>
    </div>
    <transition v-if="!isMobile" name="genre">
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
            mobileSearchActive: false,
            genresExpanded: false,
            mobileGenresExpanded: false,
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
        },
        toggleMobileGenres(){
            this.mobileGenresExpanded = !this.mobileGenresExpanded
        },
        toggleMobileSearch(){
            this.mobileSearchActive = !this.mobileSearchActive
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
.mobile-search-icon{
    font-size: .8em;
}
</style>