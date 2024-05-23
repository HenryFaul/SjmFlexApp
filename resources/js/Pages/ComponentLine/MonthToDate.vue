<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch, inject, onMounted} from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, useForm, usePage} from "@inertiajs/vue3";
import Chart from "../../Components/Chart.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import moment from 'moment';
import {CheckIcon, ChevronUpDownIcon, PaperClipIcon} from '@heroicons/vue/20/solid';
import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxLabel,
    ComboboxOption,
    ComboboxOptions,
} from '@headlessui/vue';
import InputError from '@/Components/InputError.vue';
import DownTimeModal from "@/Components/UI/DownTimeModal.vue";
import DefectModal from "@/Components/UI/DefectModal.vue";

const startDate = ref(new Date()); // Initialize start date
const endDate = ref(new Date()); // Initialize end date
const selectedFlexType = ref(2);

const props = defineProps({
    chart:Object,
    chart2:Object,
    chart3:Object
});
const filterCharts = () => {
    const formattedStartDate = moment(startDate.value).format('YYYY-MM-DD');
    const formattedEndDate = moment(endDate.value).format('YYYY-MM-DD');
    router.get('/interlock_line_graph/month_to_date', {
        start_date: formattedStartDate,
        end_date: formattedEndDate,
        flex_type: selectedFlexType.value,
    }, {
        preserveState: true, // Maintain other page state
        replace: true // Replace URL in history (like a full page reload)
    });
}
</script>

<template>
    <AppLayout title="InterLock Line">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Interlock Month To Date
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="m-3 p-3">
                            <div class="space-y-12">
                                <div class="grid grid-cols-4 pb-12 md:grid-cols-4">
                                    <div class="mt-3">
                                        <div>
                                            <label class="block text-sm font-medium leading-6 text-gray-900">Start Date</label>
                                            <VueDatePicker v-model="startDate" format="yyyy-MM-dd" style="width: 250px;" :teleport="true"></VueDatePicker>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div>
                                            <label class="block text-sm font-medium leading-6 text-gray-900">Start Date</label>
                                            <VueDatePicker v-model="endDate" format="yyyy-MM-dd" style="width: 250px;" :teleport="true"></VueDatePicker>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div>
                                            <label class="block text-sm font-medium leading-6 text-gray-900">Flex Type</label>
                                            <select v-model="selectedFlexType" class="input-filter-l block w-64 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option :value=2>Passenger</option>
                                                <option :value=3>Small Truck</option>
                                                <option :value=4>Large Truck</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div>
                                            <SecondaryButton ref="filterButton" class="m-1 mt-6" @click="filterCharts">
                                                Filter
                                            </SecondaryButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-12">
                                <div class="grid grid-cols-1  md:grid-cols-3">
                                    <div class="mt-3">
                                        <div>
                                            <chart
                                                :chart-id="'interlock-chart-0'"
                                                :title="'Interlock planned vs actual'"
                                                :data="chart"/>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div>
                                            <chart
                                                :chart-id="'interlock-chart-1'"
                                                :title="'Interlock forming defects'"
                                                :data="chart2"/>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div>
                                            <chart
                                                :chart-id="'interlock-chart-2'"
                                                :title="'Interlock forming downtime'"
                                                :data="chart3"/>
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
