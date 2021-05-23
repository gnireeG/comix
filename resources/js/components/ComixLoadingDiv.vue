<template>
    <div class="bg"></div>
</template>
<style lang="scss" scoped>

.bg {
    background: linear-gradient(270deg, #313131, #222222);
    background-size: 400% 400%;
    animation: bganim 3s ease infinite;
    border-radius: 5px;
}

@keyframes bganim {
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
}

</style>