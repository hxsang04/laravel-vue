<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TableHeader from '@/Components/TableHeader.vue';
import { ref, onMounted } from 'vue'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

const buyers = ref({})
const paginate = ref([])
const keyword = ref('')

const getBuyers = (page = 1) => {
    axios.get(`/api/buyers?search=${keyword.value}&page=${page}`)
    .then(res => {
        buyers.value = res.data;
        paginate.value = res.data;
    })
    .catch(error => {
        console.log(error);
    })
}

function deleteBuyer(product_id){
    if(confirm('Do you really want to delete this item?')){
        axios.post(`/api/product/delete/${product_id}`)
        .then(res => {
            console.log(res.data.success)
            getProducts()
        })
        .catch(error => {
            console.log(error.response.data);
        })
    }
}

function exportBuyer(){
    axios.get('/api/buyer/export', { responseType: 'blob' })
    .then(res => {
        const url = window.URL.createObjectURL(new Blob([res.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'buyers.xlsx');
        document.body.appendChild(link);
        link.click();
    })
    .catch(error => {
        console.log(error.response.data);
    })
}

onMounted(() => {
    getBuyers()
})

</script>

<template>
    <Head title="Order List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order</h2>
        </template>
        
        <template #button>
            <div class="page-title-actions">
                <a :href="route('product.create')" class="btn-shadow btn-hover-shine mr-3 btn btn-primary">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                        <font-awesome-icon icon="fa fa-plus fa-w-20"/>
                    </span>
                    Create
                </a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            
                            <TableHeader :href="route('product.trash')" @search="getBuyers" v-model="keyword">
                                <template #link>
                                    <font-awesome-icon icon="fa fa-trash" />
                                    <span class="pl-1">Trash</span>
                                </template>
                                <div class="btn-actions-pane-right">
                                    <div role="group" class="btn-group-sm btn-group">
                                        <div>
                                            <button @click="exportBuyer" class="btn btn-focus ml-2">Export</button>
                                        </div>
                                    </div>
                                </div> 
                                
                            </TableHeader>

                            <div class="table-responsive">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th class="text-center">Data/Time</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <tr v-for="buyer in buyers.data" :key="buyer.id">
                                            <td class="text-center text-muted">#{{ buyer.id }}</td>
                                            <td>
                                                <div class="widget-content p-0">{{ buyer.name }}</div>
                                            </td>
                                            <td>
                                                <div class="widget-content p-0">{{ buyer.email }}</div>
                                            </td>
                                            <td class="text-center">{{ buyer.created_at }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-hover-shine btn-outline-danger border-0 btn-sm"
                                                    data-toggle="tooltip" title="Delete"
                                                    data-placement="bottom"
                                                    @click="deleteBuyer(buyer.id)">
                                                    <span class="btn-icon-wrapper opacity-8">
                                                        <font-awesome-icon icon="fa fa-trash fa-w-20" />
                                                    </span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-block card-footer">
                                <nav role="navigation" aria-label="Pagination Navigation"
                                    class="flex items-center justify-between">
                                    <div class="flex justify-between flex-1 sm:hidden">
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                            « Previous
                                        </span>

                                        <a href="#page=2"
                                            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                            Next »
                                        </a>
                                    </div>

                                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm text-gray-700 leading-5">
                                                Showing
                                                <span class="font-medium">{{ paginate.from }}</span>
                                                to
                                                <span class="font-medium">{{ paginate.to }}</span>
                                                of
                                                <span class="font-medium">{{ paginate.total }}</span>
                                                results
                                            </p>
                                        </div>

                                        <Bootstrap5Pagination
                                            :data="buyers"
                                            :limit="1"
                                            @pagination-change-page="getBuyers"
                                        />
                                    </div>
                                </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>