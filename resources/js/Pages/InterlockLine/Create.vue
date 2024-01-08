<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch, inject} from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, useForm, usePage} from "@inertiajs/vue3";
import InputError from '@/Components/InputError.vue';
import LineShiftModal from "@/Components/UI/LineShiftModal.vue";
import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxLabel,
    ComboboxOption,
    ComboboxOptions,
} from '@headlessui/vue';

import {CheckIcon, ChevronUpDownIcon, PaperClipIcon} from '@heroicons/vue/20/solid';


const swal = inject('$swal');


const props = defineProps({
    all_line_shifts:Object,
    all_production_models:Object,
    all_staff_members:Object,
    all_business_units:Object,
    all_assembly_lines:Object,
    all_interlocks:Object
});

//'job_card_no','production_model_type_id','shift_leader_id','operator_id','business_unit_id','assembly_line_id'
let form = useForm({
    line_shift_id:null,
    job_card_no:null,
    production_model_type_id:1,
    interlock_type_id:1,
    shift_leader_id:1,
    operator_id:1,
    business_unit_id:1,
    assembly_line_id:1,

});

const reset = () => {
        form.line_shift_id=null;
        form.job_card_no=null;
        form.production_model_type_id=1;
        form.interlock_type_id=1;
        form.shift_leader_id=1;
        form.operator_id=1;
        form.business_unit_id=1;
        form.assembly_line_id=1;
};

let modelTypeQuery = ref('');

const filteredModelTypes = computed(() =>
    modelTypeQuery.value === ''
        ? props.all_production_models
        : props.all_production_models.filter((production_model) => {
            return production_model.model.toLowerCase().includes(modelTypeQuery.value.toLowerCase())
        })
);

let interlockTypeQuery = ref('');

const filteredInterlockTypes = computed(() =>
    interlockTypeQuery.value === ''
        ? props.all_interlocks.filter((interlock) => {
            return interlock.model_type_id === form.production_model_type_id;
        })
        : props.all_interlocks.filter((interlock) => {
            return interlock.production_model.model.toLowerCase().includes(modelTypeQuery.value.toLowerCase());
        }).filter((interlock) => {
            return interlock.model_type_id === form.production_model_type_id;
        })
);



//const roles_permissions = computed(() => usePage().props.roles_permissions);
//const can_manage_users = computed(() => usePage().props.roles_permissions.permissions.includes("manage_users"));

const viewLineShiftModal = ref(false);

const closeLineShiftModal = () => {
    viewLineShiftModal.value = false;
};

const viewLineShiftDetail = () => {
    viewLineShiftModal.value = true;
};



const createInterlockLine = () => {

    form.post(route('interlock_line.store'), {
        preserveScroll: true,
        onSuccess: () => {

            alert('Created');
            reset();

        },

        onError: (e) => {
            console.log(e);
        },
    });
};

let found_interlock = computed(() => props.all_interlocks.length === 0 || form.interlock_type_id === 1 ? null :  props.all_interlocks.find(element => element.id === form.interlock_type_id));


</script>

