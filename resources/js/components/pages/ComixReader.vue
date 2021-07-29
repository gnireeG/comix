<template>
    <div>
        <div class="container">
            <div class="row image-row no-gutters" v-if="finishedLoadingComic && finishedLoadingImages && !isMobile">
                <div class="col-lg-1 comic-title"><h1>{{ comic.title }}</h1></div>
                <div class="col-lg-5 offset-lg-3" @mousedown="prevDef($event)" @contextmenu="prevDef($event)" v-show="currentPage == 0"><img :src="comic.coverImage"></div>
                <div class="col-lg-5 comic-image" @mousedown="prevDef($event)" @contextmenu="prevDef($event)" :data-index="index" v-show="currentPage > 0 && (currentPage * 2 == index +2 || currentPage * 2 == index +1)" v-for="(image, index) in comicImages" :key="index"><img :src="image.url" alt=""></div>
            </div>
            <div class="row image-row no-gutters mobile-reader" v-if="finishedLoadingComic && finishedLoadingImages && isMobile">
                <div class="col-lg-1 comic-title"><h1>{{ comic.title }}</h1></div>
                <div class="col-lg-5 offset-lg-3" @mousedown="prevDef($event)" @contextmenu="prevDef($event)" v-show="currentPage == 0"><img :src="comic.coverImage"></div>
                <div class="col-lg-5 comic-image" @mousedown="prevDef($event)" @contextmenu="prevDef($event)" :data-index="index" v-show="currentPage > 0 && currentPage == index +1" v-for="(image, index) in comicImages" :key="index"><img :src="image.url" alt=""></div>
            </div>
            <div class="row mt-3" v-if="finishedLoadingComic && finishedLoadingImages">
                <div class="offset-lg-1 col-lg-2 col-sm-3 col-6 order-sm-1 order-1"><a class="button-primary font-brand font-lg" v-show="currentPage > 0" @click="previousPage">Previous</a></div>
                <div class="text-align-center col-lg-6 col-sm-6 col-12 order-sm-2 order-3">
                    <span class="font-brand page-nr d-xl-flex justify-content-center">
                        <span class="font-lg" v-show="currentPage > 0 && !isMobile">Page {{ currentPage }} / {{ comicImages.length / 2 }}<span v-show="currentPage > 0" class="d-none d-xl-inline">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span>
                        <span v-show="currentPage > 0 && isMobile">Page {{ currentPage }} / {{ comicImages.length}}</span>
                        
                        <comix-volume-slider></comix-volume-slider>
                    </span>
                    <!-- <input class="page-nr-input" type="number" :max="comicImages.length / 2" min="1" v-model="currentPage"> -->
                </div>
                <div class="col-lg-2 col-sm-3 col-6 order-sm-3 order-2 text-align-right" v-show="currentPage < comicImages.length / 2 && !isMobile"><a class="button-primary font-brand font-lg" @click="nextPage">Next</a></div>
                <div class="col-lg-2 col-sm-3 col-6 order-sm-3 order-2 text-align-right" v-show="currentPage < comicImages.length && isMobile"><a class="button-primary font-brand font-lg" @click="nextPage">Next</a></div>
            </div>
            <div v-if="!imagesFound">
                <h2>:(</h2>
                <p>Sadly this is just a placeholder. If you want to experience our comics, <a href="/#/comic/1/Down-in-the-2nd-round">check this out</a>!<br>More will follow in the near future, stay tuned.</p>
            </div>
            <audio ref="pageturn">
                <source src="/audio/pageturn.mp3" type="audio/mp3">
            </audio>
        </div>
    </div>
</template>

<script>
export default{
    mounted(){
        axios.get(`/getComicById/${this.$route.params.id}`)
            .then((res) =>{
                if(res.data.length == 0){
                    this.$router.push({path: '/404'})
                }
                this.comic = res.data[0]
                this.finishedLoadingComic = true
            })
            .catch((error) =>{
                this.$store.commit('showAlert')
            })

        axios.get(`/getImagesByComicId/${this.$route.params.id}`)
            .then((res) =>{
                if(res.data.length == 0){
                    this.imagesFound = false
                } else{
                    this.comicImages = res.data
                    this.finishedLoadingImages = true
                }
                
            })
            .catch((error) =>{
                this.$store.commit('showAlert')
            })
        
        axios.get(`/getAudioByComicId/${this.$route.params.id}`)
            .then((res) =>{
                if(res.data.length > 0){
                    this.audio = res.data
                    this.audio.forEach(track =>{
                    if(this.currentPage === track.page){
                        this.$store.commit('updateAudioSource', {audioSource: track.url})
                    }
                })
                }
            })
            .catch((error) =>{
                this.$store.commit('showAlert')
            })
        this.$refs.pageturn.volume = this.volume / 2
        
    },
    data(){
        return{
            comic: null,
            comicImages: null,
            imagesFound: true,
            finishedLoadingComic: false,
            finishedLoadingImages: false,
            currentPage: 0,
            audio: [],
            volume: this.$store.state.volume
        }
    },
    watch: {
        volume(){
            this.$store.commit('updateVolume', {volume: this.volume})
            this.$refs.pageturn.volume = this.volume / 2
        },
        isMobile(){
            if(this.isMobile){
                this.currentPage = this.currentPage * 2
            } else if(!this.isMobile){
                this.currentPage = Math.ceil(this.currentPage / 2)
            }
        }
    },
    methods: {
        mute(){
            this.$store.commit('updateVolume', {volume: 0})
            this.volume = 0
        },
        previousPage(){
            if(this.currentPage > 0){
                this.currentPage--
                this.$refs.pageturn.play()
                this.audio.forEach(track =>{
                    if(this.currentPage === track.page){
                        this.$store.commit('updateAudioSource', {audioSource: track.url})
                    }
                })
            }
        },
        nextPage(){
            if(!this.isMobile){
                if(this.currentPage < this.comicImages.length / 2){
                    this.currentPage++
                    this.$refs.pageturn.play()
                    this.audio.forEach(track =>{
                        if(this.currentPage === track.page){
                            this.$store.commit('updateAudioSource', {audioSource: track.url})
                        }
                    })
                }
            } else if(this.isMobile){
                if(this.currentPage < this.comicImages.length){
                    this.currentPage++
                    this.$refs.pageturn.play()
                    this.audio.forEach(track =>{
                        if(this.currentPage === track.page){
                            this.$store.commit('updateAudioSource', {audioSource: track.url})
                        }
                    })
                }
            }
            
        },
        prevDef(e){
            e.preventDefault()
        }
    },
    computed: {
        isMobile(){
            return this.$store.state.isMobile
        }
    }
}
</script>
<style lang="scss" scoped>
.page-nr-input{
    margin-left: 10px;
}
.page-nr{
    display: inline-block;
    margin-top: 12px;
}
.image-row{
    
    .comic-title{
        h1{
            writing-mode: tb-rl;
            transform: rotate(-180deg);
            color: white;
        }
        
    }
    img{
        width: 100%;
        user-select: none;
    }
    &.mobile-reader{
        .comic-title{
            h1{
                writing-mode: initial;
                transform: none;
            }
        }
    } 
}

</style>