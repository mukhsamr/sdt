<script setup>
import Layout from "@/Layouts/Layout.vue";
import { ref } from "vue";
import { isEmpty } from "lodash";
import { useToast } from "@/Composables";
import { Inertia } from "@inertiajs/inertia";
import { Datalist, Input, Table, Th, Td, Badge } from "@/Components";
import { ArrowRightCircleIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    siswa: {
        type: Array,
        default: () => []
    },
    daftar: {
        type: Array,
        default: () => []
    },
    pinjam: {
        type: Array,
        default: () => []
    }
})

const santri = ref()
const device = ref()
const error = ref()

function submitSantri() {
    Inertia.get(route('kembali'), { uid: santri.value }, {
        only: ['pinjam'],
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {

            if (isEmpty(props.pinjam)) {
                useToast({
                    icon: 'error',
                    title: 'Santri tidak ditemukan'
                })
            } else {
                document.querySelector('#deviceInput').focus()
            }
        }
    })
}

function submitDevice(manual = null) {

    const match = manual ?? props.pinjam.find(v => v.device.uid == device.value)?.id

    if (!match) {
        error.value = 'Device tidak cocok'
        return false
    }

    if (match) {
        Inertia.delete(route('pinjam.delete', match), {
            onSuccess: () => {
                useToast()

                santri.value = null
                device.value = null
                error.value = null
            }
        })
    }

}

</script>

<template>
    <Layout judul="Pengembalian">
        <div class="grid grid-cols-2 gap-4">
            <div class="rounded-lg border shadow-md p-6">
                <h2 class="text-2xl">Santri</h2>

                <hr class="my-2">

                <form @submit.prevent="submitSantri">
                    <Datalist placeholder="cari santri" v-model="santri" required autofocus>
                        <option :value="item.uid" v-for="item in siswa">{{ item.nama }}</option>
                    </Datalist>
                </form>

                <template v-for="item in pinjam">
                    <div class="rounded-lg border shadow-md p-4 flex justify-between my-2">
                        <div>
                            <div class="text-xs text-slate-600">{{ item.device.uid }}</div>
                            <div>{{ item.device.jenis }}</div>
                        </div>
                        <div class="my-auto">
                            <ArrowRightCircleIcon class="h-6 w-6 text-green-600 clickable"
                                @click="submitDevice(item.id)" />
                        </div>
                    </div>
                </template>
            </div>
            <div class="rounded-lg border shadow-md p-6">
                <h2 class="text-2xl">Device</h2>

                <hr class="my-2">

                <form @submit.prevent="submitDevice()">
                    <Input placeholder="cari device" id="deviceInput" v-model="device" required />
                    <div class="text-red-600 font-semibold mt-2" v-if="error">{{ error }}</div>
                </form>
            </div>
        </div>

        <Table class="mt-4" :items="daftar">
            <template #head>
                <Th>Santri</Th>
                <Th>Device</Th>
                <Th>Waktu Pinjam</Th>
                <Th>Waktu Kembali</Th>
                <Th>Status</Th>
                <Th>Admin</Th>
            </template>
            <template #body="{ item }">
                <Td>{{ item.student.nama }}</Td>
                <Td>{{ item.device.jenis }}</Td>
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
    </Layout>
</template>