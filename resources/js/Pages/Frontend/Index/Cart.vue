<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue'
import { ref, onMounted } from 'vue'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import axios from 'axios';

const carts = ref({})

const getCarts = () => {
    axios.get('/api/carts')
    .then(res => {
        carts.value = res.data
    })
    .catch(error => {
        console.log(error)
    })
}

function removeCart(cart_id){
    axios.post(`/api/cart/delete/${cart_id}`)
    .then(res => {
        getCarts()
        console.log(res.data.success)
    })
    .catch(error => {
        console.log(error)
    })
}

onMounted(()=>{
    getCarts()
})
</script>

<template>
    <Head title="Cart"/>

    <ShopLayout>
        <section class="shopping-cart spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div v-if="carts.cart && carts.cart != '' " class="cart-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th class="p-name">Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>
                                            <font-awesome-icon icon="fa fa-close" />
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="cart in carts.cart" :key="cart.product_id">
                                        <td class="cart-pic first-row"><img style="width:80px" :src=" cart.image " :alt="cart.name"></td>
                                        <td class="cart-title first-row">
                                            <a :href="route('product.detail', cart.product_id)">
                                                <h5>{{cart.name}}</h5>
                                            </a>
                                        </td>
                                        <td class="p-price first-row">{{ cart.unit_price }} VNĐ</td>
                                        <td class="qua-col first-row">{{ cart.quantity }}</td>
                                        <td class="total-price first-row">{{ cart.total }} VNĐ</td>
                                        <td class="close-td first-row">
                                            <button @click="removeCart(cart.product_id)">
                                                <font-awesome-icon icon="fa fa-close" />
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="carts.cart && carts.cart != '' " class="row">
                            <div class="col-lg-4">
                                <div class="cart-buttons">
                                    <a :href="route('shop')" class="primary-btn">Continue shopping</a>
                                </div>
                                
                            </div>
                            <div class="col-lg-4 offset-lg-4">
                                <div class="proceed-checkout">
                                    <ul>
                                        <li class="cart-total">Total <span>{{ carts.total_price }} VNĐ</span></li>
                                    </ul>
                                    <a :href="route('checkout')" class="proceed-btn">PROCEED TO CHECK OUT</a>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="col-lg-12 text-center">
                                <h5 class="mb-1">No products</h5>
                                <div class="cart-buttons">
                                    <a :href="route('shop')" class="primary-btn">Continue shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </ShopLayout>
</template>