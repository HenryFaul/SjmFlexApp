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
    all_components:Object,
});
const selectedFlexType = ref(2);
const selectedComponent = ref(null);
let form = useForm({
    line_shift_id:null,
    job_card_no:null,
    production_model_type_id:1,
    component_id:-1,
    shift_leader_id:1,
    operator_id:1,
    business_unit_id:1,
    assembly_line_id:1,
    component:null,
    prod_plan:0,
    prod_actual:0,
    man_input: 0.0
});

const reset = () => {
        form.line_shift_id=null;
        form.job_card_no=null;
        form.production_model_type_id=1;
        form.component_id=1;
        form.shift_leader_id=1;
        form.operator_id=1;
        form.business_unit_id=1;
        form.assembly_line_id=1;
        form.component=null;
};

let modelTypeQuery = ref('');

const filteredModelTypes = computed(() => {
    return modelTypeQuery.value === ''
        ? props.all_production_models.filter((production_model) => {
            return (
                production_model.flex_type_id === selectedFlexType.value &&
                production_model.components.some(component => component.component === selectedComponent.value)
            );
        })
        : props.all_production_models.filter((production_model) => {
            return (
                production_model.model.toLowerCase().includes(modelTypeQuery.value.toLowerCase()) &&
                production_model.flex_type_id === selectedFlexType.value &&
                production_model.components.some(component => component.component === selectedComponent.value)
            );
        });
});

let componentTypeQuery = ref('');

const filteredComponentTypes = computed(() =>
    componentTypeQuery.value === ''
        ? props.all_components.filter((component) => {
            return component.component === form.component
        }).filter((component) => {
            return  component.model_type_id === form.production_model_type_id;
        })
        : props.all_components.filter((component) => {
            return component.component === form.component
        }).filter((component) => {
            return component.production_model.model.toLowerCase().includes(modelTypeQuery.value.toLowerCase());
        }).filter((component) => {
            return component.model_type_id === form.production_model_type_id;
        })
);


let found_component = computed(() => props.all_components.length === 0 || form.component_id === -1 ? null :  props.all_components.find(element => element.id === form.component_id));



const viewLineShiftModal = ref(false);

const closeLineShiftModal = () => {
    viewLineShiftModal.value = false;
};

const viewLineShiftDetail = () => {
    viewLineShiftModal.value = true;
};

watch(filteredComponentTypes, (newVal) => {
    if (newVal.length > 0) {
        form.component_id = newVal[0].id;
    }
}, { immediate: true });

watch(() => form.component, (newVal) => {
    selectedComponent.value = newVal;
    form.line_shift_id=null;
    form.production_model_type_id=1;
    form.component_id=1;
}, { immediate: true });

