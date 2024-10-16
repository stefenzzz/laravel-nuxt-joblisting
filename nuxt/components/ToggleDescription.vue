<script setup>
defineProps({
    length:[Number, String],
    limit: [Number, String],
})

const emits = defineEmits(['onToggle']);
</script>


<template>
        <span v-if="length === limit">
                ...
                <p @click="emits('onToggle')" class="text-green-500 hover:text-green-600 cursor-pointer mb-2">More</p>
        </span>
        <span v-else-if="length > limit" >
                <p @click="emits('onToggle')" class="text-green-500 hover:text-green-600 cursor-pointer mb-2">Less</p>
        </span>
</template>