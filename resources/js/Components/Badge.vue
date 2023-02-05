<script setup>

const props = defineProps({
    color: {
        type: String,
        default: 'primary'
    }
})

const type = {
    primary: 'badge bg-blue-600',
    secondary: 'badge bg-purple-600',
    success: 'badge bg-green-600',
    warning: 'badge bg-yellow-600',
    danger: 'badge bg-red-600',
    dark: 'badge bg-slate-600',
    orange: 'badge bg-orange-600',
}[props.color]

</script>

<template>
    <div :class="type">
        <slot></slot>
    </div>
</template>