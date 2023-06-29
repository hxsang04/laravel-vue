<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TableHeader from '@/Components/TableHeader.vue';
import { ref, onMounted } from 'vue';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

const orders = ref([])
const paginate = ref([])

const getTrashOrders = (page = 1) => {
    axios.get(`/api/orders/trash?page=${page}`)
    .then(res => {
        orders.value = res.data;
        paginate.value = res.data.meta;
    })
    .catch(error => {
        console.log(error);
    })
}

function restoreOrder(product_id){
    if(confirm('Do you really want to restore this item?')){
        axios.post(`/api/order/restore/${product_id}`)
        .then(res => {
            console.log(res.data.success)
            getTrashOrders()
        })
        .catch(error => {
            console.log(error);
        })
    }
}

function removeOrder(product_id){
    if(confirm('Do you really want to remove this item?')){
        axios.post(`/api/order/remove/${product_id}`)
        .then(res => {
            console.log(res.data.success)
            getTrashOrders()
        })
        .catch(error => {
            console.log(error);
        })
    }
}

onMounted(() => {
    getTrashOrders()
})

</script>

<template>
    <Head title="Order Trash" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            
                            <TableHeader :href="route('order')">
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
                                        <tr v-for="order in orders.data" :key="order.id">
                                            <td class="text-center text-muted">#{{ order.id }}</td>
                                            <td>
                                                <div class="widget-content p-0">{{ order.name }}</div>
                                            </td>
                                            <td>
                                                <div class="widget-content p-0">{{ order.phone }}</div>
                                            </td>
                                            <td>
                                                <div class="widget-content p-0">{{ order.address }}</div>
                                            </td>
                                            <td class="text-center">{{ order.total_price }} VNĐ</td>
                                            <td class="text-center">{{ order.created_at }}</td>
                                            <td class="text-center">
                                                <button @click="restoreOrder(order.id)"
                                                    data-toggle="tooltip" title="Restore"
                                                    data-placement="bottom" class="btn btn-outline-warning border-0 btn-sm">
                                                    <span class="btn-icon-wrapper opacity-8">
                                                        <font-awesome-icon icon="fa fa-trash-restore fa-w-20"/>
                                                    </span>
                                                </button>
                                                <button class="btn btn-hover-shine btn-outline-danger border-0 btn-sm"
                                                    data-toggle="tooltip" title="Remove"
                                                    data-placement="bottom"
                                                    @click="removeOrder(order.id)">
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
                                            :data="orders"
                                            :limit="1"
                                            @pagination-change-page="getTrashOrders"
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