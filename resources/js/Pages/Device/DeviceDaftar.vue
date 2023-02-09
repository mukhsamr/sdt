<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Table, Th, Td, Input, Button } from "@/Components";
import { PencilSquareIcon as Pen, TrashIcon, PlusIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia';
import { useToast, useConfirm } from "@/Composables";
import { ref, watch } from 'vue';
import { debounce } from "lodash";

const props = defineProps({
    daftar: {
        type: Array,
        default: () => []
    },
    cari: String
})

const search = ref(props.cari)

watch(search, debounce((item) => {

    Inertia.get(route('device'), {
        cari: item
    }, {
        preserveScroll: true,
        preserveState: true
    })

}, 300))


async function hapus(item) {

    const cond = await useConfirm('Hapus device ' + item.jenis)

    if (cond) {
        Inertia.delete(route('device.destroy', item.id), {
            onSuccess: () => useToast()
        })
    }
}


</script>

<template>
    <Layout judul="Daftar Device">
        <div class="flex space-x-4">
            <Input class="grow" placeholder="cari uid / jenis" autofocus v-model="search" />
            <Button color="success" @click="$inertia.get(route('device.create'))">
                <PlusIcon class="w-4 h-4" />
                <span class="hidden md:inline ml-2">Tambah device</span>
            </Button>
        </div>

        <hr class="my-4">

        <Table :items="daftar">
            <template #head>
                <Th>Jenis</Th>
                <Th>Rak</Th>
                <Th>Santri</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item }">
                <Td>{{ item.jenis }}</Td>
                <Td class="uppercase">{{ item.rak?.rak ?? '-' }}</Td>
                <Td>{{ item.student?.nama ?? '-' }}</Td>
                <Td class="flex space-x-12">
                    <Link :href="route('device.edit', item.id)" class="flex align-middle text-blue-600 clickable">
                    <Pen class="h-5 w-5 mr-2" />
                    <span>Edit</span>
                    </Link>

                    <div class="flex align-middle text-red-600 clickable" @click="hapus(item)">
                        <TrashIcon class="h-5 w-5 mr-2" />
                        <span>Hapus</span>
                    </div>
                </Td>
            </template>
        </Table>
    </Layout>
</template>