<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref} from 'vue';

import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import LoadingButton from "@/Components/LoadingButton.vue";
import {router, useForm, usePage} from "@inertiajs/vue3";

import NProgress from 'nprogress'

let timeout = null

router.on('start', () => {
    timeout = setTimeout(() => NProgress.start(), 250)
})

router.on('progress', (event) => {
    if (NProgress.isStarted() && event.detail.progress.percentage) {
        NProgress.set((event.detail.progress.percentage / 100) * 0.9)
    }
})

router.on('finish', (event) => {
    clearTimeout(timeout)
    if (!NProgress.isStarted()) {
        return
    } else if (event.detail.visit.completed) {
        NProgress.done()
    } else if (event.detail.visit.interrupted) {
        NProgress.set(0)
    } else if (event.detail.visit.cancelled) {
        NProgress.done()
        NProgress.remove()
    }
})


const props = defineProps({
    //user: Object,
});

const form = useForm({
    _method: 'POST',
    file: null,
});


const permissions = computed(() => usePage().props.permissions)


const FilePreview = ref(null);
const FileName = ref(null);
const FileInput = ref(null);

const UploadFile = () => {


    if (FileInput.value) {
        form.file = FileInput.value.files[0];
    }
    if (form.file != null){
        form.post(route('import.process'), {
            errorBag: 'UploadFile',
            preserveScroll: true,
            onSuccess: () => clearFileInput(),
        });
    }


};

const updateFilePreview = () => {
    const file = FileInput.value.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        FilePreview.value = e.target.result;
        FileName.value = file.name;
    };

    reader.readAsDataURL(file);
};

const selectNewFile = () => {
    FileInput.value.click();
};

const clearFileInput = () => {
    if (FileInput.value?.value) {
        FileInput.value.value = null;
        FileName.value.value = null;
    }
};


</script>

<template>
    <AppLayout title="DataImports">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Imports
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="m-2 p-2">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Import Your Data</h2>

                        <div>
                            <form @submit.prevent="UploadFile">
                                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                                    <div class="col-span-2">
                                        <input
                                            ref="FileInput"
                                            type="file"
                                            class="hidden"
                                            @change="updateFilePreview"
                                        >

                                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                            {{ form.progress.percentage }}%
                                        </progress>

                                        <div v-show="FilePreview" class="mt-2">
                                             {{FileName}}
                                        </div>

                                        <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewFile">
                                            Select A File
                                        </SecondaryButton>
                                    </div>

                                    <PrimaryButton :loading="form.processing" class="mt-2 mr-2" type="button" load @click.prevent="UploadFile">
                                            Import File
                                    </PrimaryButton>

                                    <div class="mt-2 pt-2 text-lg">
                                        <span v-if="$page.props.jetstream.flash">
                                            {{$page.props.jetstream.flash.banner}}
                                        </span>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </AppLayout>
</template>
