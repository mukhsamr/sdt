<script setup>

defineProps({
    icon: Function,
})

</script>

<template>
    <div class="flex align-middle clickable">
        <component class="w-5 h-5 mr-2" :is="icon"></component>
        <span>
            <slot />
        </span>
    </div>
</template>