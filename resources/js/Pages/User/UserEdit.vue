<script setup>
import Layout from "@/Layouts/Layout.vue";
import { Input, Button } from "@/Components";
import { useToast } from "@/Composables";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    user: {
        type: Object,
        default: () => ({})
    }
})

const form = useForm({
    id: props.user.id,
    nama: props.user.nama,
    email: props.user.email,
    password: '',
})


function update() {
    form.patch(route('user.update'), {
        onSuccess: () => useToast(),
    })
}

</script>

<template>
    <Layout judul="Edit Device">
        <h2 class="text-2xl"># {{ user.nama }}</h2>

        <hr class="my-4">

        <div class="rounded-lg border shadow-md p-6 mt-2">
            <form class="space-y-4" @submit.prevent="update">
                <Input label="Nama" v-model="form.nama" required />
                <Input type="email" label="Email" v-model="form.email" required />
                <span class="text-sm text-red-400">{{ $page.props.errors.email }}</span>
                <Input placeholder="kosongkan jika tidak diubah" type="password" label="Password"
                    v-model="form.password" autocomplete />

                <Button color="success" type="submit" :disabled="!form.isDirty">Simpan</Button>
            </form>
        </div>
    </Layout>
</template>