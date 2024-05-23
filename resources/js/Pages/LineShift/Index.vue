<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch} from 'vue';
import {router, useForm, usePage,Link} from "@inertiajs/vue3";
import {debounce, throttle} from 'lodash'
import PaginationModified from  "@/Components/UI/PaginationModified.vue";
import LineShiftModal from "../../Components/UI/LineShiftModal.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";


const props = defineProps({
    line_shifts:Object,
    filters: Object,
});

const filterForm = useForm({
    searchName: props.filters.searchName ?? null,
    isActive: props.filters.isActive ?? null,
    field: props.filters.field ?? null,
    direction: props.filters.direction ?? "asc",
    show: props.filters.show ?? 10,
});


let tableStats = ref("Showing page " + props.line_shifts.current_page + "  of " + props.line_shifts.total + " entries.");

let filter = debounce(() => {

    filterForm.get(
        route('line_shift.index'),
        {
            preserveState: true,
            preserveScroll: true,
        },
    )
},150);

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
    filterForm.searchName = null
    filterForm.isActive = null
    filter()
}

const viewLineShiftModal = ref(false);

const closeLineShiftModal = () => {
    viewLineShiftModal.value = false;
};

const viewLineShiftDetail = () => {
    viewLineShiftModal.value = true;
};
</script>

<template>
    <AppLayout title="Line Shift">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Line Shift
            </h2>
        </template>
        <LineShiftModal :show="viewLineShiftModal" @close="closeLineShiftModal"/>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="m-2 p-2">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Line Shift</h2>
                        <secondary-button @click="viewLineShiftDetail" class="mt-3">New (+)</secondary-button>
                        <div class="mb-4 mt-5">
                            <input type="search" v-model.number="filterForm.searchName" aria-label="Search"
                                   placeholder="Search name or reg..."
                                   class="block w-3/12 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>

                            <div class="mt-2">

                                <select v-model="filterForm.isActive"
                                        class="input-filter-l block w-3/12 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                                    <option :value="null">All</option>
                                    <option value="active">Active Only</option>
                                    <option value="inactive">Inactive Only</option>

                                </select>

                            </div>
                            <div class="mt-2">

                                <select v-model="filterForm.show"
                                        class="input-filter-l block w-1/12 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                                    <option :value=5>5</option>
                                    <option :value=10>10</option>
                                    <option :value=25>25</option>
                                    <option :value=100>100</option>

                                </select>

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
                                    <tr class="text-left font-bold">
                                        <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                            <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('shift_date')">Shift Date

                                            <svg v-if="filterForm.field === 'shift_date' && filterForm.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                              <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                            </svg>

                                            <svg v-if="filterForm.field === 'shift_date' && filterForm.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                              <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                            </svg>
                                            </span>
                                        </th>
                                        <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">Shift type</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">



                                    <tr  v-for="(lineShift, index) in line_shifts.data"
                                         :key="lineShift.id" class="hover:bg-gray-100 focus-within:bg-gray-100 ">

                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{ lineShift.shift_date }}
                                        </td>

                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{ lineShift.shift.name }}
                                        </td>

<!--                                        <td class="py-4 px-6 whitespace-nowrap">-->
<!--                                            <Link class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :href="route('staff_member.show',staff.id)">View</Link>-->
<!--                                        </td>-->

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="ml-3 mt-2">
                                {{ tableStats }}
                            </div>
                        </div>
                        <div v-if="line_shifts.data.length" class="w-full flex justify-center mt-5 mb-4">

                            <PaginationModified :links="line_shifts.links"/>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </AppLayout>
</template>
