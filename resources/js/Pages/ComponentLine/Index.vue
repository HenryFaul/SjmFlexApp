<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch} from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, useForm, usePage,Link} from "@inertiajs/vue3";
import {debounce, throttle} from 'lodash'
import PaginationModified from  "@/Components/UI/PaginationModified.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import DownTimeModal from "@/Components/UI/DownTimeModal.vue";
import DefectModal from "@/Components/UI/DefectModal.vue";

const props = defineProps({
    all_component_line_items:Object,
    filters: Object,
    component: String
});

const filterForm = useForm({
    component: props.component,
    searchName: props.filters.searchName ?? null,
    flexType: props.filters.flexType ?? null,
    field: props.filters.field ?? null,
    show: props.filters.show ?? 10,
    startDate: props.filters.startDate ?? null,
    endDate: props.filters.endDate ?? null
});

const startDate = ref(null); // Initialize start date
const endDate = ref(null); // Initialize end date

let filter = debounce(() => {
    filterForm.get(route('component_line.index', props.component), {
        preserveState: true,
        preserveScroll: true,
    });
}, 150);

let tableStats = ref("Showing page " + props.all_component_line_items.current_page + "  of " + props.all_component_line_items.total + " entries.");
watch(
    () => props.all_component_line_items,
    (newData) => {
        // Update table stats when new data is available
        if (newData) {
            tableStats.value = `Showing page ${newData.current_page} of ${newData.total} entries.`;
        }
    },
    { immediate: true } // Call the watcher immediately on component mount
);

let sort = (field) => {
    filterForm.field = field;
    filterForm.direction = filterForm.direction === 'asc' ? 'desc' : 'asc';
    filter();
}

watch(
    () => filterForm.searchName,
    (exampleField, prevExampleField) => {
        filter();
    }
)

watch(
    () => filterForm.show,
    (exampleField, prevExampleField) => {
        filter();
    }
)

const clear = () => {
    filterForm.searchName = null;
    filterForm.flexType = null;
    filterForm.endDate = null;
    filterForm.startDate = null;
    filterForm.show = 10;
    filter();
}

const edit = (id) => {
    //router.get('staff/'+id);
}

</script>

<template>
    <AppLayout title="">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                All {{component}} Lines
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-full mx-auto">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="m-2 p-2">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight"> {{component}} Line Data</h2>

                        <div class="mb-4 mt-5 flex flex-wrap items-center gap-4">
                            <input
                                type="search"
                                v-model.number="filterForm.searchName"
                                aria-label="Search"
                                placeholder="Search name or reg..."
                                class="block w-1/4 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />

                            <select
                                v-model="filterForm.flexType"
                                class="input-filter-l block w-1/4 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            >
                                <option :value="null">All</option>
                                <option value="2">Passenger</option>
                                <option value="3">Small Truck</option>
                                <option value="4">Large Truck</option>
                            </select>

                            <select
                                v-model="filterForm.show"
                                class="input-filter-l block w-1/6 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            >
                                <option :value=5>5</option>
                                <option :value=10>10</option>
                                <option :value=25>25</option>
                                <option :value=100>100</option>
                            </select>


                            <div class="flex w-1/2 gap-4">
                                <div class="flex flex-col w-full">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">Start Date</label>
                                    <VueDatePicker v-model="filterForm.startDate" format="yyyy-MM-dd" :teleport="true" />
                                </div>

                                <div class="flex flex-col w-full">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">End Date</label>
                                    <VueDatePicker v-model="filterForm.endDate" format="yyyy-MM-dd" :teleport="true" />
                                </div>
                            </div>

                            <secondary-button @click="filter" class="mt-3">Search</secondary-button>
                            <secondary-button @click="clear" class="mt-3 ml-1">Clear</secondary-button>
                        </div>


                        <div>

                            <div>

                            </div>



                            <div class="bg-white rounded-md shadow overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                    <thead class="bg-indigo-400">

                                    <tr class="font-bold ">

                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                            Shift Date
                                        </th>
                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">Shift Type</th>
                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">Model</th>
                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                            Product Capacity
                                        </th>
                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                            Product Plan
                                        </th>
                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                            Product Actual
                                        </th>
                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                            Daily Plan vs Actual %
                                        </th>
                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                           Defect Ex Qty (Kg)
                                        </th>
                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                            Defect Ex %
                                        </th>
                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                            Defect Inc Qty (Kg)
                                        </th>
                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                            Defect Inc %
                                        </th>
                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">

                                    <tr  v-for="(line_item, index) in all_component_line_items.data"
                                        :key="line_item.id" class="hover:bg-gray-100 focus-within:bg-gray-100 ">

                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{line_item.line_shift.shift_date}}
                                        </td>

                                        <td class="py-4 px-6 whitespace-nowrap">

                                            {{line_item.line_shift.shift.name}}
                                        </td>

                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{line_item.component.production_model.model}}
                                        </td>

                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{line_item.prod_capacity}}
                                        </td>

                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{line_item.prod_plan}}
                                        </td>

                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{line_item.prod_actual}}
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{Math.round(line_item.daily_plan_vs_actual)}}%
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{(line_item.total_defect_qty_conv_ex + line_item.total_defect_qty_ex).toFixed(2)}}
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{(line_item.total_defect_percent_ex * 100).toFixed(2)}} %
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{(line_item.total_defect_qty_conv_inc + line_item.total_defect_qty_inc).toFixed(2)}}
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{(line_item.total_defect_percent_inc * 100).toFixed(2)}} %
                                        </td>

                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <Link class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :href="`/component_line/${component}/${line_item.id}`" >View trans</Link>

                                        </td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="ml-3 mt-2">
                                {{ tableStats }}
                            </div>
                        </div>
                        <div v-if="all_component_line_items.data.length" class="w-full flex justify-center mt-5 mb-4">

                            <PaginationModified :links="all_component_line_items.links"/>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </AppLayout>
</template>
