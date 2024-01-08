<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch, inject} from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, useForm, usePage} from "@inertiajs/vue3";
import InputError from '@/Components/InputError.vue';
import DownTimeModal from "@/Components/UI/DownTimeModal.vue";
import DefectModal from "@/Components/UI/DefectModal.vue";
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
    interlock_line:Object,
    all_staff_members:Object,
    all_business_units:Object,
    all_assembly_lines:Object,
    down_times:Object,
    defects:Object
});

//'job_card_no','production_model_type_id','shift_leader_id','operator_id','business_unit_id','assembly_line_id'

//'line_shift_id', 'job_card_no', 'production_model_type_id', 'shift_leader_id', 'operator_id', 'business_unit_id', 'assembly_line_id', 'prod_capacity', 'prod_plan', 'prod_actual', 'prod_return',
//'prod_salvage', 'prod_qty_loss', 'prod_percent_loss', 'work_time', 'work_down_time', 'man_input', 'total_defect_qty_inc',
 //   'total_defect_qty_ex', 'total_defect_percent_inc', 'total_defect_percent_ex'
let interlockForm = useForm({

    line_shift_id:props.interlock_line.line_shift_id,
    job_card_no:props.interlock_line.job_card_no,
    production_model_type_id:  props.interlock_line.production_model_type_id,
    interlock_type_id:  props.interlock_line.interlock_type_id,
    shift_leader_id: props.interlock_line.shift_leader_id,
    operator_id:props.interlock_line.operator_id,
    business_unit_id: props.interlock_line.business_unit_id,
    assembly_line_id:props.interlock_line.assembly_line_id,
    prod_plan:props.interlock_line.prod_plan,
    prod_actual:props.interlock_line.prod_actual,
    man_input:props.interlock_line.man_input,

});

/*
const updateInterlockLine= () => {

    alert('Updateing')

    interlockForm.put(route('interlock_line.update', props.found_interlock.id),
        {
            preserveScroll: true,
            onSuccess: () => {
                alert('Updated')
            },
            onError: (error) => {
                alert('Something went wrong')
                console.log(error)
            }
        }
    );
}
*/


const updateInterlockLine = () => {
    interlockForm.put(route('interlock_line.update', props.interlock_line.id),
        {
            preserveScroll: true,
            onSuccess: () => {
                alert('Updated')
            },
        }
    );
}




//const roles_permissions = computed(() => usePage().props.roles_permissions);
//const can_manage_users = computed(() => usePage().props.roles_permissions.permissions.includes("manage_users"));

const viewDownTimeModal = ref(false);

const closeDownTime = () => {
    viewDownTimeModal.value = false;
};

const viewDownTimeDetail = () => {
    viewDownTimeModal.value = true;
};


const viewDefectModal = ref(false);

const closeDefect = () => {
    viewDefectModal.value = false;
};

const viewDefectDetail = () => {
    viewDefectModal.value = true;
};



/*
const createInterlockLine = () => {

    form.post(route('interlock_line.store'), {
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
*/
const people = [
    { name: 'Lindsay Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member' },
]
</script>

