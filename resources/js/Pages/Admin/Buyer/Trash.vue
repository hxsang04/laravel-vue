<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TableHeader from '@/Components/TableHeader.vue';
import { ref, onMounted } from 'vue';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

const buyers = ref([])
const paginate = ref([])

const getTrashBuyers = (page = 1) => {
    axios.get(`/api/buyers/trash?page=${page}`)
    .then(res => {
        buyers.value = res.data;
        paginate.value = res.data.meta;
    })
    .catch(error => {
        console.log(error);
    })
}

function restoreBuyer(product_id){
    if(confirm('Do you really want to restore this item?')){
        axios.post(`/api/buyer/restore/${product_id}`)
        .then(res => {
            console.log(res.data.success)
            getTrashBuyers()
        })
        .catch(error => {
            console.log(error);
        })
    }
}

function removeBuyer(product_id){
    if(confirm('Do you really want to remove this item?')){
        axios.post(`/api/buyer/remove/${product_id}`)
        .then(res => {
            console.log(res.data.success)
            getTrashBuyers()
        })
        .catch(error => {
            console.log(error);
        })
    }
}

onMounted(() => {
    getTrashBuyers()
})

</script>

<template>
    <Head title="Buyer Trash" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buyer</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            
                            <TableHeader :href="route('buyer')">
                                <template #link>
                                    <font-awesome-icon icon="fa fa-arrow-left"/>
                                    <span class="pl-1">Back</span>
                                </template>
                            </TableHeader>

                            <div class="table-responsive">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Name</th>
                                            <th class="text-center">Price</th>
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
                                                <button @click="restoreBuyer(buyer.id)"
                                                    data-toggle="tooltip" title="Restore"
                                                    data-placement="bottom" class="btn btn-outline-warning border-0 btn-sm">
                                                    <span class="btn-icon-wrapper opacity-8">
                                                        <font-awesome-icon icon="fa fa-trash-restore fa-w-20"/>
                                                    </span>
                                                </button>
                                                <button class="btn btn-hover-shine btn-outline-danger border-0 btn-sm"
                                                    data-toggle="tooltip" title="Remove"
                                                    data-placement="bottom"
                                                    @click="removeBuyer(buyer.id)">
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
                                            @pagination-change-page="getTrashBuyers"
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