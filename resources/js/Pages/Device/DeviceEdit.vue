<script setup>
import Layout from "@/Layouts/Layout.vue";
import { Input, Select, Button } from "@/Components";
import { useToast } from "@/Composables";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    device: {
        type: Object,
        default: () => ({})
    },
    raks: {
        type: Array,
        default: () => []
    },
})

const form = useForm({
    id: props.device.id,
    uid: props.device.uid,
    jenis: props.device.jenis,
    rak_id: props.device.rak?.id,
})


function update() {
    form.patch(route('device.update'), {
        onSuccess: () => useToast(),
    })
}

</script>

<template>
    <Layout judul="Edit Device">
        <h2 class="text-2xl"># {{ device.jenis }}</h2>

        <hr class="my-4">

        <div class="rounded-lg border shadow-md p-6 mt-2">
            <form class="space-y-4" @submit.prevent="update">
                <Input label="UID" v-model="form.uid" required />
                <span class="text-sm text-red-400">{{ $page.props.errors.uid }}</span>
                <Input label="Jenis" v-model="form.jenis" required />
                <Select label="Rak" v-model="form.rak_id" required>
                    <option :value="item.id" v-for="item in raks" class="uppercase">{{ item.rak }}</option>
                </Select>
                <Button color="success" type="submit" :disabled="!form.isDirty">Simpan</Button>
            </form>
        </div>
    </Layout>
</template>