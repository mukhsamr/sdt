<script setup>
import { Bars3Icon as Menu, ArrowLeftOnRectangleIcon as Logout } from "@heroicons/vue/24/outline";
import { useConfirm } from "@/Composables";
import { Inertia } from "@inertiajs/inertia";

async function logout() {

    const cond = await useConfirm('Akhiri Sesi')

    if (cond) {
        Inertia.get(route('logout'))
    }
}

defineProps({
    judul: String
})

defineEmits([
    'toggle'
])

</script>

<template>
    <nav class="sticky top-0 p-4 flex justify-between items-center bg-white border-b shadow-sm">
        <h2 class="text-xl md:text-2xl ml-4">{{ judul }}</h2>
        <div class="flex space-x-3">
            <Logout class="w-6 h-6 clickable" @click="logout" />
            <Menu class="w-8 h-8 clickable md:hidden" @click="$emit('toggle')" />
        </div>
    </nav>
</template>