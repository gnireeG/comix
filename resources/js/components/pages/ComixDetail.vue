<template>
    <div class="container mt-3 comix-detail">
        <div v-if="finishedLoading">
            <comix-breadcrumbs :links="[[comic.genre.title, '/genre/' + comic.genre.title], [comic.title, false]]"></comix-breadcrumbs>
            <div class="row mt-5 d-none d-sm-flex">
                <div class="col-xl-4 col-lg-5 col-md-5 col-sm-4">
                    <img :src="comic.coverImage" :alt="comic.title">
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-8">
                    <h1>{{ comic.title }}</h1>
                    <p>{{ comic.description }}</p>
                    <p class="author"><span class="author-icon"><i class="bi bi-person-fill"></i></span><span class="author-info">{{ comic.author }}, {{ comic.year }}</span></p>
                    <p class="link-to-watch"><a href="#"></a></p>
                </div>
            </div>
            <div class="d-block d-sm-none mt-5">
                <div class="row">
                    <div class="col-4">
                        <img :src="comic.coverImage" :alt="comic.title">
                    </div>
                    <div class="col-8 d-flex align-items-center">
                        <h2 class="mobile-title">{{ comic.title }}</h2>
                    </div>
                </div>
                <div class="mt-3">
                    <p>{{ comic.description }}</p>
                    <p class="author"><span class="author-icon"><i class="bi bi-person-fill"></i></span><span class="author-info">{{ comic.author }}, {{ comic.year }}</span></p>
                    <p class="link-to-watch"><a href="#"></a></p>

                </div>
            </div>
        </div>
        <div v-if="!finishedLoading" class="loading">
            <comix-loading-div class="breadcrumbs"></comix-loading-div>
            <div class="row mt-5 d-none d-sm-block">
                <div class="col-xl-4 col-lg-5 col-md-5 col-sm-4 col-3">
                    <comix-loading-div class="image"></comix-loading-div>
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-8 col-9">
                    <comix-loading-div class="title"></comix-loading-div>
                    <comix-loading-div class="text"></comix-loading-div>
                    <comix-loading-div class="text"></comix-loading-div>
                    <comix-loading-div class="text"></comix-loading-div>
                    <comix-loading-div class="author"></comix-loading-div>
                </div>
            </div>
        </div>
        
    </div>
    
</template>
<script>
export default{
    mounted(){
        axios.get('/getComicById/' + this.$route.params.id)
            .then((res) =>{
                if(res.data.length == 0){
                    this.$router.push({path: '/404'})
                }
                this.comic = res.data[0]
                this.finishedLoading = true
            })
            .catch((error) =>{
                this.$store.commit('showAlert')
            })
    },
    data(){
        return{
            comic: null,
            finishedLoading: false,
            comicNotFound: false
        }
        
    }
}
</script>


<style lang="scss" scoped>
.loading{    
    .breadcrumbs{
        display: inline-block;
        width: 30%;
        height: 44px;
    }
    .image{
        width: 100%;
        height: 400px;
    }
    .title{
        display: inline-block;
        width: 50%;
        height: 50px;
        margin-bottom: 20px;
    }
    .text{
        height: 30px;
        margin-bottom: 10px;
    }
    .author{
        display: inline-block;
        height: 30px;
        width: 30%;
    }
}
@keyframes loadingbg{
    0%{
        background-position: 0% 50%;
    }
    50%{
        background-position: 100% 50%;
    }
    100%{
        background-position: 0% 50%;
    }
}
.comix-detail{
    img{
        width: 100%;
        box-shadow: 2px 2px 15px 5px rgba(0,0,0,.7);
    }
    p{
        max-width: 500px;
    }
    .author{
        span{
            display: inline-block;
            vertical-align: middle;
        }
        .author-icon{
            font-size: 2em;
            margin-right: 10px;
            line-height: 0;
        }
    }
    .mobile-title{
        margin-bottom: 0;
    }
}
</style>