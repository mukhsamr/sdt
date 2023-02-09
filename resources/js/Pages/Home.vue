<script setup>
import Layout from "@/Layouts/Layout.vue";
import { Table, Th, Td } from "@/Components";

defineProps({
    now: String,
    pinjam: {
        type: Array,
        default: () => []
    },
    kembali: {
        type: Array,
        default: () => []
    }
})

</script>

<template>
    <Layout judul="Beranda">
        <h2 class="text-2xl text-slate-700 mt-8"># {{ now }}</h2>

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
    </Layout>
</template>