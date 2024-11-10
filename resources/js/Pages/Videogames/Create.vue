<script setup>
import Form from './Form.vue';

const props = defineProps({
    platforms: {
        type: Object,
    },
});

</script>
<template>
    <Form :platfroms="platforms"/>
</template>