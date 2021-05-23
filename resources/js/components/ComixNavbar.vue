<template>
<div>
    <div class="comix-navbar-toggle">
        <button @click="toggleMobileNav" v-if="!mobileNavActive"><i class="bi bi-list"></i></button>
        <button class="comix-navbar-toggle-inverted" @click="toggleMobileNav" v-if="mobileNavActive"><i class="bi bi-x-circle"></i></button>
    </div>
    <div class="comix-navbar" :class="{'active' : mobileNavActive}">
        <div class="comix-navbar-nav" :class="{'d-flex justify-content-between flex-fill' : !isMobile}">
            <div class="logo-container">
                <router-link :to="{name: 'home'}"><comix-logo></comix-logo></router-link>
            </div>
            <div class="navbar-links">
                <router-link class="navbar-link" v-for="(category, index) in categories" :key="index"
                :to="{name: 'genre', params: {genre: category.title}}">{{ category.title }}</router-link>
            </div>
            <div class="navbar-search"><input type="text" name="search-input" id="search-input" placeholder="search"><button><i class="bi bi-search"></i></button></div>
        </div>
    </div>
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
    },
    data(){
        return {
            categories: [],
            mobileNavActive : false
        }
    },
    computed: {
        isMobile(){
            return this.$store.state.isMobile
        }
    },
    methods:{
        toggleMobileNav(){
            this.mobileNavActive = !this.mobileNavActive
        }
    },
    watch: {
        $route (to, from){
            this.mobileNavActive = false
        }
    }
  };
</script>