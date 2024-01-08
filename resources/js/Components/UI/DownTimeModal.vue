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
    closeable:true,
    line_shift_id: Number,
    interlock_line_id:Number


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

let downTimeProps = ref(null);

const getComponentProps = () => {
    axios.get(route('props.interlock_down_time_modal'),).then((res) => {
        downTimeProps.value = res.data;
        //form.shift_type_id = res.data["all_shifts"][0];
    });

};


//line_shift_id','interlock_line_id','interlock_down_time_type_id','value','comment'

const form = useForm({
    line_shift_id:props.line_shift_id,
    interlock_line_id:props.interlock_line_id,
    interlock_down_time_type_id:1,
    value:0,
    comment:null
});


const createDownTime = () => {

    form.post(route('interlock_down_time.store'), {
        preserveScroll: true,
        onSuccess: () => {
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

                                <div class="text-lg mb-2 text-indigo-400">New Down Time</div>
                                <div class="mt-3">

                                    <label class="block text-sm font-medium leading-6 text-gray-900">Down Time Type</label>

                                    <select v-model="form.interlock_down_time_type_id"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option v-for="n in downTimeProps['all_interlock_down_time_types']" :key="n.id" :value="n.id">
                                            {{n.type}}
                                        </option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.interlock_down_time_type_id"/>

                                </div>

                                <div class="col-span-4 mt-3">
                                    <div>
                                        <label class="block text-sm font-medium leading-6 text-gray-900 sm:mt-1.5">Value</label>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <input v-model="form.value" type="number" name="value" id="value"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                        <InputError class="mt-2" :message="form.errors.value"/>
                                    </div>
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
                    <SecondaryButton @click="createDownTime" class="bg-red-400">
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
