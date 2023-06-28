<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue'
import { reactive ,ref, onMounted } from 'vue'
import axios from 'axios';
import InputError from '@/Components/InputError.vue';

const order = reactive({
    name: '',
    email: '',
    phone: '',
    address: '',
    message: '',
    
})
const errors = ref([])
const carts = ref([])

const getCarts = () => {
    axios.get('/api/carts')
    .then(res => {
        carts.value = res.data
    })
    .catch(error => {
        console.log(error)
    })
}
function placeOrder(){
    axios.post('/api/place-order', order)
    .then(res =>{
        console.log(res.data.success)
        window.location.href = route('order.history')
    })
    .catch(error =>{
        errors.value = error.response.data.errors;
    })
}

onMounted(()=>{
    getCarts()
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
                                    <label for="name">Name<span>*</span></label>
                                    <input v-model="order.name" type="text" id="name"
                                    :class="{'border border-danger mb-1': errors.name}" >
                                    <InputError v-if="errors.name" :message="errors.name[0]" />
                                </div>
                                <div class="col-lg-12">
                                    <label for="email">Email<span>*</span></label>
                                    <input v-model="order.email" type="text" id="email"
                                    :class="{'border border-danger mb-1': errors.email}">
                                    <InputError v-if="errors.email" :message="errors.email[0]" />
                                </div>
                                <div class="col-lg-12">
                                    <label for="phone">Phone<span>*</span></label>
                                    <input v-model="order.phone" type="text" id="phone"
                                    :class="{'border border-danger mb-1': errors.phone}">
                                    <InputError v-if="errors.phone" :message="errors.phone[0]" />
                                </div>
                                <div class="col-lg-12">
                                    <label for="address">Address<span>*</span></label>
                                    <input v-model="order.address" type="text" id="address"
                                    :class="{'border border-danger mb-1': errors.address}">
                                    <InputError v-if="errors.address" :message="errors.address[0]" />
                                </div>
                                <div class="col-lg-12">
                                    <label for="message"> Message (Optional)</label>
                                    <input v-model="order.message" type="text" id="message" >
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="place-order">
                                <h4>Your Order</h4>
                                <div class="order-total">
                                    <ul class="order-table">
                                        <li>Product <span>Total</span></li>
                                        <li v-for="cart in carts.cart" :key="cart.product_id" class="fw-normal">
                                            {{cart.name}} x {{ cart.quantity }} 
                                            <span>{{ cart.total }} VNĐ</span>
                                        </li>
                                        <li class="total-price">Total <span>{{carts.total_price}} VNĐ</span></li>
                                    </ul>
                                    <div class="order-btn">
                                        <button type="submit" class="site-btn place-btn">Place Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </ShopLayout>
</template>