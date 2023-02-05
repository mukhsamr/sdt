<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Table, Th, Td, Button, Datalist } from "@/Components";
import { useConfirm, useToast } from "@/Composables";
import { PlusIcon, UserMinusIcon } from '@heroicons/vue/24/outline';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from "@inertiajs/inertia-vue3";


const props = defineProps({
    siswa: {
        type: Object,
        default: () => ({})
    },
    devices: {
        type: Array,
        default: () => []
    },
    daftar: {
        type: Array,
        default: () => []
    },
})

const form = useForm({
    uid: '',
    siswa: props.siswa.id
})

function simpan() {
    form.patch(route('siswa.link'), {
        onSuccess: () => {
            useToast()
            form.reset()
        },
        preserveState: false
    })
}

async function hapus(item) {
    const cond = await useConfirm('Unlink Device')

    if (cond) {
        Inertia.patch(route('siswa.unlink', item.id), {}, {
            onSuccess: () => useToast()
        })
    }
}

</script>

<template>
    <Layout judul="Assigne Device">
        <h2 class="text-2xl"># {{ siswa.nama }}</h2>

        <hr class="my-4">

        <form class="flex space-x-2 mb-4" @submit.prevent="simpan">
            <Datalist placeholder="cari device" v-model="form.uid" autofocus>
                <option :value="item.uid" v-for="item in daftar">{{ item.jenis }}</option>
            </Datalist>
            <Button type="submit" color="secondary" :disabled="!form.uid">
                <PlusIcon class="h-4 w-4 inline" />
            </Button>
        </form>

        <Table :items="devices">
            <template #head>
                <Th>UID</Th>
                <Th>Device</Th>
                <Th>Rak</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item }">
                <Td>{{ item.uid }}</Td>
                <Td>{{ item.jenis }}</Td>
                <Td>{{ item.rak?.rak }}</Td>
                <Td>
                    <div class="flex align-middle text-red-600 clickable" @click="hapus(item)">
                        <UserMinusIcon class="h-5 w-5 mr-2" />
                        <span>Unlink</span>
                    </div>
                </Td>
            </template>
        </Table>
    </Layout>

</template>