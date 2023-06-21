<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue'

const product = ref([])

const getProduct = (product_id) => {
    axios.get(`/api/product/show/${product_id}`)
    .then(res => {
        product.value = res.data.data;
    })
    .catch(error => {
        console.log(error);
    })
}

onMounted(() => {
    const product_id = route().params.id;
    getProduct(product_id)
})

</script>

<template>
    <Head title="Product Detail" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body display_data">
                                <div class="position-relative row form-group">
                                    <label for="" class="col-md-3 text-md-right col-form-label">Images</label>
                                    <div class="col-md-9 col-xl-8">
                                        <ul class="text-nowrap overflow-auto" id="images">
                                            <li class="d-inline-block mr-1" style="position: relative;">
                                                <img style="height: 150px;" :src=" product.image" alt="Image">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            
                                <div class="position-relative row form-group">
                                    <label for="name" class="col-md-3 text-md-right col-form-label">Name</label>
                                    <div class="col-md-9 col-xl-8">
                                        <p>{{ product.name }}</p>
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="price" class="col-md-3 text-md-right col-form-label">Price</label>
                                    <div class="col-md-9 col-xl-8">
                                        <p>{{ product.price }} VNĐ</p>
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="description" class="col-md-3 text-md-right col-form-label">Description</label>
                                    <div class="col-md-9 col-xl-8">
                                        <p>{{ product.description }}</p>
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="description" class="col-md-3 text-md-right col-form-label">Created at</label>
                                    <div class="col-md-9 col-xl-8">
                                        <p>{{ product.created_at }}</p>
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="description" class="col-md-3 text-md-right col-form-label">Updated at</label>
                                    <div class="col-md-9 col-xl-8">
                                        <p>{{ product.updated_at }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>