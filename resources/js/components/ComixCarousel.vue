<template>
    <div><!-- <button @click="test">test</button> -->
        <div class="container carousel-container">
            <div class="control prev">
                <button
                v-if="scrolls > 0"
                @click="moveCarousel('prev')"
                class="control-btn">
                    <i class="bi bi-chevron-compact-left"></i>
                </button>
            </div>
            <div class="control next">
                <button
                v-if="scrolls < comics.comics.length - getCarouselWidth('count')"
                @click="moveCarousel('next')"
                class="control-btn">
                    <i class="bi bi-chevron-compact-right"></i>
                </button>
            </div>
            <div class="carousel comix-carousel"
            :data-genre="comics.genre"
            :class="{'next-available': scrolls < comics.comics.length - getCarouselWidth('count'), 'prev-available': scrolls > 0}">
                <div class="content" :style="{width: getCarouselWidth() + 'px'}">
                    <comix-teaser class="comix-teaser" v-for="(comic, i) in comics.comics" :key="i" :comic="comic"></comix-teaser>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default{
    data(){
        return{
            scrolls: 0
        }
    },
    mounted(){
    },

    methods: {
        moveCarousel(dir){
            if(dir === 'prev'){
                this.scrolls -= this.getCarouselWidth('count')
                if(this.scrolls < 0){
                    this.scrolls = 0
                }
            } else if(dir === 'next'){
                this.scrolls += this.getCarouselWidth('count')
                if(this.scrolls >= this.comics.comics.length - this.getCarouselWidth('count')){
                    this.scrolls = this.comics.comics.length - this.getCarouselWidth('count')
                }
            }
            $('.comix-carousel[data-genre=' + this.comics.genre +'] .content').animate({
                marginLeft: this.scrolls * this.getCarouselWidth('one') * -1
            }, 500)
        },
        getCarouselWidth(useCase = 'all'){
            let width = this.$store.state.width
            let returnWidth
            let count
            if(width >= 1200){
                returnWidth = 1110/5
                count = 5
            } else if(width >= 992){
                returnWidth = 930/4
                count = 4
            } else if(width >= 768){
                returnWidth = 690/3
                count = 3
            } else if(width >= 576){
                returnWidth = 510/3
                count = 3
            } else{
                returnWidth = width/2
                count = 2
            }
            if(useCase == 'one'){
                return returnWidth
            } else if(useCase == 'all'){
                return returnWidth * this.comics.comics.length
            } else if(useCase == 'count'){
                return count
            }
        },
        test(){
            console.log(this.comics)
        }
    },
    computed: {
        clientWidth(){
            return this.$store.state.width
        }
    },
    props: [
        'comics'
    ]
}
</script>
<style lang="scss" scoped>
.carousel-container{
    position: relative;
}
.control{
    position: absolute;
    top: 0;
    z-index: 9999;
    height: 100%;
}
.prev{
    left: 0;
}
.next{
    right: 0;
}
button.control-btn{
    border: none;
    background: none;
    width: 60px;
    height: 100%;
    color: #f2f2f2;
    transform-origin: center;
    transition: all .08s ease-in-out;
    font-size: 3em;

}
button.control-btn:active{
    transform: scale(.85);
}

.container{
    padding: 0;
}
.carousel{
    width: 100%;
    overflow: hidden;
    .content{
        width: 9000px;

    }
    .comix-teaser{
        display: inline-block;
        text-align: center;
        vertical-align: top;
        height: 100%;
        
    }
}

.comix-carousel.next-available:after {
    content: "";
    position: absolute;
    z-index: 9998;
    bottom: 0;
    right: 0;
    pointer-events   : none;
    background-image : linear-gradient(to right, 
                    rgba(0,0,0, 0), 
                    rgba(0,0,0, .9) 95%);
    width: 60px;
    height: 100%;
}
.comix-carousel.prev-available:before {
    content: "";
    position: absolute;
    z-index: 9998;
    bottom: 0;
    left: 0;
    pointer-events   : none;
    background-image : linear-gradient(to left, 
                    rgba(0,0,0, 0), 
                    rgba(0,0,0, 0.8) 90%);
    width: 40px;
    height: 100%;
}

.comix-teaser{
    width: (100vw/2);
}
@media screen and (min-width: 576px){
    .comix-teaser{
        width: calc(510px/3);
    }
    .container{
        padding: 0 15px;
    }
}
@media screen and (min-width: 768px){
    .comix-teaser{
        width: calc(690px/3);
    }
}
@media screen and (min-width: 992px){
    .comix-teaser{
        width: calc(930px/4);
    }
}

@media screen and (min-width: 1200px){
    .comix-teaser{
        width: calc(1110px/5);
    }
}
</style>