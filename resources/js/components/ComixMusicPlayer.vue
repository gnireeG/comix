<template>
    <div>
        <audio autoplay loop ref="player">
            <source :src="audioSource" type="audio/mp3">
        </audio>
    </div>
    
</template>
<script>
export default{
    mounted(){
        this.$refs.player.volume = this.volume
    },
    computed: {
        audioSource(){
            return this.$store.state.audioSource
        },
        volume(){
            return this.$store.state.volume
        },
        musicAllowed(){
            return this.$store.state.allowMusic
        }
    },
    watch: {
        audioSource(){
            if(this.audioSource !== null && this.$store.state.allowMusic){
                this.$refs.player.load()
                this.$refs.player.play()
            }
            
        },
        volume(){
            this.$refs.player.volume = this.volume
        },
        $route (to, from){
            if(to.name !== 'reader' && to.name !== 'comic'){
                this.$refs.player.pause()
                this.$store.commit('updateAudioSource', {audioSource: null})
            }
        },
        musicAllowed(){
            if(this.$store.state.allowMusic){
                this.$refs.player.load()
                this.$refs.player.play()
            } else{
                this.$refs.player.pause()
            }
        }
    }
}
</script>
