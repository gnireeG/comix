<template>
    <div class="comix-teaser" :class="{'in-grid': inGrid}">
        <router-link :to="{name: 'comic', params: {id: comic.id, title: comic.title.replaceAll(' ', '-')}}">
            <img :src="comic.coverImage" :alt="comic.title">
        </router-link>
        <!-- <div class="info">
            <button><i class="bi bi-eye-fill"></i></button>
        </div> -->
    </div>   
</template>
<script>
export default {
    props: [
        'comic',
        'inGrid'
    ],
    methods: {
    },
    mounted(){
    }
}
</script>

<style lang="scss" scoped>
$transition: .3s ease-in-out;
.comix-teaser{
    width: 100%;
    position: relative;
    transition: transform $transition;
    img{
        width: 100%;
        transition: .2s ease-in-out;
    }
    a:hover{
        img{
            transform: scale(1.05);
        }
    }
    .info{
        height: 100%;
        width: 100%;
        background-color: #0c0c0c;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        transition: opacity $transition;
        color: #f2f2f2;
        font-size: 2em;
        button{
            border-radius: 50%;
            border: 2px solid #f2f2f2;
            background: none;
            width: 60px;
            height: 60px;
            color: #f2f2f2;
            transform-origin: center;
            transition: all .15s ease-in-out;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            i{
                display: block;
                margin-top: -6px;
            }
        }
        button:hover{
            background-color: #f2f2f2;
            color: #0c0c0c;
        }
    }
}
.comix-teaser.in-grid{
    
    .info{
        width: calc(100% - 30px);
        left: 15px;
    }
}
.comix-teaser:hover{
    z-index: 99;
    .info{
        opacity: .9;
    }
}
</style>