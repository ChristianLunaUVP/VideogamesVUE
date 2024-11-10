<script setup>
import Form from './Form.vue';

const props = defineProps({
    platforms: {
        type: Object,
    },
    videogame: {
        type: Object,
    },
    platformsofvideogame: {
        type: Object,
    },
});

</script>
<template>
    <Form :platforms="platforms" :videogame="videogame" 
    :platformsofvideogame="platformsofvideogame" />
</template>