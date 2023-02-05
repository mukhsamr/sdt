<script setup>
import { ref } from 'vue';
import { Link, Badge } from "@/Components";
import { useSessionStore } from "@/Stores/Session";
import {
    UserIcon,
    HomeIcon,
    ComputerDesktopIcon as Computer,
    QueueListIcon,
    BarsArrowUpIcon,
    BarsArrowDownIcon,
    AdjustmentsHorizontalIcon as Rak
} from "@heroicons/vue/24/outline";

const user = useSessionStore().user
const kelas = useSessionStore().tipe

const isHide = ref(window.screen.width < 992)
function toggle() {
    isHide.value = !isHide.value
}

// Expose
defineExpose({
    toggle
})

</script>

<template>
    <Teleport to="#app">
        <div class="inset-0 fixed bg-black/30 z-10 lg:hidden" :class="{ 'hidden': isHide }" @click="toggle()" />
    </Teleport>

    <div class="shadow-md bg-white transition ease-in-out z-20 h-screen absolute lg:static"
        :class="{ '-translate-x-full': isHide }" v-bind="$attrs">

        <!-- Avatar -->
        <div class="pt-4 pb-2 px-6">
            <div class="flex items-center">
                <img src="/storage/images/user.jpg" class="rounded-full w-16" alt="Foto">
                <div class="text-sm text-slate-600 ml-3">{{ user.nama }}</div>
            </div>
            <Badge :color="kelas == 'qbs' ? 'orange' : 'secondary'" class="uppercase w-full">{{ kelas }}</Badge>
        </div>

        <hr class="my-2">

        <!-- Links -->
        <ul class="relative px-4">
            <Link :icon="HomeIcon" :isActive="$page.url.startsWith('/home')" href="/home">Beranda</Link>
            <Link :icon="BarsArrowUpIcon" :isActive="$page.url.startsWith('/pinjam')" href="/pinjam">Peminjaman</Link>
            <Link :icon="BarsArrowDownIcon" :isActive="$page.url.startsWith('/kembali')" href="/kembali">Pengembalian
            </Link>
            <Link :icon="QueueListIcon" :isActive="$page.url.startsWith('/riwayat')" href="/riwayat">Riwayat</Link>
            <hr>
            <Link :icon="UserIcon" :isActive="$page.url.startsWith('/siswa')" href="/siswa">Siswa</Link>
            <Link :icon="Computer" :isActive="$page.url.startsWith('/device')" href="/device">Device</Link>
            <template v-if="user.level === 'admin'">
                <hr>
                <Link :icon="UserIcon" :isActive="$page.url.startsWith('/user')" href="/user">User</Link>
                <Link :icon="Rak" :isActive="$page.url.startsWith('/rak')" href="/rak">Rak</Link>
            </template>
        </ul>
    </div>
</template>