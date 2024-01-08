<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch} from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, useForm, usePage} from "@inertiajs/vue3";
import Pagination from '@/Components/UI/Pagination.vue'
import ProductionModelModal from "@/Components/UI/ProductionModelModal.vue";
import {debounce, throttle} from 'lodash'
import {Inertia} from '@inertiajs/inertia'
import CustomPagination from "@/Components/UI/CustomPagination.vue";
import PaginationModified from  "@/Components/UI/PaginationModified.vue";


const props = defineProps({
    production_models: Object,
    filters: Object,
    flex_types: Object,
});
const permissions = computed(() => usePage().props.permissions)


const filterForm = useForm({
    prodName: props.filters.prodName ?? null,
    isActive: props.filters.isActive ?? null,
    field: props.filters.field ?? null,
    direction: props.filters.direction ?? null,
    show: props.filters.show ?? 10,

})

let curProdModel = ref(null);
let showModel = ref(false);

let tableStats = ref("Showing page " + props.production_models.current_page + "  of " + props.production_models.total + " entries.");

let filter = debounce(() => {

    filterForm.get(
        route('production-model.index'),
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
    () => filterForm.prodName,
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
    filterForm.prodName = null
    filterForm.isActive = null
    filter()
}


const edit = (id) => {

    curProdModel.value = null;

    if (props.production_models.data.length >= id) {
        curProdModel.value = props.production_models.data[id];
        if (curProdModel.value !== "") {

            showModel.value = true;
        }
    }
}
const completeFunction = (val) => {
    showModel.value = false;
};


</script>

<template>
    <AppLayout title="DataImports">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Production Models
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="m-2 p-2">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Production Model Data</h2>

                        <div class="mb-4 mt-5">
                            <input type="search" v-model.number="filterForm.prodName" aria-label="Search"
                                   placeholder="Search Name..."
                                   class="block w-3/12 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>

                            <div class="mt-2">

                                <select v-model="filterForm.isActive"
                                        class="input-filter-l block w-3/12 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                                    <option :value="null">All Models</option>
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

                            <div v-if="curProdModel != null">
                                <ProductionModelModal :ProductionModel="curProdModel" :showModelParent="showModel"
                                                      :completeFunction="completeFunction" :flex_types="flex_types"/>
                            </div>


                            <div class="bg-white rounded-md shadow overflow-x-auto">
                                <table class="w-full whitespace-nowrap">
                                    <thead>
                                    <tr class="text-left font-bold">
                                        <th class="pb-4 pt-6 px-6">

                                            <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('model_name')">Name

                                            <svg v-if="filterForm.field === 'model_name' && filterForm.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                              <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                            </svg>

                                            <svg v-if="filterForm.field === 'model_name' && filterForm.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                              <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                            </svg>
                                            </span>


                                        </th>
                                        <th class="pb-4 pt-6 px-6">FlexType</th>
                                        <th class="pb-4 pt-6 px-6">Ref Id</th>
                                        <th class="pb-4 pt-6 px-6">IsActive</th>
                                        <th class="pb-4 pt-6 px-6">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr @click=edit(index) v-for="(production_model, index) in production_models.data"
                                        :key="production_model.id" class="hover:bg-gray-100 focus-within:bg-gray-100 ">
                                        <td class="border-t pb-4 pt-6 px-6">
                                            {{ production_model.model_name }}
                                        </td>

                                        <td class="border-t pb-4 pt-6 px-6">
                                            {{ production_model.flex_type.flex_name }}
                                        </td>
                                        <td class="border-t pb-4 pt-6 px-6">
                                            {{ production_model.flex_type.reference_id }}
                                        </td>
                                        <td class="border-t pb-4 pt-6 px-6">

                                            <div v-if="production_model.is_active ===1">

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>

                                            </div>
                                            <div v-else>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </div>


                                        </td>

                                        <td class="border-t pb-4 pt-6 px-6">
                                            <secondary-button @click=edit(index)>Edit</secondary-button>
                                        </td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="ml-3 mt-2">
                                {{ tableStats }}
                            </div>
                        </div>
                        <div v-if="production_models.data.length" class="w-full flex justify-center mt-5 mb-4">

                            <PaginationModified :links="production_models.links"/>
                            <!--                         <Pagination :links="production_models.links"/>-->
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </AppLayout>
</template>
