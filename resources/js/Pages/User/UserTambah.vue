<script setup>
import Layout from "@/Layouts/Layout.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Input, Select, Button } from "@/Components";
import { useToast } from "@/Composables";

const form = useForm({
    nama: '',
    email: '',
    password: '',
    level: 'user',
})

function tambah() {
    form.post(route('user.store'), {
        onSuccess: () => {
            useToast()
            form.reset()
        },
        preserveState: false
    })
}

</script>

<template>
    <Layout judul="Tambah User">
        <div class="rounded-lg border shadow-md p-6 mt-2">
            <form class="space-y-4" @submit.prevent="tambah">
                <Input label="Nama" v-model="form.nama" required autofocus />
                <Input type="email" label="Email" v-model="form.email" required />
                <span class="text-sm text-red-400">{{ $page.props.errors.email }}</span>
                <Input type="password" label="Password" v-model="form.password" required />
                <Select label="Level" v-model="form.level" required>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </Select>

                <Button color="success" type="submit" :disabled="!form.isDirty">Simpan</Button>
            </form>
        </div>
    </Layout>
</template>