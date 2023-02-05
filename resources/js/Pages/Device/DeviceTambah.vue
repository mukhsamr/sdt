<script setup>
import Layout from "@/Layouts/Layout.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Input, Select, Button } from "@/Components";
import { useToast } from "@/Composables";

defineProps({
    raks: {
        type: Array,
        default: () => []
    }
})

const form = useForm({
    uid: '',
    jenis: '',
    rak_id: '',
})

function tambah() {
    form.post(route('device.store'), {
        onSuccess: () => {
            useToast()
            form.reset()
        },
        preserveState: false
    })
}

</script>

<template>
    <Layout judul="Tambah Device">
        <div class="rounded-lg border shadow-md p-6 mt-2">
            <form class="space-y-4" @submit.prevent="tambah">
                <Input label="UID" v-model="form.uid" required autofocus />
                <span class="text-sm text-red-400">{{ $page.props.errors.uid }}</span>
                <Input label="Jenis" v-model="form.jenis" required />
                <Select label="Rak" v-model="form.rak_id" required>
                    <option :value="item.id" v-for="item in raks">{{ item.rak }}</option>
                </Select>
                <Button color="success" type="submit" :disabled="!form.isDirty">Simpan</Button>
            </form>
        </div>
    </Layout>
</template>