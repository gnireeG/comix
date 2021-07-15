<template>
    <div>
        <div class="splash" v-if="showSplash">
            <router-link v-on:click.native="hideSplash" :to="{name: 'genre', params: {genre: 'Comedy'}}" class="splash-genre" style="background-image: url('img/splash/comedy.jpg');">
                <h2>Comedy</h2>
            </router-link>
            <router-link v-on:click.native="hideSplash" :to="{name: 'genre', params: {genre: 'Action'}}" class="splash-genre" style="background-image: url('img/splash/action.jpg');">
                <h2>Action</h2>
            </router-link>
            <router-link v-on:click.native="hideSplash" :to="{name: 'genre', params: {genre: 'Horror'}}" class="splash-genre" style="background-image: url('img/splash/horror.jpg');">
                <h2>Horror</h2>
            </router-link>
            <router-link v-on:click.native="hideSplash" :to="{name: 'genre', params: {genre: 'Thriller'}}" class="splash-genre" style="background-image: url('img/splash/manga.jpg');">
                <h2>Thriller</h2>
            </router-link>
            <div class="splash-home">
                <h1 @click="hideSplash"><comix-logo></comix-logo></h1>
            </div>
        </div>
        <slot v-if="!showSplash"></slot>
    </div>
</template>
<style lang="scss">
.splash{
    width: 100vw;
    height: 100vh;
    background-color: black;
    display: flex;
    overflow: hidden;
    position: relative;
    .splash-home{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
        h1{
            font-size: 2em;
            margin-block-end: 0;
            margin-block-start: 0;
            cursor: pointer;
        }
    }
    a{
        h2::after{
            content: "";
        }
    }
    .splash-genre{
        width: 25%;
        height: 100%;
        display: flex;
        align-items: flex-end;
        background-size: auto 100%;
        background-position: center;
        transition: background-size .3s ease-in-out;
        h2{
            color: white;
            text-align: center;
            width: 100%;
            margin-bottom: 3rem;
        }
    }
    .splash-genre:hover{
        background-size: auto 103%;
    }
}
</style>
<script>
export default{
    data(){
        return{
            showSplash: false
        }
    },
    methods: {
        hideSplash(){
            this.showSplash = false
        }
    },
    computed:{
        getRoute(){
        }
    },
    mounted(){
        if(this.$route.name === 'home' && !this.$store.state.isMobile){
            this.showSplash = true
        }
    }
}
</script>