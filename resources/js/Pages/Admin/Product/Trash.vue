<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TableHeader from '@/Components/TableHeader.vue';
import { ref, onMounted } from 'vue';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

const products = ref([])
const paginate = ref([])

const getTrashProducts = (page = 1) => {
    axios.get(`/api/products/trash?page=${page}`)
    .then(res => {
        products.value = res.data;
        paginate.value = res.data.meta;
    })
    .catch(error => {
        console.log(error);
    })
}

function restoreProduct(product_id){
    if(confirm('Do you really want to restore this item?')){
        axios.post(`/api/product/restore/${product_id}`)
        .then(res => {
            console.log(res.data.success)
            getTrashProducts()
        })
        .catch(error => {
            console.log(error);
        })
    }
}

function removeProduct(product_id){
    if(confirm('Do you really want to remove this item?')){
        axios.post(`/api/product/remove/${product_id}`)
        .then(res => {
            console.log(res.data.success)
            getTrashProducts()
        })
        .catch(error => {
            console.log(error);
        })
    }
}

onMounted(() => {
    getTrashProducts()
})

</script>

<template>
    <Head title="Product Trash" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product</h2>
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
                            
                            <TableHeader :href="route('product')">
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

                                        <tr v-for="product in products.data" :key="product.id">
                                            <td class="text-center text-muted">#{{ product.id }}</td>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">
                                                                <img style="height: 60px;"
                                                                    data-toggle="tooltip" title="Image"
                                                                    data-placement="bottom"
                                                                    :src=" product.image " 
                                                                    :alt="product.name">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">{{ product.name }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ product.price }} VNĐ</td>
                                            <td class="text-center">
                                                <button @click="restoreProduct(product.id)"
                                                    data-toggle="tooltip" title="Restore"
                                                    data-placement="bottom" class="btn btn-outline-warning border-0 btn-sm">
                                                    <span class="btn-icon-wrapper opacity-8">
                                                        <font-awesome-icon icon="fa fa-trash-restore fa-w-20"/>
                                                    </span>
                                                </button>
                                                <button class="btn btn-hover-shine btn-outline-danger border-0 btn-sm"
                                                    data-toggle="tooltip" title="Remove"
                                                    data-placement="bottom"
                                                    @click="removeProduct(product.id)">
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
                                            :data="products"
                                            :limit="1"
                                            @pagination-change-page="getTrashProducts"
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