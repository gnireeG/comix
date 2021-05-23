<template>
  <div>
      <div class="container">
        <h1>TEST</h1>
        <h2>{{ title }}</h2>
        <div class="row">
          <div class="col-6">hallo</div>
          <div class="col-6">hallo</div>
        </div>
      </div>
  </div>
</template>
<script>
  export default {
    mounted() {
    },
    computed: {
      title(){
        return this.$route.params.title
      }
    }
  };
</script>