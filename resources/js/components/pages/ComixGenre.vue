<template>
<div class="mt-5">
    <div class="container" v-if="!loading" :key="genre">
        <!-- <comix-breadcrumbs :links="[['Genre', false],[genre, false]]"></comix-breadcrumbs> -->
        <h1>{{ genre }}</h1>
        <div class="row">
            <comix-teaser class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4" v-for="(comic, i) in comics" :key="i" :comic="comic" :inGrid="true"></comix-teaser>
        </div>
    </div>
    <div class="container mt-5 loading" v-if="loading">
        <comix-loading-div class="title mt-5"></comix-loading-div>
        <div class="row mt-5">
            <div class="loading-teaser col-lg-3 col-md-4 col-sm-6 col-6 mb-4"><comix-loading-div></comix-loading-div></div>
            <div class="loading-teaser col-lg-3 col-md-4 col-sm-6 col-6 mb-4"><comix-loading-div></comix-loading-div></div>
            <div class="loading-teaser col-lg-3 col-md-4 col-sm-6 col-6 mb-4"><comix-loading-div></comix-loading-div></div>
            <div class="loading-teaser col-lg-3 col-md-4 col-sm-6 col-6 mb-4"><comix-loading-div></comix-loading-div></div>
            <div class="loading-teaser col-lg-3 col-md-4 col-sm-6 col-6 mb-4"><comix-loading-div></comix-loading-div></div>
            <div class="loading-teaser col-lg-3 col-md-4 col-sm-6 col-6 mb-4"><comix-loading-div></comix-loading-div></div>
            <div class="loading-teaser col-lg-3 col-md-4 col-sm-6 col-6 mb-4"><comix-loading-div></comix-loading-div></div>
            <div class="loading-teaser col-lg-3 col-md-4 col-sm-6 col-6 mb-4"><comix-loading-div></comix-loading-div></div>
        </div>
    </div>
    
</div>
    
</template>
<style lang="scss" scoped>
    .loading{
        .title{
            display: inline-block;
            width: 25%;
            height: 50px;
        }
        .title.breadcrumbs{
            width: 35%;
        }
        .loading-teaser{
            width: 100%;
            height: 200px;
        }
        .loading-teaser>div{
            height: 100%;
        }

    }
</style>
<script>
export default{
    mounted(){
        this.loadComics(this.genre)
    },
    methods:{
        loadComics (pGenre){
            axios.get('/getGenreWithComics/' + pGenre)
            .then((data)=>{
                if(data.data.length == 0){
                    this.$router.push({path: '/404'})
                } else{
                    this.loading = false
                    this.comics = data.data[0].comics
                }
            })
            .catch((error) =>{
                this.$store.commit('showAlert')
            })
        }
    },
    data(){
        return{
            genre: this.$route.params.genre,
            comics: null,
            loading: true
        }
    },
    watch: {
        $route(to){
            this.loading = true
            this.genre = to.params.genre
            this.loadComics(this.genre)
        }
    }
}
</script>