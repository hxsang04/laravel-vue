<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const order = ref({})

const getOrder = (order_id) => {
    axios.get(`/api/order/show/${order_id}`)
    .then(res => {
        order.value = res.data.data
    })
    .catch(error => {
        console.log(error)
    })
}

onMounted(()=>{
    const order_id = route().params.id;
    getOrder(order_id)
})
</script>

<template>
    <Head title="Checkout"/>

    <ShopLayout>
        <section class="checkout-section spad">
            <div class="container">
                <form @submit.prevent="placeOrder" class="checkout-form">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Biiling Details</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>Name</label>
                                    <p>{{ order.name }}</p>
                                </div>
                                <div class="col-lg-12">
                                    <label>Email</label>
                                    <p>{{ order.email }}</p>
                                </div>
                                <div class="col-lg-12">
                                    <label>Phone</label>
                                    <p>{{ order.phone }}</p>
                                </div>
                                <div class="col-lg-12">
                                    <label>Address</label>
                                    <p>{{ order.address }}</p>
                                </div>
                                <div class="col-lg-12">
                                    <label> Message</label>
                                    <p v-if="order.message" >{{ order.message }}</p>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="place-order">
                                <h4>Your Order</h4>
                                <div class="order-total">
                                    <ul class="order-table">
                                        <li>Product <span>Total</span></li>
                                        <li v-for="product in order.products" :key="product.id" class="fw-normal">
                                            {{product.name}} x {{ product.quantity }} 
                                            <span>{{product.total}} VNĐ</span>
                                        </li>
                                        <li class="total-price">Total <span>{{order.total_price}} VNĐ</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </ShopLayout>
</template>

<style scoped>
.col-lg-12 p{
    font-size: 16px;
    border: 1px solid #d0d0d0;
    padding: 10px;
    border-radius: 5px;
}
</style>