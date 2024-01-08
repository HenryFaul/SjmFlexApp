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

const props = defineProps({
    chart:Object,
    chart2:Object,
    chart3:Object,
    flex_1_data:Object,
    flex_2_data:Object,
    flex_3_data:Object,
    flex_4_data:Object
});

let interlockForm = useForm({



});

const transactions = [
    {
        id: 'AAPS0L',
        company: 'Chase & Co.',
        share: 'CAC',
        commission: '+$4.37',
        price: '$3,509.00',
        quantity: '12.00',
        netAmount: '$4,397.00',
    },

    {
        id: 'AAPS0L2',
        company: 'Chase & Co.',
        share: 'CAC',
        commission: '+$4.37',
        price: '$3,509.00',
        quantity: '12.00',
        netAmount: '$4,397.00',
    },
    // More transactions...
]


</script>

<template>
    <AppLayout title="InterLock Line">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Interlock Month To Date
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div>
                        <div class="m-3 p-3">
                                <div class="text-lg mb-4 text-indigo-400">Interlock Month To Date Graphs</div>
                                <div class="space-y-12">

                                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">


                                        <div>
                                            <apexchart :width="chart.width" :height="chart.height" :type="chart.type" :options="chart.options" :series="chart.series" />

                                        </div>

                                        <div>
                                            <apexchart :width="chart2.width" :height="chart2.height" :type="chart2.type" :options="chart2.options" :series="chart2.series" />
                                        </div>

                                        <div>
                                            <apexchart :width="chart3.width" :height="chart3.height" :type="chart3.type" :options="chart3.options" :series="chart3.series" />
                                        </div>

                                    </div>


                                </div>

                        </div>


                    </div>

                </div>

                <br>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div>

                        <div class="m-3 p-3">

                            <div class="text-lg mb-4 text-indigo-400">Interlock Month To Date Data Summary</div>
                            <div class="space-y-12">

                                <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-1">


                                    <div class="px-4 sm:px-6 lg:px-8">
                                        <div class="sm:flex sm:items-center">
                                            <div class="sm:flex-auto">
                                                <h1 class="text-base font-semibold leading-6 text-gray-900">Passenger</h1>
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
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_total_defect_kg_inc_2"]}}</td>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Defect KG Ex</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_total_defect_kg_ex_2"]}}</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Capacity</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_prod_capacity_2"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Return</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_prod_return_2"]}}</td>
                                                        </tr>


                                                        <tr>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Sum Down Time</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_work_down_time_2"]}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Work Time</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_work_time_2"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Work Down Time</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_prod_actual_2"]}}</td>
                                                        </tr>


                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Man Input</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_man_input_2"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Defect Pieces Inc</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_prod_actual_2"]}}</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Converted Pieces Inc</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_total_defect_qty_conv_inc_2"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Converted Pieces Ex</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_total_defect_qty_conv_ex_2"]}}</td>
                                                        </tr>


                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Defect Pieces Ex</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_total_defect_qty_inc_2"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Defect Pieces Inc</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_total_defect_qty_ex_2"]}}</td>
                                                        </tr>


                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Total Inc</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_total_defect_percent_inc_2"]}} %</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Total Ex</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_2_data["sum_total_defect_percent_ex_2"]}} %</td>
                                                        </tr>


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-4 sm:px-6 lg:px-8">
                                        <div class="sm:flex sm:items-center">
                                            <div class="sm:flex-auto">
                                                <h1 class="text-base font-semibold leading-6 text-gray-900">Small Truck</h1>
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
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_total_defect_kg_inc_3"]}}</td>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Defect KG Ex</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_total_defect_kg_ex_3"]}}</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Capacity</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_prod_capacity_3"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Return</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_prod_return_3"]}}</td>
                                                        </tr>


                                                        <tr>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Sum Down Time</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_work_down_time_3"]}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Work Time</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_work_time_3"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Work Down Time</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_prod_actual_3"]}}</td>
                                                        </tr>


                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Man Input</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_man_input_3"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Defect Pieces Inc</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_prod_actual_3"]}}</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Converted Pieces Inc</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_total_defect_qty_conv_inc_3"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Converted Pieces Ex</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_total_defect_qty_conv_ex_3"]}}</td>
                                                        </tr>


                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Defect Pieces Ex</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_total_defect_qty_inc_3"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Defect Pieces Inc</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_total_defect_qty_ex_3"]}}</td>
                                                        </tr>


                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Total Inc</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_total_defect_percent_inc_3"]}} %</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Total Ex</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_3_data["sum_total_defect_percent_ex_3"]}} %</td>
                                                        </tr>


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-4 sm:px-6 lg:px-8">
                                        <div class="sm:flex sm:items-center">
                                            <div class="sm:flex-auto">
                                                <h1 class="text-base font-semibold leading-6 text-gray-900">Large Truck</h1>
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
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_total_defect_kg_inc_4"]}}</td>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Defect KG Ex</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_total_defect_kg_ex_4"]}}</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Capacity</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_prod_capacity_4"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Return</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_prod_return_4"]}}</td>
                                                        </tr>


                                                        <tr>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Sum Down Time</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_work_down_time_4"]}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Work Time</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_work_time_4"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Work Down Time</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_prod_actual_4"]}}</td>
                                                        </tr>


                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Man Input</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_man_input_4"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Defect Pieces Inc</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_prod_actual_4"]}}</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Converted Pieces Inc</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_total_defect_qty_conv_inc_4"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Converted Pieces Ex</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_total_defect_qty_conv_ex_4"]}}</td>
                                                        </tr>


                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Defect Pieces Ex</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_total_defect_qty_inc_4"]}}</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Defect Pieces Inc</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_total_defect_qty_ex_4"]}}</td>
                                                        </tr>


                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Total Inc</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_total_defect_percent_inc_4"]}} %</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">Total Ex</td>
                                                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{flex_4_data["sum_total_defect_percent_ex_4"]}} %</td>
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

                <br>



            </div>


        </div>
    </AppLayout>
</template>
