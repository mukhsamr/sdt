<script setup>
import Layout from '@/Layouts/Layout.vue';
import { useToast, useConfirm } from "@/Composables";
import { Table, Th, Td, Badge, Input, Button, BtnIcon } from "@/Components";
import { LockClosedIcon, PencilSquareIcon as Pen, SquaresPlusIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { useSessionStore } from "@/Stores/Session";
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia';
import { ref, watch } from 'vue';
import { debounce } from "lodash";


const user = useSessionStore().user

const props = defineProps({
    daftar: {
        type: Array,
        default: () => []
    },
    cari: String
})

const search = ref(props.cari)

watch(search, debounce((item) => {

    Inertia.get(route('siswa'), {
        cari: item
    }, {
        preserveScroll: true,
        preserveState: true
    })

}, 300))


async function hapus(item) {

    const cond = await useConfirm('Hapus siswa ' + item.nama)

    if (cond) {
        Inertia.delete(route('siswa.destroy', item.id), {
            onSuccess: () => useToast()
        })
    }
}

async function block(item) {

    const cond = await useConfirm('Blokir siswa ' + item.nama)

    if (cond) {
        Inertia.patch(route('siswa.block', item.id), {}, {
            onSuccess: () => useToast()
        })
    }
}


</script>

<template>
    <Layout judul="Daftar Siswa">
        <div class="flex space-x-8">
            <Input placeholder="cari uid / nama" autofocus v-model="search" />
            <div class="flex space-x-2">
                <Button color="success" @click="$inertia.get(route('siswa.create'))">
                    <span class="hidden md:inline ml-2">Tambah Siswa</span>
                </Button>
                <Button color="dark" @click="$inertia.get(route('siswa.disable'))">
                    <span class="hidden md:inline ml-2">Siswa Blokir</span>
                </Button>
            </div>
        </div>

        <hr class="my-4">

        <Table :items="daftar">
            <template #head>
                <Th>Nama</Th>
                <Th>Kelas</Th>
                <Th>Device</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item }">
                <Td>
                    <div class="text-slate-400" v-if="item.is_block">
                        <span>{{ item.nama }}</span>
                        <LockClosedIcon class="h-5 w-5 inline ml-2" />
                    </div>
                    <span v-else>{{ item.nama }}</span>
                </Td>
                <Td>
                    <Badge class="uppercase" color="secondary" v-if="item.tipe == 'fq'">{{ item.tipe }}</Badge>
                    <Badge class="uppercase" color="orange" v-else>{{ item.tipe }}</Badge>
                </Td>
                <Td>
                    <div class="flex">
                        <span>{{ item.devices_count }}</span>
                        <Link :href="route('siswa.assigne', item.id)" class="space-x-2 ml-4 clickable text-purple-600">
                        <SquaresPlusIcon class="w-5 h-5 inline" />
                        <span>Assigne</span>
                        </Link>
                    </div>
                </Td>
                <Td class="flex space-x-12">
                    <Link :href="route('siswa.edit', item.id)" class="flex align-middle text-blue-600 clickable">
                    <Pen class="h-5 w-5 mr-2" />
                    <span>Edit</span>
                    </Link>
                    <BtnIcon :icon="TrashIcon" class="text-red-600" @click="hapus(item)">Hapus</BtnIcon>

                    <template v-if="user.level === 'admin'">
                        <BtnIcon :icon="LockClosedIcon" class="text-slate-600" @click="block(item)"
                            v-if="!item.is_block">
                            Block
                        </BtnIcon>
                    </template>
                </Td>
            </template>
        </Table>

    </Layout>
</template>