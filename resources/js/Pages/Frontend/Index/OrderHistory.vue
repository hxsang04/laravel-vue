<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue'
import {ref, onMounted } from 'vue'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import axios from 'axios';

const orders = ref({})

const getOrders = (page=1) =>{
    axios.get(`/api/order-history?page=${page}`)
    .then(res =>{
        orders.value = res.data
    })
    .catch(error =>{
        console.log(error);
    })
}

onMounted(()=>{
    getOrders()
})

</script>

<template>
    <Head title="Order history"/>

    <ShopLayout>
        <section class="shopping-cart spad">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="cart-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date/Time</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Total Price</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="order in orders.data" :key="order.id">
                                        <td class="first-row ">#{{ order.id }}</td>
                                        <td class="first-row">
                                            {{ order.created_at }}
                                        </td>
                                        <td class="first-row ">{{ order.name }}</td>
                                        <td class="first-row ">{{ order.phone }}</td>
                                        <td class="first-row ">{{ order.address }}</td>
                                        <td class="p-price first-row">{{ order.total_price }} VNĐ</td>
                                        <td class="close-td first-row">
                                            <a :href="route('order.history.detail', order.id)">Chi tiết</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Bootstrap5Pagination
                        :data="orders"
                        :limit="1"
                        @pagination-change-page="getOrders"
                    />
                </div>
            </div>
        </section>
    </ShopLayout>
</template>