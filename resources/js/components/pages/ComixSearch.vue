<template>
  <div>
      <div class="mt-5 container">
          <p class="m5-3">Search results for:</p>
          <h1>{{searchValue}}</h1>
          <div class="row">
            <comix-teaser class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4" v-for="(comic, i) in foundComix" :key="i" :comic="comic" :inGrid="true"></comix-teaser>
        </div>
      </div>
  </div>
</template>

<script>
export default{
    mounted(){
        if(this.$store.state.searchVal.length > 2){
            axios.get(`/searchEverything/${this.searchValue}`)
                .then(data =>{
                    this.foundComix = data.data
                })
                .catch((error) =>{
                    this.$store.commit('showAlert')
                })
        }

    },
    data(){
        return{
            foundComix: []
        }
    },
    computed:{
        searchValue(){
            return this.$store.state.searchVal
        }
    },
    watch: {
        searchValue(){
            
            //console.log('searching now...')
            axios.get(`/searchEverything/${this.searchValue}`)
                .then(data =>{
                    this.foundComix = data.data
                })
                .catch((error) =>{
                    this.$store.commit('showAlert')
                })
        }
    }
}
</script>