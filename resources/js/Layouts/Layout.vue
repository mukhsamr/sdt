<script setup>
import Topbar from './Topbar.vue';
import Sidebar from './Sidebar.vue';
import { ref } from 'vue';

defineProps({
    judul: {
        type: String,
        required: true
    }
})

const sidebar = ref()

function toggle() {
    sidebar.value.toggle()
}

</script>

<template>

    <main class="h-full w-full md:flex">

        <Sidebar class="w-60 shrink-0" ref="sidebar" />


        <div class="w-full md:w-[calc(100%-15rem)]">

            <Topbar :judul="judul" @toggle="toggle" />


            <div class="mx-4 my-2 pt-2 md:m-4 md:p-0 grow-0">
                <slot />
            </div>
        </div>

    </main>


</template>