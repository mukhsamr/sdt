<script setup>
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    href: {
        type: String,
        default: '/'
    },
    icon: Function,
    isActive: Boolean
})

</script>

<template>
    <Link
        class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out"
        :class="{ 'text-blue-600 bg-blue-100': isActive }" :href="href" data-mdb-ripple="true"
        data-mdb-ripple-color="primary">
    <component :is="icon" class="w-4 h-4 mr-3" />

    <span>
        <slot></slot>
    </span>
    </Link>
</template>