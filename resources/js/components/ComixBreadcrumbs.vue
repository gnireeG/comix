<template>
    <div class="breadcrumbs">
        <router-link :to="{name: 'home'}"><i class="bi bi-house-door-fill home-icon"></i></router-link><p>
        <span v-for="(link, i) in links" :key="i"><i class="bi bi-chevron-compact-right filler"></i><span v-if="!link[1]" class="no-class">{{ link[0] }}</span><router-link v-if="link[1]" :to="link[1]">{{ link[0] }}</router-link></span>
        </p>
    </div>
</template>
<script>
export default{
    props:['links']
}
</script>
<style lang="scss" scoped>
    .breadcrumbs{
        display: inline-block;
        background: none;
        color: #f2f2f2;
        padding: 8px 15px;
        *{
            display: inline-block;
            vertical-align: top;
        }
        .home-icon{
            font-size: 2em;
            line-height: 0;
        }
        .filler{
            display: inline-block;
            margin: 0 8px;
        }
        p{
            margin-block-start: 0;
            margin-block-end: 0;
            margin-left: 7px;
            margin-top: 2px;
        }
    }
</style>