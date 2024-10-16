<script setup>
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import AreaInput from '@/Components/AreaInput.vue';
import {computed, inject, onBeforeMount, onMounted, onUnmounted, ref, watch} from "vue";
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
    component_line_id:Number,
    component:String,
    production_model_type_id:Number,
    isEditing: Boolean,
    defect: Object
});

const form = useForm({
    defect_id: null,
    line_shift_id:props.line_shift_id,
    component_line_id:props.component_line_id,
    component:props.component,
    defect_group_type_id:1,
    defect_type_id:1,
    defect_bases_type_id:1,
    value:0,
    salvage_value:0,
    comment:null,
    is_inc:1
});

const close = () => {
    emit('close');
};


onBeforeMount(async () => {
    getComponentProps();
})

onUnmounted(async () => {

})

onMounted(() => {

});

watch(() => props.defect, (newDefect) => {
    if (newDefect) {
        console.log("Defect found:");
        console.log(props.defect);
        if (props.defect) {
            //console.log(props.defect.defect_type.defect_group.id);
            form.defect_id = defect.id
            form.defect_group_type_id = props.defect.defect_type.defect_group.id;
            filterTypes();
            form.defect_type_id = props.defect.defect_type.id;
            form.line_shift_id = props.line_shift_id
            form.component_line_id = props.component_line_id
            form.component = props.component
            form.defect_bases_type_id = props.defect.defect_bases_type_id
            form.value = props.defect.value
            form.salvage_value = props.defect.salvage_value
            form.comment = props.defect.comment
            form.is_inc = props.defect.is_inc
        }
    }
});

const defectProps = ref({
    all_interlock_defect_groups: [],
    all_interlock_defect_types: [],
    all_defect_bases: [],
    filtered_groups: [],
    filtered_types: [],
});

const getComponentProps = () => {
    axios.get(route('props.interlock_defect_modal')).then((res) => {
        defectProps.value.all_interlock_defect_groups = res.data['all_interlock_defect_groups'];
        defectProps.value.all_interlock_defect_types = res.data['all_interlock_defect_types'];
        defectProps.value.all_defect_bases = res.data['all_defect_bases'];
        filterGroups();
    });
};

const filterGroups = () => {
    defectProps.value.filtered_groups = defectProps.value.all_interlock_defect_groups.filter(
        group => group.component === form.component
    );
};

const filterTypes = () => {
    defectProps.value.filtered_types = defectProps.value.all_interlock_defect_types.filter(
        type => type.component === form.component && type.defect_group_id === form.defect_group_type_id
    );
};

watch(() => form.component, () => {
    filterGroups();
    form.defect_group_type_id = null;
    form.defect_type_id = null;
});

// Watch for changes in selected group to update defect types
watch(() => form.defect_group_type_id, () => {
    filterTypes();
});

const createDefect = () => {

    form.post('/component_line/add_defect/' + props.component, {
        preserveScroll: true,
        onSuccess: () => {
            //alert('Created');
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

                                <div v-if="!isEditing" class="text-lg mb-2 text-indigo-400">New Defect</div>
                                <div v-if="isEditing" class="text-lg mb-2 text-indigo-400">Update Defect</div>
                                <div class="mt-3">

                                    <label class="block text-sm font-medium leading-6 text-gray-900">Defect Group</label>
                                    <select v-model="form.defect_group_type_id"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option v-for="group in defectProps.filtered_groups" :key="group.id" :value="group.id">
                                            {{group.value}}
                                        </option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.defect_group_type_id"/>

                                </div>

                                <div class="mt-3">

                                    <label class="block text-sm font-medium leading-6 text-gray-900">Defect Type</label>

                                    <select v-model="form.defect_type_id"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option v-for="type in defectProps.filtered_types" :key="type.id" :value="type.id">
                                            {{type.value}}
                                        </option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.defect_type_id"/>

                                </div>

                                <div class="mt-3">

                                    <label class="block text-sm font-medium leading-6 text-gray-900">Defect Basis</label>

                                    <select v-model="form.defect_bases_type_id"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option v-for="n in defectProps.all_defect_bases" :key="n.id" :value="n.id">
                                            {{n.value}}
                                        </option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.defect_bases_type_id"/>

                                </div>

                                <div class="mt-3">

                                    <label class="block text-sm font-medium leading-6 text-gray-900">Defect Included</label>

                                    <select v-model="form.is_inc"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option value="1">Included</option>
                                        <option value="0">Excluded</option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.is_inc"/>

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
                                    <div>
                                        <label class="block text-sm font-medium leading-6 text-gray-900 sm:mt-1.5">Salvage Value</label>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <input v-model="form.salvage_value" type="number" name="value" id="salvage_value"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                        <InputError class="mt-2" :message="form.errors.salvage_value"/>
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
                    <SecondaryButton @click="createDefect" class="bg-red-400">
                        <div v-if="!defect">Create</div>
                        <div v-if="defect">Update</div>
                    </SecondaryButton>
                </div>

                <SecondaryButton class="ml-1" @click="close()">
                    Close
                </SecondaryButton>
            </template>
        </dialog-modal>
    </div>

</template>
