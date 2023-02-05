<script setup>
import Layout from "@/Layouts/Layout.vue";
import { LockOpenIcon, ChevronUpIcon } from '@heroicons/vue/24/outline';
import { Table, Th, Td, Badge, BtnIcon } from "@/Components";
import { useSessionStore } from "@/Stores/Session";
import { Inertia } from "@inertiajs/inertia";
import { useToast } from "@/Composables";
import { ref } from "vue";

const user = useSessionStore().user

defineProps({
    daftar: {
        type: Array,
        default: () => []
    }
})

const modal = ref(null)

function setModal(item) {
    modal.value = item.latest_pinjam
}

function unblock(item) {
    Inertia.patch(route('siswa.unblock', item.id), {}, {
        onSuccess: () => useToast()
    })
}

</script>

<template>
    <Layout judul="Siswa Diblokir">
        <Table :items="daftar">
            <template #head>
                <Th>Nama</Th>
                <Th>Kelas</Th>
                <Th>Device</Th>
                <Th>Admin</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item }">
                <Td>{{ item.nama }}</Td>
                <Td>
                    <Badge class="uppercase" color="secondary" v-if="item.tipe == 'fq'">{{ item.tipe }}</Badge>
                    <Badge class="uppercase" color="orange" v-else>{{ item.tipe }}</Badge>
                </Td>
                <Td>
                    <BtnIcon :icon="ChevronUpIcon" class="text-blue-600" data-bs-toggle="modal"
                        data-bs-target="#riwayat" @click="setModal(item)">
                        {{ item.latest_pinjam?.device.jenis }}
                    </BtnIcon>
                </Td>
                <Td>{{ item.latest_pinjam?.user.nama }}</Td>
                <Td>
                    <template v-if="user.nama === item.latest_pinjam?.user.nama || user.level === 'admin'">
                        <BtnIcon :icon="LockOpenIcon" class="text-green-600" @click="unblock(item)">
                            Unblock
                        </BtnIcon>
                    </template>
                </Td>
            </template>
        </Table>


        <!-- Modal -->
        <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
            id="riwayat" tabindex="-1" aria-labelledby="riwayatLabel" aria-hidden="true">
            <div class="modal-dialog relative w-auto pointer-events-none">
                <div
                    class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                    <div
                        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-xl font-medium leading-normal text-gray-800" id="riwayatLabel">
                            Riwayat
                        </h5>
                        <button type="button"
                            class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body relative p-4 space-y-2" v-if="modal">
                        <div class="grid grid-cols-5">
                            <div class="col-span-2 text-slate-500">Jenis</div>
                            <div class="col-span-3">: {{ modal.device.jenis }}</div>
                        </div>
                        <div class="grid grid-cols-5">
                            <div class="col-span-2 text-slate-500">UID</div>
                            <div class="col-span-3">: {{ modal.device.uid }}</div>
                        </div>
                        <div class="grid grid-cols-5">
                            <div class="col-span-2 text-slate-500">Waktu Pinjam</div>
                            <div class="col-span-3">: {{ modal.di_buat }}</div>
                        </div>
                        <div class="grid grid-cols-5">
                            <div class="col-span-2 text-slate-500">Waktu Kembali</div>
                            <div class="col-span-3">: {{ modal.di_hapus }}</div>
                        </div>
                        <div class="grid grid-cols-5">
                            <div class="col-span-2 text-slate-500">Admin</div>
                            <div class="col-span-3">: Mukhlis Amrullah</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>