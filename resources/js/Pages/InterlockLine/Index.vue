<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch} from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, useForm, usePage,Link} from "@inertiajs/vue3";
import {debounce, throttle} from 'lodash'
import PaginationModified from  "@/Components/UI/PaginationModified.vue";


const props = defineProps({
    all_interlock_line_items:Object,
    filters: Object,
});


const filterForm = useForm({
    searchName: props.filters.searchName ?? null,
    isActive: props.filters.isActive ?? null,
    field: props.filters.field ?? null,
    show: props.filters.show ?? 10,

});




let tableStats = ref("Showing page " + props.all_interlock_line_items.current_page + "  of " + props.all_interlock_line_items.total + " entries.");

let filter = debounce(() => {

    filterForm.get(
        route('staff_member.index'),
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


const edit = (id) => {
    //router.get('staff/'+id);
}


</script>

<template>
    <AppLayout title="Staff">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                All Interlock Lines
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="m-2 p-2">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Interlock Line Data</h2>

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

                                        <th scope="col" class="w-2/12 py-4 px-6 text-xs font-semibold tracking-wider text-left text-white uppercase">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">

                                    <tr  v-for="(line_item, index) in all_interlock_line_items.data"
                                        :key="line_item.id" class="hover:bg-gray-100 focus-within:bg-gray-100 ">

                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{line_item.line_shift.shift_date}}
                                        </td>

                                        <td class="py-4 px-6 whitespace-nowrap">

                                            {{line_item.line_shift.shift.name}}
                                        </td>

                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{line_item.production_model.model}}
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
                                            <Link class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :href="route('interlock_line.show',line_item.id)" >View trans</Link>

                                        </td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="ml-3 mt-2">
                                {{ tableStats }}
                            </div>
                        </div>
                        <div v-if="all_interlock_line_items.data.length" class="w-full flex justify-center mt-5 mb-4">

                            <PaginationModified :links="all_interlock_line_items.links"/>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </AppLayout>
</template>
