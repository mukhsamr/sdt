<script setup>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from '@inertiajs/inertia';
import { useForm } from "@inertiajs/inertia-vue3";
import { useToast, useConfirm } from "@/Composables";
import { Table, Th, Td, Datalist, Button, BtnIcon } from "@/Components";
import { PlusIcon, FolderMinusIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    rak: {
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
    uid: null,
    rak_id: props.rak.id,
})

function tambah() {
    form.patch(route('rak.link'), {
        onSuccess: () => {
            useToast()
            form.reset('uid')
            document.querySelector('#device').focus()
        }
    })
}

async function unlink(item) {
    const cond = await useConfirm('Unlink Device')

    if (cond) {
        Inertia.patch(route('rak.unlink', item.id), {}, {
            onSuccess: () => useToast()
        })
    }
}

</script>

<template>
    <Layout judul="Assigne Device">
        <h2 class="text-2xl"># Rak {{ rak.rak }}</h2>

        <hr class="my-4">

        <form class="flex space-x-4 mb-4" @submit.prevent="tambah">
            <Datalist placeholder="cari device" id="device" v-model="form.uid" required>
                <option :value="item.uid" v-for="item in daftar">{{ item.jenis }}</option>
            </Datalist>

            <Button color="secondary" type="submit">
                <PlusIcon class="w-4 h-4" />
            </Button>
        </form>

        <Table :items="devices">
            <template #head>
                <Th>Device</Th>
                <Th>Siswa</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item }">
                <Td>{{ item.jenis }}</Td>
                <Td>{{ item.student?.nama ?? '-' }}</Td>
                <Td>
                    <BtnIcon :icon="FolderMinusIcon" class="text-red-600" @click="unlink(item)">Unlink</BtnIcon>
                </Td>
            </template>
        </Table>
    </Layout>
</template>