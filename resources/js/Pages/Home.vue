<script setup>
import Layout from "@/Layouts/Layout.vue";
import { Table, Th, Td, Button } from "@/Components";
import { Inertia } from "@inertiajs/inertia";
import { isEmpty } from "lodash";

const props = defineProps({
    now: String,
    pinjam: {
        type: Array,
        default: () => []
    },
    kembali: {
        type: Array,
        default: () => []
    },
    sedang_dipinjam: {
        type: Array,
        default: () => []
    },
})

</script>

<template>
    <Layout judul="Beranda">
        <div class="md:flex justify-between mt-4">
            <h2 class="text-2xl text-slate-700 mb-4 md:m-0"># {{ now }}</h2>
            <Button color="warning" data-bs-toggle="modal" data-bs-target="#dipinjam">
                Sedang Dipinjam
            </Button>
        </div>

        <hr class="my-2">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <span class="text-yellow-600">{{ pinjam.length }} Siswa</span>
                <Table :items="pinjam">
                    <template #head>
                        <Th>Nama</Th>
                        <Th>Device</Th>
                        <Th>Waktu Pinjam</Th>
                    </template>
                    <template #body="{ item }">
                        <Td>{{ item.student.nama }}</Td>
                        <Td>{{ item.device.jenis }}</Td>
                        <Td>{{ item.di_buat }}</Td>
                    </template>
                </Table>
            </div>
            <div>
                <span class="italic text-slate-600">{{ kembali.length }} Siswa</span>
                <Table :items="kembali">
                    <template #head>
                        <Th>Nama</Th>
                        <Th>Device</Th>
                        <Th>Waktu Kembali</Th>
                    </template>
                    <template #body="{ item }">
                        <Td>{{ item.student.nama }}</Td>
                        <Td>{{ item.device.jenis }}</Td>
                        <Td>{{ item.di_hapus }}</Td>
                    </template>
                </Table>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
            id="dipinjam" tabindex="-1" aria-labelledby="dipinjamLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg relative w-auto pointer-events-none">
                <div
                    class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                    <div
                        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">
                            Sedang Dipinjam
                        </h5>
                        <button type="button"
                            class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body relative p-4">
                        <Table :items="sedang_dipinjam">
                            <template #head>
                                <Th>Tanggal</Th>
                                <Th>Nama</Th>
                                <Th>Device</Th>
                                <Th>Waktu Pinjam</Th>
                            </template>
                            <template #body="{ item }">
                                <Td>{{ item.tanggal }}</Td>
                                <Td>{{ item.student.nama }}</Td>
                                <Td>{{ item.device.jenis }}</Td>
                                <Td>{{ item.di_buat }}</Td>
                            </template>
                        </Table>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>