<template>
    <AppLayout title="InterLock Line">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Interlock Line
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div>

                        <LineShiftModal :show="viewLineShiftModal" @close="closeLineShiftModal"/>

                        <div class="m-3 p-3">
                            <form>
                                <div class="text-lg mb-4 text-indigo-400">Interlock Line</div>
                                <div class="space-y-12">
                                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                                        <div>
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">Line Shift</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Create or select relevant Line Shift.</p>
                                            <p class="mt-2 text-sm leading-6 text-gray-600">The Details below are linked to the specific Line Shift.</p>
                                        </div>

                                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Selected Line Shift</label>
                                                <div class="mt-2">

                                                    <select v-model="form.line_shift_id"
                                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                        <option v-for="n in props.all_line_shifts" :key="n.id" :value="n.id">
                                                            {{n.shift_date}}  ({{n.shift.name}})
                                                        </option>
                                                    </select>

                                                </div>
                                                <InputError class="mt-2" :message="form.errors.line_shift_id"/>
                                                <secondary-button @click="viewLineShiftDetail" class="mt-3">New (+)</secondary-button>
                                            </div>

                                        </div>



                                    </div>

                                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                                        <div>
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">Interlock Line Details</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Complete the details for the specif Interlock Line Item on the selected Shift.</p>
                                        </div>

                                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Job Card No</label>
                                                <input v-model="form.job_card_no" type="text" name="job_card_no" id="job_card_no" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                <InputError class="mt-2" :message="form.errors.job_card_no"/>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Production Model</label>


                                                <div v-if="props.all_production_models != null" class="">


                                                    <Combobox as="div" v-model="form.production_model_type_id">
                                                        <div class="relative">
                                                            <ComboboxInput
                                                                class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                                @change="modelTypeQuery = $event.target.value"
                                                                :display-value="(model) =>  props.all_production_models.find(element => element.id === model).model +' ('+ props.all_production_models.find(element => element.id === model).flex_type.name+')' "/>
                                                            <ComboboxButton
                                                                class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                                                                <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                                                            </ComboboxButton>

                                                            <ComboboxOptions
                                                                v-if="filteredModelTypes.length > 0"
                                                                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                                <ComboboxOption
                                                                    v-for="model in filteredModelTypes"
                                                                    :key="model.id" :value="model.id" as="template"
                                                                    v-slot="{ active, selected }">
                                                                    <li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-indigo-600 text-white' : 'text-gray-900']">
                                                                        <span :class="['block truncate', selected && 'font-semibold']">{{ model.model }} - {{model.flex_type.name}}</span>
                                                                        <span v-if="selected" :class="['absolute inset-y-0 right-0 flex items-center pr-4', active ? 'text-white' : 'text-indigo-600']">
                                                                        <CheckIcon class="h-5 w-5" aria-hidden="true"/>
                                                                        </span>
                                                                    </li>
                                                                </ComboboxOption>
                                                            </ComboboxOptions>
                                                        </div>
                                                    </Combobox>

                                                    <InputError class="mt-2" :message="form.errors.production_model_type_id"/>

                                                </div>
                                                <div v-else> null</div>

                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Interlock</label>

                                                <div v-if="filteredInterlockTypes.length !== 0" class="">
                                                    <select v-model="form.interlock_type_id"
                                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                        <option v-for="n in filteredInterlockTypes" :key="n.id" :value="n.id">
                                                            {{n.production_model.model}} ({{n.production_model.flex_type.name}})
                                                        </option>
                                                    </select>

                                                    <InputError class="mt-2" :message="form.errors.interlock_type_id"/>

                                                </div>
                                                <div v-else class="text-red-600">No interlock found linked to the Model. Please Link interlock or select another model to continue.</div>

                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Selected Shift Leader</label>

                                                <select v-model="form.shift_leader_id"
                                                        class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    <option v-for="n in all_staff_members" :key="n.id" :value="n.id">
                                                        {{n.first_name}}  {{n.last_name}}
                                                    </option>
                                                </select>

                                                <InputError class="mt-2" :message="form.errors.shift_leader_id"/>

                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Selected Operator</label>

                                                <select v-model="form.operator_id"
                                                        class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    <option v-for="n in all_staff_members" :key="n.id" :value="n.id">
                                                        {{n.first_name}}  {{n.last_name}}
                                                    </option>
                                                </select>

                                                <InputError class="mt-2" :message="form.errors.operator_id"/>

                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Selected Business unit</label>

                                                <select v-model="form.business_unit_id"
                                                        class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    <option v-for="n in all_business_units" :key="n.id" :value="n.id">
                                                        {{n.name}}
                                                    </option>
                                                </select>

                                                <InputError class="mt-2" :message="form.errors.business_unit_id"/>

                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Selected Assembly Line</label>

                                                <select v-model="form.assembly_line_id"
                                                        class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    <option v-for="n in all_assembly_lines" :key="n.id" :value="n.id">
                                                        {{n.name}}
                                                    </option>
                                                </select>

                                                <InputError class="mt-2" :message="form.errors.assembly_line_id"/>

                                            </div>

                                            <div v-if="filteredInterlockTypes.length !== 0" class="sm:col-span-6">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Linked Interlock Details </label>

                                                <div v-if="found_interlock != null">
                                                    <div v-if="found_interlock.model_type_id === form.production_model_type_id" class="ml-2 mt-2 text-sm">
                                                        <div> <span class="font-bold">Model: </span> <span> {{found_interlock.production_model.model}} ({{found_interlock.production_model.flex_type.name}})</span> </div>
                                                        <div> <span class="font-bold">Value: </span> <span> {{found_interlock.interlock_value}}</span> </div>
                                                        <div> <span class="font-bold">BOM: </span> <span> {{found_interlock.bom}}</span> </div>
                                                        <div> <span class="font-bold">Syspro: </span> <span> {{found_interlock.syspro_code}}</span> </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>


                                </div>

                                <div class="mt-6 flex items-center justify-end gap-x-6">
                                    <secondary-button @click="createInterlockLine"  class="mt-3">Create</secondary-button>
                                </div>
                            </form>
                        </div>


                    </div>

                </div>

                <SectionBorder/>

            </div>


        </div>
    </AppLayout>
</template>
