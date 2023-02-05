<script setup>
import Layout from "@/Layouts/Layout.vue";
import { useToast, useConfirm } from "@/Composables";
import { Table, Th, Td, BtnIcon, Button, Input } from "@/Components";
import { useForm } from "@inertiajs/inertia-vue3";
import { TrashIcon, PencilSquareIcon as Pen, SquaresPlusIcon } from "@heroicons/vue/24/outline";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    daftar: {
        type: Array,
        default: () => []
    }
})

const formTambah = useForm({
    rak: null,
})

const formEdit = useForm({
    id: null,
    rak: null,
})

function modalEdit(item) {
    formEdit.id = item.id
    formEdit.rak = item.rak
}

function store() {
    formTambah.post(route('rak.store'), {
        onSuccess: () => useToast(),
        onError: (err) => useToast({
            icon: 'error',
            title: err.rak
        })
    })
}

function update() {
    formEdit.patch(route('rak.update'), {
        onSuccess: () => useToast(),
        onError: (err) => useToast({
            icon: 'error',
            title: err.rak
        })
    })
}


async function hapus(item) {
    const cond = await useConfirm('Hapus rak')

    if (cond) {
        Inertia.delete(route('rak.destroy', item.id), {
            onSuccess: () => useToast()
        })
    }
}


</script>

<template>
    <Layout judul="Rak">
        <Button color="success" class="mb-2" data-bs-toggle="modal" data-bs-target="#tambah">Tambah Rak</Button>
        <Table :items="daftar">
            <template #head>
                <Th>Rak</Th>
                <Th>Jumlah Device</Th>
                <Th>Assigne</Th>
                <Th>Aksi</Th>
            </template>
            <template #body="{ item }">
                <Td>{{ item.rak }}</Td>
                <Td>{{ item.device_count }}</Td>
                <Td>
                    <BtnIcon :icon="SquaresPlusIcon" class="text-purple-600"
                        @click="$inertia.get(route('rak.assigne', item.id))">
                        Assigne
                    </BtnIcon>
                </Td>
                <Td class="flex space-x-4">
                    <BtnIcon :icon="Pen" class="text-blue-600" data-bs-toggle="modal" data-bs-target="#edit"
                        @click="modalEdit(item)">Edit</BtnIcon>
                    <BtnIcon :icon="TrashIcon" class="text-red-600" @click="hapus(item)">Hapus</BtnIcon>
                </Td>
            </template>
        </Table>


        <!-- Modal Edit -->
        <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
            id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel"
            aria-hidden="true">
            <div class="modal-dialog relative w-auto pointer-events-none">
                <div
                    class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                    <form @submit.prevent="update">
                        <div
                            class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                            <h5 class="text-xl font-medium leading-normal text-gray-800">
                                Edit Rak
                            </h5>
                            <button type="button"
                                class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body relative p-4">
                            <Input label="Nama rak" required v-model="formEdit.rak" />
                        </div>
                        <div
                            class="modal-footer flex flex-shrink-0 space-x-2 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                            <Button color="secondary" type="button" data-bs-dismiss="modal">Tutup</Button>
                            <Button type="submit" data-bs-dismiss="modal">Simpan</Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal Tambah -->
        <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
            id="tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tambahLabel"
            aria-hidden="true">
            <div class="modal-dialog relative w-auto pointer-events-none">
                <div
                    class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                    <form @submit.prevent="store">
                        <div
                            class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                            <h5 class="text-xl font-medium leading-normal text-gray-800">
                                Tambah Rak
                            </h5>
                            <button type="button"
                                class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body relative p-4">
                            <Input label="Nama rak" required v-model="formTambah.rak" />
                        </div>
                        <div
                            class="modal-footer flex flex-shrink-0 space-x-2 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                            <Button color="secondary" type="button" data-bs-dismiss="modal">Tutup</Button>
                            <Button type="submit" data-bs-dismiss="modal">Simpan</Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </Layout>
</template>