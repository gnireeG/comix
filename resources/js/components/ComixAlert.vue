<template>
  <div>
    <transition name="fade">
      <div class="alert-container" v-if="hasError">
          <span>Something went wrong. Please try again later</span>
          <button class="alert-close" @click="removeError"><i class="bi bi-x-circle"></i></button>
      </div>
    </transition>
  </div>
</template>
<script>
  export default {
    mounted() {
        console.log('Alert loaded.')
    },
    data(){
      return{
        
      }
    },
    computed: {
      hasError(){
        return this.$store.state.alertShowError
      }
    },
    methods: {
      removeError(){
        this.$store.commit('hideAlert');
      }
    }
  };
</script>
<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to{
  opacity: 0;
}
</style>