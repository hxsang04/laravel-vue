<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import axios from 'axios';
import InputError from '@/Components/InputError.vue';

const product = reactive({
    name: '',
    price:'',
    description: '',
    image: '',
});

const errors = ref([]);

function uploadImage(e){
    product.image = e.target.files[0]
}

function createProduct(){
    const headers = { 'content-type' : 'multipart/form-data'}
    axios.post('/api/product/create', product, {headers})
    .then(res => {
        if(res.data.success){
            window.location = route('product');
        }
    })
    .catch(error => {
        errors.value = error.response.data.errors;
    })
}

</script>

<template>
    <Head title="Product List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <form @submit.prevent="createProduct" >
                                    <div class="position-relative row form-group">
                                        <label for="name" class="col-md-3 text-md-right col-form-label">Name</label>
                                        <div class="col-md-9 col-xl-8">
                                            <input name="name" id="name" placeholder="Name" type="text"
                                                class="form-control" 
                                                :class="{'border border-danger': errors.name}"
                                                v-model="product.name"
                                                />
                                            <InputError v-if="errors.name" class="mt-1" :message="errors.name[0]" />
                                        </div>
                                    </div>

                                    <div class="position-relative row form-group">
                                        <label for="price"
                                            class="col-md-3 text-md-right col-form-label">Price</label>
                                        <div class="col-md-9 col-xl-8">
                                            <input name="price" id="price"
                                                placeholder="Price" type="number" 
                                                class="form-control" 
                                                :class="{'border border-danger': errors.price}" 
                                                v-model="product.price" />
                                                <InputError v-if="errors.price" class="mt-1" :message="errors.price[0]" />
                                        </div>
                                    </div>

                                    <div class="position-relative row form-group">
                                        <label for="description"
                                            class="col-md-3 text-md-right col-form-label">Description</label>
                                        <div class="col-md-9 col-xl-8">
                                            <textarea v-model="product.description" 
                                            class="form-control" rows="3" 
                                            name="description" id="description" 
                                            placeholder="Description"
                                            :class="{'border border-danger': errors.description}"></textarea>
                                            <InputError v-if="errors.description" class="mt-1" :message="errors.description[0]" />
                                        </div>
                                    </div>

                                    <div class="position-relative row form-group ">
                                        <label for="image"
                                            class="col-md-3 text-md-right col-form-label">Image</label>
                                        <div class="col-md-9 col-xl-8 ">
                                            <input name="image" id="image" type="file" class="form-control border-0 p-0" @change="uploadImage">
                                            <InputError v-if="errors.image" class="mt-1" :message="errors.image[0]" />
                                        </div>
                                    </div>

                                    <div class="position-relative row form-group mb-1">
                                        <div class="col-md-9 col-xl-8 offset-md-2">
                                            <a :href="route('product')" class="border-0 btn btn-outline-danger mr-1">
                                                <span class="btn-icon-wrapper pr-1 opacity-8">
                                                    <font-awesome-icon icon="fa fa-times fa-w-20" />                                                
                                                </span>
                                                <span>Cancel</span>
                                            </a>

                                            <button type="submit"
                                                class="btn-shadow btn-hover-shine btn btn-primary">
                                                <span class="btn-icon-wrapper pr-2 opacity-8">
                                                    <font-awesome-icon icon="fa fa-download fa-w-20" />
                                                </span>
                                                <span>Save</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>