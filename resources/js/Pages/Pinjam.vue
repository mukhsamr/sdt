<script setup>
import Layout from "@/Layouts/Layout.vue";
import { ref } from "vue";
import { isEmpty } from "lodash";
import { useToast } from "@/Composables";
import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-vue3";
import { Datalist, Table, Th, Td, Badge } from "@/Components";
import { CheckCircleIcon, XCircleIcon } from "@heroicons/vue/24/outline";
import { useSessionStore } from "@/Stores/Session";


const props = defineProps({
    siswa: {
        type: Array,
        default: () => []
    },
    device: {
        type: Array,
        default: () => []
    },
    santri: {
        type: Object,
        default: () => ({})
    },
    daftar: {
        type: Array,
        default: () => []
    }
})

const form = useForm({
    user_id: '',
    student_id: '',
    device_id: '',
    dipinjam: false
})

const santriCari = ref(null)
const deviceCari = ref(null)
const pinjamCari = ref(null)
const status = ref(false)
const match = ref(false)
const isSubmit = ref(false)
const error = ref()

function submitSantri() {
    Inertia.get(route('pinjam'), { uid: santriCari.value }, {
        only: ['santri'],
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {

            if (isEmpty(props.santri)) {
                useToast({
                    icon: 'error',
                    title: 'Santri tidak ditemukan'
                })
            } else {
                document.querySelector('#listDevice').focus()
                form.student_id = props.santri.id
            }

        }
    })
}

function submitDevice() {
    isSubmit.value = true

    const find = props.santri.devices.find(v => v.uid === deviceCari.value)
    status.value = find?.status
    match.value = !isEmpty(find)

    // Jika device sedang dipinjam
    if (status.value) return false


    // Jika device tidak cocok focus peminjam
    if (!match.value) document.querySelector('#listPinjam').focus()


    // Jika device cocok / pinjam value true
    if (match.value || pinjamCari.value) {

        if (pinjamCari.value) {

            // Konfirmasi
            const findSiswa = props.siswa.find(v => v.uid === pinjamCari.value)
            const findDevice = props.device.find(v => v.uid == deviceCari.value)

            if (findSiswa.id !== findDevice.student_id) {
                error.value = 'Pemilik tidak cocok'
                return false
            };

            form.dipinjam = true
        }

        form.device_id = props.device.find(v => v.uid === deviceCari.value).id
        form.user_id = useSessionStore().user.id

        form.post(route('pinjam.store'), {
            onSuccess: () => {
                useToast()

                form.reset()
                santriCari.value = null
                deviceCari.value = null
                pinjamCari.value = null

                isSubmit.value = false
            },
            preserveState: false
        })
    }
}

</script>

<template>
    <Layout judul="Peminjaman">
        <div class="grid grid-cols-2 gap-4">
            <div class="rounded-lg border shadow-md p-6">
                <h2 class="text-2xl">Santri</h2>
                <hr class="my-2">
                <form @submit.prevent="submitSantri">
                    <Datalist placeholder="cari santri" v-model="santriCari" required autofocus>
                        <option :value="item.uid" v-for="item in siswa">{{ item.nama }}</option>
                    </Datalist>
                </form>

                <div class="mt-4 space-y-2" v-if="!isEmpty(santri)">
                    <span># {{ santri.nama }}</span>

                    <template v-for="item in santri.devices">
                        <div class="rounded-lg border shadow-md p-4 flex justify-between my-2">
                            <div>
                                <div class="text-xs text-slate-600">{{ item.uid }}</div>
                                <div>{{ item.jenis }}</div>
                            </div>
                            <div>
                                <Badge color="warning" v-if="item.status">Sedang dipinjam</Badge>
                                <Badge color="success" v-else>Tersedia</Badge>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <div class="rounded-lg border shadow-md p-6">
                <h2 class="text-2xl">Device</h2>
                <hr class="my-2">
                <form @submit.prevent="submitDevice">
                    <Datalist placeholder="cari device" id="listDevice" v-model="deviceCari" required>
                        <option :value="item.uid" v-for="item in device">{{ item.jenis }}</option>
                    </Datalist>
                </form>

                <template v-if="isSubmit">
                    <div class="flex mt-4 bg-red-200 p-3 rounded-lg" v-if="status || !match">
                        <XCircleIcon class="text-red-600 h-6 w-6" />
                        <div class="my-auto ml-2">Tidak Tersedia</div>
                    </div>
                    <div class="flex mt-4 bg-green-200 p-3 rounded-lg" v-else>
                        <CheckCircleIcon class="text-green-600 h-6 w-6" />
                        <div class="my-auto ml-2">Tersedia</div>
                    </div>
                </template>

                <hr class="my-4">

                <h2 class="text-2xl mb-2">Pinjam dari</h2>
                <form @submit.prevent="submitDevice">
                    <Datalist placeholder="kofirmasi pemilik" id="listPinjam" v-model="pinjamCari" required>
                        <option :value="item.uid" v-for="item in siswa">{{ item.nama }}</option>
                    </Datalist>
                    <div class="text-red-600 font-semibold mt-2" v-if="error">{{ error }}</div>
                </form>
            </div>
        </div>

        <Table :items="daftar" class="mt-4">
            <template #head>
                <Th>Santri</Th>
                <Th>Device</Th>
                <Th>Dipinjam</Th>
                <Th>Waktu Pinjam</Th>
                <Th>Admin</Th>
            </template>
            <template #body="{ item }">
                <Td>{{ item.student.nama }}</Td>
                <Td>{{ item.device.jenis }}</Td>
                <Td>
                    <CheckCircleIcon class="w-5 h-5 text-green-600" v-if="item.dipinjam" />
                    <span v-else>-</span>
                </Td>
                <Td>{{ item.di_buat }}</Td>
                <Td>{{ item.user.nama }}</Td>
            </template>
        </Table>
    </Layout>
</template>