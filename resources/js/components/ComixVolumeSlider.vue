<template>
    <div class="music-controls">
        <p class="font-lg">
            <i class="bi bi-music-note-beamed"></i>
            <i class="bi bi-pause-circle pointer" @click="pause" v-if="allowMusic"></i>
            <i class="bi bi-play-circle pointer" @click="play" v-if="!allowMusic"></i>
            <i @click="noMute" v-if="volume == 0 && !isMobile" class="bi bi-volume-mute-fill"></i>
            <i @click="mute" v-if="volume > 0 && !isMobile" class="bi bi-volume-up-fill pointer"></i>
            <input v-if="!isMobile" :value="volume" type="range" id="volume" name="volume" min="0" max="1" step="0.01" @input="updateVol" ref="slider">
        </p>
    </div>
</template>

<script>
export default{
    methods: {
        mute(){
            this.$store.commit('updateVolume', {volume: 0})
        },
        noMute(){
           this.$store.commit('updateVolume', {volume: .5}) 
        },
        updateVol(){
            this.$store.commit('updateVolume', {volume: this.$refs.slider.value})
        },
        pause(){
            this.$store.commit('allowMusicToggle', {status: false})
        },
        play(){
            this.$store.commit('allowMusicToggle', {status: true})
        }
    },
    computed: {
        volume(){
            return this.$store.state.volume
        },
        isIos(){
            return this.$store.state.isIos
        },
        allowMusic(){
            return this.$store.state.allowMusic
        },
        isMobile(){
            return this.$store.state.isMobile
        }
    },
    watch: {
        volume(){
            console.log('changing volume')
        },
        allowMusic(){
            console.log('Play/pause now')
        },
        watch: {
            isMobile(){
                console.log('mobile toggle')
            }
        }
    }
}
</script>
<style scoped>
    .pointer{
        cursor: pointer;
    }
    .music-controls p{
        margin-bottom: 0;
    }
    i{
        margin-right: 5px;
    }
</style>
