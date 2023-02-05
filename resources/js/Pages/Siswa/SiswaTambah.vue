<script setup>
import Layout from "@/Layouts/Layout.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Input, Select, Button } from "@/Components";
import { useToast } from "@/Composables";

const form = useForm({
    uid: '',
    nama: '',
    tipe: '',
})

function tambah() {
    form.post(route('siswa.store'), {
        onSuccess: () => {
            useToast()
            form.reset()
        },
        preserveState: false
    })
}

</script>

<template>
    <Layout judul="Tambah Siswa">
        <div class="rounded-lg border shadow-md p-6 mt-2">
            <form class="space-y-4" @submit.prevent="tambah">
                <Input label="UID" v-model="form.uid" required autofocus />
                <span class="text-sm text-red-400">{{ $page.props.errors.uid }}</span>
                <Input label="Nama" v-model="form.nama" required />
                <Select label="Kelas" v-model="form.tipe" required>
                    <option value="fq">FQ</option>
                    <option value="qbs">QBS</option>
                </Select>
                <Button color="success" type="submit" :disabled="!form.isDirty">Simpan</Button>
            </form>
        </div>
    </Layout>
</template>