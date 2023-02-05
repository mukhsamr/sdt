<script setup>
import Layout from "@/Layouts/Layout.vue";
import { Table, Th, Td, Input, Button } from "@/Components";
import { useToast, useConfirm } from "@/Composables";
import { TrashIcon, PencilSquareIcon as Pen } from "@heroicons/vue/24/outline";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { ref, watch } from "vue";
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

    Inertia.get(route('user'), {
        cari: item
    }, {
        preserveScroll: true,
        preserveState: true
    })

}, 300))

async function hapus(item) {

    const cond = await useConfirm('Hapus user ' + item.nama)

    if (cond) {
        Inertia.delete(route('user.destroy', item.id), {
            onSuccess: () => useToast()
        })
    }
}

</script>

<template>
    <Layout judul="User">
        <div class="flex space-x-8">
            <Input placeholder="cari user" autofocus v-model="search" />
            <Button color="success" @click="$inertia.get(route('user.create'))">
                <span class="hidden md:inline ml-2">Tambah User</span>
            </Button>
        </div>

        <hr class="my-4">

        <Table :items="daftar">
            <template #head>
                <Th>Nama</Th>
                <Th>Email</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item }">
                <Td>{{ item.nama }}</Td>
                <Td>{{ item.email }}</Td>
                <Td class="flex space-x-12">
                    <Link :href="route('user.edit', item.id)" class="flex align-middle text-blue-600 clickable">
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