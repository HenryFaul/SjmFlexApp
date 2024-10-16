<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch, inject, onMounted} from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, useForm, usePage} from "@inertiajs/vue3";
import Chart from "../../Components/Chart.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import moment from 'moment';
import DownTimeModal from "@/Components/UI/DownTimeModal.vue";
import DefectModal from "@/Components/UI/DefectModal.vue";

const startDate = ref(new Date()); // Initialize start date
const endDate = ref(new Date()); // Initialize end date
const selectedFlexType = ref(2);
const selectedComponent = ref("Interlock");

const props = defineProps({
    chart:Object,
    chart2:Object,
    chart3:Object,
    chart4:Object
});
const filterCharts = () => {
    const formattedStartDate = moment(startDate.value).format('YYYY-MM-DD');
    const formattedEndDate = moment(endDate.value).format('YYYY-MM-DD');
    router.get('/dashboard', {
        component: selectedComponent.value,
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
                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">

                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Selected Component</label>
                        <div class="mt-2">

                            <select v-model="selectedComponent"
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
                                <option :key="'Ring'" :value="'Ring'">
                                    Ring
                                </option>
                                <option :key="'RingTube'" :value="'RingTube'">
                                    Ring Tube
                                </option>
                                <option :key="'Spring'" :value="'Spring'">
                                    Spring
                                </option>
                                <option :key="'Tubing'" :value="'Tubing'">
                                    Tubing
                                </option>
                                <option :key="'Grammage'" :value="'Grammage'">
                                    Grammage
                                </option>
                                <option :key="'Slitting'" :value="'Slitting'">
                                    Slitting
                                </option>
                            </select>

                        </div>
                    </div>

                </div>
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
                                            <label class="block text-sm font-medium leading-6 text-gray-900">End Date</label>
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
                                                :chart-id="'chart-0'"
                                                :title="'Planned vs actual'"
                                                :data="chart4"/>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div>
                                            <chart
                                                :chart-id="'chart-1'"
                                                :title="'Defects'"
                                                :data="chart2"/>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div>
                                            <chart
                                                :chart-id="'chart-2'"
                                                :title="'Downtime'"
                                                :data="chart3"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-12">
                                <div class="grid grid-cols-1  md:grid-cols-1">
                                    <div class="mt-12">
                                        <div>
                                            <chart
                                                :chart-id="'chart-3'"
                                                :title="'Assembly and Tubing PPM'"
                                                :data="chart"/>
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
