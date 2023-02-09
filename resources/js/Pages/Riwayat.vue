<script setup>
import Layout from "@/Layouts/Layout.vue";
import { ref, watch } from "vue";
import { debounce } from "lodash";
import { Inertia } from '@inertiajs/inertia';
import { Table, Th, Td, Input, Badge, Button, Select } from "@/Components";
import { CheckCircleIcon, FunnelIcon } from "@heroicons/vue/24/outline";
import { useForm } from "@inertiajs/inertia-vue3";

const mobile = ref(screen.width < 1024)
const now = (new Date()).toISOString().split('T')[0]

const props = defineProps({
    raks: {
        type: Array,
        default: () => []
    },
    daftar: {
        type: Array,
        default: () => []
    },
    cari: String,
    start: String,
    end: String,
    rak: String,
    status: String | Number,
})

const search = ref(props.cari)

const form = useForm({
    start: props.start ?? now,
    end: props.end ?? now,
    rak: props.rak ?? 0,
    status: props.status ?? 0,
})

watch(search, debounce((item) => filter(item), 300))


function filter(item = null) {
    Inertia.get(route('riwayat'), {
        start: form.start,
        end: form.end,
        rak: form.rak,
        status: form.status,
        cari: item ?? props.cari,
    })
}

</script>

<template>
    <Layout judul="Riwayat">
        <div class="flex space-x-6">
            <Input placeholder="cari santri" autofocus v-model="search" />
            <Button color="warning" data-bs-toggle="modal" data-bs-target="#filter">
                <FunnelIcon class="w-4 h-4 inline" />
                <span class="ml-2" v-if="!mobile">Filter</span>
            </Button>
        </div>

        <hr class="my-4">

        <Table :items="daftar">
            <template #head>
                <Th>Santri</Th>
                <Th>Device</Th>
                <Th>Rak</Th>
                <Th>Dipinjam</Th>
                <Th>Waktu Pinjam</Th>
                <Th>Waktu Kembali</Th>
                <Th>Status</Th>
                <Th>Admin</Th>
            </template>
            <template #body="{ item }">
                <Td>{{ item.student?.nama }}</Td>
                <Td>{{ item.device.jenis }}</Td>
                <Td>{{ item.device.rak?.rak ?? '-' }}</Td>
                <Td>
                    <CheckCircleIcon class="w-5 h-5 text-green-600" v-if="item.dipinjam" />
                    <span v-else>-</span>
                </Td>
                <Td>{{ item.di_buat }}</Td>
                <Td>{{ item.di_hapus ?? '-' }}</Td>
                <Td>
                    <Badge :color="item.status.color" v-if="item.status">
                        {{ item.status.message }}
                    </Badge>
                    <span v-else>-</span>
                </Td>
                <Td>{{ item.user.nama }}</Td>
            </template>
        </Table>

        <!-- Modal -->
        <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
            id="filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterLabel"
            aria-hidden="true">
            <div class="modal-dialog relative w-auto pointer-events-none">
                <form @submit.prevent="filter()">
                    <div
                        class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                        <div
                            class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">
                                Filter
                            </h5>
                            <button type="button"
                                class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body relative p-4 space-y-4">
                            <div class="flex space-x-2">
                                <Input type="date" v-model="form.start" label="Start" :max="now" required />
                                <Input type="date" v-model="form.end" label="End" :min="form.start" :max="now"
                                    required />
                            </div>
                            <Select v-model="form.rak" label="Rak Device">
                                <option value="0">-</option>
                                <option :value="item.id" v-for="item in raks">{{ item.rak }}</option>
                            </Select>
                            <Select v-model="form.status" label="Status">
                                <option value="0">-</option>
                                <option value="dipinjam">Sedang dipinjam</option>
                                <option value="kembali">Sudah kembali</option>
                            </Select>
                        </div>
                        <div
                            class="modal-footer flex flex-shrink-0 flex-wrap items-center p-4 border-t border-gray-200 rounded-b-md justify-between">
                            <Button color="secondary" data-bs-dismiss="modal">Tutup</Button>
                            <Button type="submit" data-bs-dismiss="modal">Filter</Button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </Layout>
</template>