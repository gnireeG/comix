<template>
    <div>
        <div class="container mt-5">
            <router-link class="d-inline-block"
            :to="{name: 'genre', params: {genre: comics.genre}}"><h2 >{{ comics.genre }}</h2></router-link>
        </div>
        <comix-carousel :comics="comics" ></comix-carousel>        
    </div>
</template>
<script>

export default{
    mounted(){
    },
    data(){
        return{

        }
    },
    props: [
        'comics'
    ]
}
</script>