const createComponentLine = () => {
    form.post('/component_line/'+form.component, {
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
</script>

<template>
    <AppLayout title="Create Component Line">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New {{form.component}} Line
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div>

                        <LineShiftModal :show="viewLineShiftModal" @close="closeLineShiftModal"/>

                        <div class="m-3 p-3">
                            <form>
                                <div class="text-lg mb-4 text-indigo-400">{{form.component}} Line</div>
                                <div class="space-y-12">
                                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                                        <div>
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">Component</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Select relevant component/ line/ type /mode.</p>
                                            <p class="mt-2 text-sm leading-6 text-gray-600">The Details below are linked to the specific component.</p>
                                        </div>

                                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Selected Component</label>
                                                <div class="mt-2">

                                                    <select v-model="form.component"
                                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                        <option :key="'Interlock'" :value="'Interlock'">
                                                            Interlock
                                                        </option>
                                                        <option :key="'Braiding'" :value="'Braiding'">
                                                            Braiding
                                                        </option>
                                                        <option :key="'Knitting'" :value="'Knitting'">
                                                            Knitting
                                                        </option>
                                                        <option :key="'Tubing'" :value="'Tubing'">
                                                            Tubing
                                                        </option>
                                                        <option :key="'Assembly'" :value="'Assembly'">
                                                            Assembly
                                                        </option>
                                                        <option :key="'Grammage'" :value="'Grammage'">
                                                            Grammage
                                                        </option>
                                                        <option :key="'Slitting'" :value="'Slitting'">
                                                            Slitting
                                                        </option>
                                                    </select>

                                                </div>
                                                <InputError class="mt-2" :message="form.errors.component"/>
                                            </div>

                                        </div>



                                    </div>
                                    <div v-if="form.component" class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
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

                                    <div v-if="form.component" class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                                        <div>
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">{{form.component}} Line Details</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Complete the details for the specif {{form.component}} Line Item on the selected Shift.</p>
                                        </div>

                                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Job Card No</label>
                                                <input v-model="form.job_card_no" type="text" name="job_card_no" id="job_card_no" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                <InputError class="mt-2" :message="form.errors.job_card_no"/>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Flex Type</label>
                                                <select v-model="selectedFlexType" class="input-filter-l block w-64 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option :value=2>Passenger</option>
                                                    <option :value=3>Small Truck</option>
                                                    <option :value=4>Large Truck</option>
                                                </select>
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
                                                <label class="block text-sm font-medium leading-6 text-gray-900">{{form.component}}</label>

                                                <div v-if="filteredComponentTypes.length !== 0" class="">
                                                    <select v-model="form.component_id"
                                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                        <option v-for="n in filteredComponentTypes" :key="n.id" :value="n.id">
                                                            {{n.production_model.model}} ({{n.production_model.flex_type.name}})
                                                        </option>
                                                    </select>

                                                    <InputError class="mt-2" :message="form.errors.component_id"/>

                                                </div>
                                                <div v-else class="text-red-600">No {{ form.component }} found linked to the Model. Please select another model to continue.</div>

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

                                            <div v-if="form.component === 'Spring'" class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Corr</label>
                                                <input v-model="form.corr" type="number" name="corr" id="corr" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                <InputError class="mt-2" :message="form.errors.corr"/>
                                            </div>

                                            <div class="sm:col-span-2">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Product Plan</label>
                                                <div class="mt-2">

                                                    <div class="">
                                                        <input v-model="form.prod_plan" type="number"
                                                               class="block w-32 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                                        <InputError class="mt-2" :message="form.errors.prod_plan"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-2">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Product Actual</label>
                                                <div class="mt-2">

                                                    <div class="">
                                                        <input v-model="form.prod_actual" type="number"
                                                               class="block w-32 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                                        <InputError class="mt-2" :message="form.errors.prod_actual"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-2">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Man Input</label>
                                                <div class="mt-2">

                                                    <div class="">
                                                        <input v-model="form.man_input" type="number"
                                                               class="block w-32 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>

                                                        <InputError class="mt-2" :message="form.errors.man_input"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div v-if="filteredComponentTypes.length !== 0" class="sm:col-span-6">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Linked
                                                    {{ form.component }} Details </label>

                                                <div v-if="found_component != null">
                                                    <div v-if="found_component.model_type_id === form.production_model_type_id" class="ml-2 mt-2 text-sm">
                                                        <div> <span class="font-bold">Model: </span> <span> {{found_component.production_model.model}} ({{found_component.production_model.flex_type.name}})</span> </div>
                                                        <div> <span class="font-bold">Value: </span> <span> {{found_component.component_value}}</span> </div>
                                                        <div> <span class="font-bold">BOM: </span> <span> {{found_component.bom}}</span> </div>
                                                        <div> <span class="font-bold">Syspro: </span> <span> {{found_component.syspro_code}}</span> </div>
                                                        <div> <span class="font-bold">Component Type: </span> <span> {{found_component.component_type}}</span> </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>


                                </div>

                                <div class="mt-6 flex items-center justify-end gap-x-6">
                                    <secondary-button @click="createComponentLine"  class="mt-3">Create</secondary-button>
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
