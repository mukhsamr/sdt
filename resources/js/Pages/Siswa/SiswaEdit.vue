<script setup>
import Layout from "@/Layouts/Layout.vue";
import { Input, Select, Button } from "@/Components";
import { useToast } from "@/Composables";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    siswa: {
        type: Object,
        default: () => ({})
    }
})

const form = useForm({
    id: props.siswa.id,
    uid: props.siswa.uid,
    nama: props.siswa.nama,
    tipe: props.siswa.tipe,
})


function update() {
    form.patch(route('siswa.update'), {
        onSuccess: () => useToast(),
    })
}

</script>

<template>
    <Layout judul="Edit Siswa">
        <h2 class="text-2xl"># {{ siswa.nama }}</h2>

        <hr class="my-4">

        <div class="rounded-lg border shadow-md p-6 mt-2">
            <form class="space-y-4" @submit.prevent="update">
                <Input label="UID" v-model="form.uid" required />
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