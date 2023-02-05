<script setup>

const props = defineProps({
    color: {
        type: String,
        default: 'primary'
    },
})

const type = {
    primary: 'btn bg-blue-500 enabled:bg-blue-600 text-white enabled:hover:bg-blue-700 focus:bg-blue-700 enabled:active:bg-blue-800',
    success: 'btn bg-green-500 enabled:bg-green-600 text-white enabled:hover:bg-green-700 focus:bg-green-700 enabled:active:bg-green-800',
    danger: 'btn bg-red-500 enabled:bg-red-600 text-white enabled:hover:bg-red-700 focus:bg-red-700 enabled:active:bg-red-800',
    secondary: 'btn bg-purple-500 enabled:bg-purple-600 text-white enabled:hover:bg-purple-700 focus:bg-purple-700 enabled:active:bg-purple-800',
    warning: 'btn bg-yellow-500 enabled:bg-yellow-600 text-white enabled:hover:bg-yellow-700 focus:bg-yellow-700 enabled:active:bg-yellow-800',
    dark: 'btn bg-slate-500 enabled:bg-slate-600 text-white enabled:hover:bg-slate-700 focus:bg-slate-700 enabled:active:bg-slate-800',
}[props.color]

</script>

<template>
    <button type="button" :class="type">
        <slot />
    </button>
</template>