<template>
    <AppLayout title="InterLock Line">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Interlock Line / <span class="text-indigo-400">{{ interlock_line.id }}</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div>
                        <div class="m-3 p-3">
                            <form>
                                <div class="text-lg mb-4 text-indigo-400">Interlock Line</div>
                                <div class="space-y-12">

                                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                                        <div>
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">Interlock Line Details</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Details for the specific line.</p>
                                        </div>

                                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">


                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Shift Type</label>
                                                <div class="mt-2">
                                                    {{interlock_line.line_shift.shift.name}}
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label  class="block text-sm font-medium leading-6 text-gray-900">Shift Date</label>
                                                <div class="mt-2">
                                                    {{interlock_line.line_shift.shift_date}}
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label  class="block text-sm font-medium leading-6 text-gray-900">Model</label>
                                                <div class="mt-2">
                                                    {{interlock_line.production_model.model}} ({{interlock_line.production_model.flex_type.name}})
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label  class="block text-sm font-medium leading-6 text-gray-900">Related Interlock</label>
                                                <div class="mt-2">
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                                        <div v-if="interlock_line.interlock">
                                                            <div> <span class="font-bold">Model: </span> <span> {{interlock_line.interlock.production_model.model}} </span> </div>
                                                            <div> <span class="font-bold">Value: </span> <span>{{interlock_line.interlock.interlock_value}} </span> </div>
                                                            <div> <span class="font-bold">BOM: </span> <span>{{interlock_line.interlock.bom}} </span> </div>
                                                            <div> <span class="font-bold">Syspro: </span> <span>{{interlock_line.interlock.syspro_code}} </span> </div>
                                                        </div>

                                                        <div v-else>
                                                            <p class="font-bold text-red-600">No related interlock found. Please link to continue.</p>
                                                        </div>

                                                        <InputError class="mt-2" :message="interlockForm.errors.interlock_type_id"/>


                                                    </dd>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Business Unit</label>
                                                <div class="mt-2">

                                                    <div class="">
                                                        <select v-model="interlockForm.business_unit_id"
                                                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                            <option v-for="n in props.all_business_units" :key="n.id" :value="n.id">
                                                                {{n.name}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <InputError class="mt-2" :message="interlockForm.errors.business_unit_id"/>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Assembly Line</label>
                                                <div class="mt-2">

                                                    <div class="">
                                                        <select v-model="interlockForm.assembly_line_id"
                                                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                            <option v-for="n in props.all_assembly_lines" :key="n.id" :value="n.id">
                                                                {{n.name}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <InputError class="mt-2" :message="interlockForm.errors.business_unit_id"/>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Shift Leader</label>
                                                <div class="mt-2">

                                                    <div class="">
                                                        <select v-model="interlockForm.shift_leader_id"
                                                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                            <option v-for="n in props.all_staff_members" :key="n.id" :value="n.id">
                                                                {{n.first_name}} {{n.last_name}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <InputError class="mt-2" :message="interlockForm.errors.business_unit_id"/>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Operator</label>
                                                <div class="mt-2">

                                                    <div class="">
                                                        <select v-model="interlockForm.operator_id"
                                                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                            <option v-for="n in props.all_staff_members" :key="n.id" :value="n.id">
                                                                {{n.first_name}} {{n.last_name}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <InputError class="mt-2" :message="interlockForm.errors.business_unit_id"/>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Product Plan</label>
                                                <div class="mt-2">

                                                    <div class="">
                                                        <input v-model="interlockForm.prod_plan" type="number"
                                                               class="block w-32 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                                        <InputError class="mt-2" :message="interlockForm.errors.prod_plan"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Product Actual</label>
                                                <div class="mt-2">

                                                    <div class="">
                                                        <input v-model="interlockForm.prod_actual" type="number"
                                                               class="block w-32 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                                        <InputError class="mt-2" :message="interlockForm.errors.prod_actual"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Man Input</label>
                                                <div class="mt-2">

                                                    <div class="">
                                                        <input v-model="interlockForm.man_input" type="number"
                                                               class="block w-32 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>

                                                        <InputError class="mt-2" :message="interlockForm.errors.man_input"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-sm font-medium leading-6 text-gray-900">Job Card</label>
                                                <div class="mt-2">
                                                    <input v-model="interlockForm.job_card_no" type="text"
                                                           class="block w-48 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>

                                                    <InputError class="mt-2" :message="interlockForm.errors.job_card_no"/>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-6">
                                                <div class="mt-6 flex items-center justify-end gap-x-6">
                                                    <secondary-button @click.prevent="updateInterlockLine" class="mt-3">Update</secondary-button>
                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                                        <div>
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">Calculated Values</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Values calculated from the capturing.</p>
                                        </div>


                                        <div class="col-span-2">

                                            <div class="px-4 sm:px-6 lg:px-8">
                                                <div class="sm:flex sm:items-center">
                                                    <div class="sm:flex-auto">
                                                        <h1 class="text-base font-semibold leading-6 text-gray-900">Interlock Line</h1>
                                                        <p class="mt-2 text-sm text-gray-700">Interlock Line Calculated Values</p>
                                                    </div>
                                                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                                        <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Export</button>
                                                    </div>
                                                </div>
                                                <div class="mt-8 flow-root">
                                                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                                            <table class="min-w-full divide-y divide-gray-300">
                                                                <thead>
                                                                <tr>
                                                                    <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Attribute</th>
                                                                    <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Value</th>
                                                                    <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Attribute</th>
                                                                    <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Value</th>

                                                                </tr>
                                                                </thead>
                                                                <tbody class="divide-y divide-gray-200 bg-white">

                                                                <tr>
                                                                    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Defect KG Inc</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.total_defect_kg_inc}}</td>
                                                                    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Defect KG Ex</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.total_defect_kg_ex}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Capacity</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.prod_capacity}}</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Return</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.prod_return}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Salvage</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.prod_salvage}}</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Loss</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.prod_qty_loss}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Loss %</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.prod_percent_loss}}</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Sum Down Time</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.sum_down_time}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Work Time</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.work_time}}</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Work Down Time</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.work_down_time}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Man Input</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.man_input}}</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Defect Pieces Inc</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.total_defect_qty_inc}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Converted Pieces Inc</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.total_defect_qty_conv_inc}}</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Converted Pieces Ex</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.total_defect_qty_conv_ex}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Defect Pieces Ex</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.total_defect_qty_ex}}</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Converted Pieces Ex</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.total_defect_kg_ex}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Total Inc</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.total_defect_percent_inc}} %</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Total Ex</td>
                                                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{interlock_line.total_defect_percent_ex}} %</td>
                                                                </tr>


                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>


                            </form>
                        </div>


                    </div>

                </div>

                <br>

                <div v-if="interlock_line.interlock" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div>
                        <DownTimeModal :show="viewDownTimeModal" :line_shift_id="interlock_line.line_shift_id" :interlock_line_id="interlock_line.id"  @close="closeDownTime"/>

                        <div class="m-3 p-3">

                            <div class="text-lg mb-4 text-indigo-400">Interlock Down time</div>

                            <div class="px-4 sm:px-6 lg:px-8">
                                <div class="sm:flex sm:items-center">
                                    <div class="sm:flex-auto">
                                        <h1 class="text-base font-semibold leading-6 text-gray-900">All Down times</h1>
                                        <p class="mt-2 text-sm text-gray-700">List of all down times loaded to the specific interlock.</p>
                                    </div>
                                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                        <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" @click="viewDownTimeDetail">Add down time</button>
                                    </div>
                                </div>
                                <div class="mt-8 flow-root">
                                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead>
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Type</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Value</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Comment</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                        <span class="sr-only">Edit</span>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200">
                                                <tr v-for="down_time in down_times" :key="down_time.id">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{down_time.down_time_type.type}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{down_time.value}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{down_time.comment}}</td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                        <a href="#" class="text-indigo-600 hover:text-indigo-900"
                                                        >Delete<span class="sr-only"></span></a
                                                        >
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>


                </div>

                <br>

                <div v-if="interlock_line.interlock"  class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div>
                        <DefectModal :show="viewDefectModal" :line_shift_id="interlock_line.line_shift_id"
                                     :interlock_line_id="interlock_line.id" :production_model_type_id="interlock_line.production_model_type_id" :interlock_type_id="interlock_line.interlock_type_id"  @close="closeDefect"> </DefectModal>
                        <div class="m-3 p-3">

                            <div class="text-lg mb-4 text-indigo-400">Interlock Defect</div>

                            <div class="px-4 sm:px-6 lg:px-8">
                                <div class="sm:flex sm:items-center">
                                    <div class="sm:flex-auto">
                                        <h1 class="text-base font-semibold leading-6 text-gray-900">All Defects</h1>
                                        <p class="mt-2 text-sm text-gray-700">List of all defects loaded to the specific interlock.</p>
                                    </div>
                                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                        <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" @click="viewDefectDetail">Add defect</button>
                                    </div>
                                </div>
                                <div class="mt-8 flow-root">
                                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead>
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Group</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Basis</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Included</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Value</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Salvage</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Comment</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                        <span class="sr-only">Edit</span>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200">
                                                <tr v-for="defect in defects" :key="defect.id">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{defect.defect_group.value}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{defect.defect_type.value}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{defect.defect_basis.value}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                        <div v-if="defect.is_inc">Yes</div>
                                                        <div v-else>No</div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{defect.value}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{defect.salvage_value}}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{defect.comment}}</td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                        <a href="#" class="text-indigo-600 hover:text-indigo-900"
                                                        >Delete<span class="sr-only"></span></a
                                                        >
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>

                </div>

            </div>


        </div>
    </AppLayout>
</template>
