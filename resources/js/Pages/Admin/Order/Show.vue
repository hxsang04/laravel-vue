<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue'

const order = ref([])

const getOrder = (order_id) => {
    axios.get(`/api/order/show/${order_id}`)
    .then(res => {
        order.value = res.data.data;
    })
    .catch(error => {
        console.log(error);
    })
}

onMounted(() => {
    const order_id = route().params.id;
    getOrder(order_id)
})

</script>

<template>
    <Head title="Order Detail" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body display_data">
                                <div class="table-responsive">
                                    <h2 class="text-center">Products list</h2>
                                    <hr>
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="product in order.products" :key="product.id">
                                                <td>
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <div class="widget-content-left">
                                                                    <img style="height: 60px;"
                                                                        data-toggle="tooltip" title="Image"
                                                                        data-placement="bottom"
                                                                        :src="product.image" :alt="product.name">
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-left flex2">
                                                                <div class="widget-heading">{{product.name}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    {{product.quantity}}
                                                </td>
                                                <td class="text-center">{{ product.unit_price }} VNĐ</td>
                                                <td class="text-center">
                                                    {{ product.total }} VNĐ
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p class="mt-3 text-center">Total: {{ order.total_price }} VNĐ</p>
                                </div>



                                <h2 class="text-center mt-5">Order info</h2>
                                    <hr>
                                <div class="position-relative row form-group">
                                    <label for="name" class="col-md-3 text-md-right col-form-label">
                                        Name
                                    </label>
                                    <div class="col-md-9 col-xl-8">
                                        <p>{{order.name}}</p>
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="email" class="col-md-3 text-md-right col-form-label">Email</label>
                                    <div class="col-md-9 col-xl-8">
                                        <p>{{order.email}}</p>
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="phone" class="col-md-3 text-md-right col-form-label">Phone</label>
                                    <div class="col-md-9 col-xl-8">
                                        <p>{{order.phone}}</p>
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="street_address" class="col-md-3 text-md-right col-form-label">
                                        Street Address</label>
                                    <div class="col-md-9 col-xl-8">
                                        <p>{{order.address}}</p>
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label class="col-md-3 text-md-right col-form-label">Message</label>
                                    <div class="col-md-9 col-xl-8">
                                        <p>{{order.message}}</p>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label class="col-md-3 text-md-right col-form-label">Date / time</label>
                                    <div class="col-md-9 col-xl-8">
                                        <p>{{order.created_at}}</p>
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