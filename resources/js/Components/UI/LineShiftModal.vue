<script setup>
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import AreaInput from '@/Components/AreaInput.vue';
import {computed, inject, onBeforeMount, onMounted, onUnmounted, ref} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DialogModal from "@/Components/DialogModal.vue";

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

const results = ref();

const query = ref('')

const emit = defineEmits(['close']);

const props = defineProps({
    show:false,
    closeable:true
});

const swal = inject('$swal');

const close = () => {
    emit('close');
};


onBeforeMount(async () => {
    getComponentProps();
})

onUnmounted(async () => {

})

onMounted(async () => {


})

let lineShiftProps = ref(null);

const getComponentProps = () => {
    axios.get(route('props.line_shift_modal'),).then((res) => {
        lineShiftProps.value = res.data;
        form.shift_type_id = res.data["all_shifts"][0];
    });

};

const form = useForm({
    shift_date:null,
    comment:null,
    shift_type_id:null,
    is_active:true
});


const createLineShift = () => {

    form.post(route('line_shift.store'), {
        preserveScroll: true,
        onSuccess: () => {
             //swal(usePage().props.jetstream.flash?.banner || '');
            close();
        },

        onError: (e) => {
            console.log(e);
        },
    });
};

let emptyErrors = computed(() => Object.keys(form.errors).length === 0 && form.errors.constructor === Object)
let borderClass = computed(() => !emptyErrors ? 'ml-4 mt-4 p-4 rounded-md border-solid border-2 border-red-500': form.latitude !== '' && form.latitude != null ? 'ml-4 mt-4 p-4 rounded-md border-solid border-2 border-green-300': 'ml-4 mt-4 p-4 rounded-md border-solid border-2 border-gray')



</script>


<template>
    <div>
        <dialog-modal :show="show"
                      :closeable="closeable"
                      @close="close" >

            <template #content>
                <div>

                    <div class="">


                        <form class="w-full m-3 p-3" >

                            <div :class="borderClass">

                                <div class="text-lg mb-2 text-indigo-400">Create new Line Shift</div>

                                <div class="mt-3">

                                    <div>
                                        <label class="block text-sm font-medium leading-6 text-gray-900">Shift Date</label>
                                        <VueDatePicker v-model="form.shift_date" style="width: 250px;" :teleport="true"></VueDatePicker>
                                    </div>

                                    <InputError class="mt-2" :message="form.errors.shift_date"/>
                                </div>

                                <div class="mt-3">

                                    <label class="block text-sm font-medium leading-6 text-gray-900">Shift Type</label>

                                    <select v-model="form.shift_type_id"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option v-for="n in lineShiftProps['all_shifts']" :key="n.id" :value="n.id">
                                            {{n.name}}
                                        </option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.shift_type_id"/>
                                </div>


                                <div class="col-span-4 mt-3">
                                    <label
                                        class="block text-sm font-medium leading-6 text-gray-900">Comments:</label>
                                    <AreaInput
                                        id="comments"
                                        :rows=6
                                        placeholder="Optional comments..."
                                        v-model="form.comment"
                                        type="text"
                                        class="mt-1 block w-1/3"
                                    />
                                    <InputError class="mt-2" :message="form.errors.comment"/>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>


            </template>

            <template #footer>

                <div>
                    <SecondaryButton class="bg-red-400" @click="createLineShift">
                        Create
                    </SecondaryButton>
                </div>

                <SecondaryButton class="ml-1" @click="close()">
                    Close
                </SecondaryButton>
            </template>
        </dialog-modal>
    </div>

</template>
