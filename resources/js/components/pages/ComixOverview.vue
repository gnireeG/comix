<template>
  <div>
      <div class="mt-5" v-if="!loadingComics && !loadingGenres">
          <comix-genre-overview v-for="(genre, i) in comicGenres" :key="i" :comics="{comics: comicByGenres(genre.id), genre: genre.title}"></comix-genre-overview>
      </div>
      <div class="mt-5 loading" v-if="loadingComics || loadingGenres">
        <div class="container">
          <comix-loading-div class="title"></comix-loading-div>
          <comix-loading-div class="comix-slider"></comix-loading-div>
          <comix-loading-div class="title mt-5"></comix-loading-div>
          <comix-loading-div class="comix-slider"></comix-loading-div>
        </div>
      </div>
  </div>
</template>
<script>

  export default {
    mounted(){
      axios.get('/getGenres')
        .then((data) =>{
          if(data.data.length == 0){
            this.$store.commit('showAlert')
          } else{
            this.$store.commit('updateComicGenres', {genres: data.data})
            this.loadingGenres = false 
          }
                   
        })
        .catch((error) =>{
          this.$store.commit('showAlert')
        })
        axios.get('/getComics')
          .then((data) =>{
            if(data.data.length == 0){
              this.$store.commit('showAlert')
            } else{
            this.$store.commit('updateComics', {comics: data.data})
            this.loadingComics = false
            }

          })
          .catch((error) =>{
            this.$store.commit('showAlert')
          })
    },
    methods: {
      comicByGenres(catId){
        let arr = []
        this.$store.state.allComics.forEach(elem =>{
          if(elem.genre_id == catId){
            arr.push(elem)
          }
        })
        return arr
      }
    },
    computed: {
      comicGenres(){
        return this.$store.state.comicGenres
      }
    },
    data(){
      return{
        loadingGenres: true,
        loadingComics: true
      }
    }
  };
</script>
<style lang="scss" scoped>
  .loading{
    .title{
      display: inline-block;
      width: 25%;
      height: 30px;
      margin-bottom: 20px;
    }
    .comix-slider{
      width: 100%;
      height: 260px;
    }
  }
</style>