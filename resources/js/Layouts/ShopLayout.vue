<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { ref, onMounted } from 'vue'
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

onMounted(()=> {
    getCarts()
})
</script>

<template>
    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <div class="ht-left">
                    <div class="mail-service">
                        <font-awesome-icon icon="fa fa-envelope" />
                        hello.colorlib@gmail.com
                    </div>
                    <div class="phone-service">
                        <font-awesome-icon icon=" fa fa-phone" />
                        +65 11.188.888
                    </div>
                </div>
                <div class="ht-right">
                    <div v-if="$page.props.auth.user" class="login-panel" href="#">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                    >
                                        {{ $page.props.auth.user.name }}

                                        <svg
                                            class="ml-2 -mr-0.5 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                    <a v-else :href="route('login')" class="login-panel">
                        <font-awesome-icon icon="fa-solid fa-user" />
                        Login
                    </a>
                    <div class="top-social">
                        <a href="#"><font-awesome-icon icon="fa-brands fa-facebook-f" /></a>
                        <a href="#"><font-awesome-icon icon="fa-brands fa-twitter" /></a>
                        <a href="#"><font-awesome-icon icon="fa-brands fa-instagram" /></a>
                        <a href="#"><font-awesome-icon icon="fa-brands fa-google-plus-g" /></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="inner-header">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="./index.html">
                                <img src="@/assets/frontend/img/logo.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="advanced-search">
                            <button type="button" class="category-btn">All Categories</button>
                            <form action="#" class="input-group">
                                <input type="text" placeholder="What do you need?">
                                <button type="button"><font-awesome-icon icon="fa-solid fa-magnifying-glass" /></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 text-right col-md-3">
                        <ul class="nav-right">
                            <li class="heart-icon"><a href="#">
                                    <font-awesome-icon icon="fa-regular fa-heart" />
                                    <span>1</span>
                                </a>
                            </li>
                            <li class="cart-icon"><a :href="route('cart')">
                                <font-awesome-icon icon="cart-shopping" />
                                    <span v-if="carts.cart && carts.cart != '' ">{{ Object.keys(carts.cart).length }}</span>
                                </a>
                                <div class="cart-hover">
                                    <div class="select-items">
                                        <table>
                                            <tbody>
                                                <tr v-for="cart in carts.cart" :key="cart.product_id">
                                                    <td class="si-pic"><img width="70" :src="cart.image" :alt="cart.name"></td>
                                                    <td class="si-text">
                                                        <div class="product-selected">
                                                            <p>{{ cart.unit_price }} x {{ cart.quantity}}</p>
                                                            <h6>{{ cart.name }}</h6>
                                                        </div>
                                                    </td>
                                                    <td class="si-close">
                                                        <font-awesome-icon icon="fa fa-close"/>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="select-total">
                                        <span>Total:</span>
                                        <h5 v-if="carts.cart">{{carts.total_price}} VNĐ</h5>
                                        <h5 v-else>0 VNĐ</h5>
                                    </div>
                                    <div class="select-button">
                                        <a :href="route('cart')" class="primary-btn view-card">VIEW CARD</a>
                                        <a :href="route('checkout')" class="primary-btn checkout-btn">CHECK OUT</a>
                                    </div>
                                </div>
                            </li>
                            <li v-if="carts.cart" class="cart-price">{{carts.total_price}} VNĐ</li>
                            <li v-else class="cart-price">0 VNĐ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <div class="container">
                <div class="nav-depart">
                    <div class="depart-btn">
                        <font-awesome-icon icon="fa-solid fa-bars" />
                        <span>All departments</span>
                        <ul class="depart-hover">
                            <li class="active"><a href="#">Women’s Clothing</a></li>
                            <li><a href="#">Men’s Clothing</a></li>
                            <li><a href="#">Underwear</a></li>
                            <li><a href="#">Kid's Clothing</a></li>
                            <li><a href="#">Brand Fashion</a></li>
                            <li><a href="#">Accessories/Shoes</a></li>
                            <li><a href="#">Luxury Brands</a></li>
                            <li><a href="#">Brand Outdoor Apparel</a></li>
                        </ul>
                    </div>
                </div>
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li><a :href="route('home')">Home</a></li>
                        <li><a :href="route('shop')">Shop</a></li>
                        <li><a :href="route('cart')">Cart</a></li>
                        <li><a :href="route('order.history')">Order History</a></li>
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
    <main>
        <slot />
    </main>

    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer-left">
                        <div class="footer-logo">
                            <a href="#"><img src="@/assets/frontend/img/logo.png" alt=""></a>
                        </div>
                        <ul>
                            <li>Address: 60-49 Road 11378 New York</li>
                            <li>Phone: +65 11.188.888</li>
                            <li>Email: hello.colorlib@gmail.com</li>
                        </ul>
                        <div class="footer-social">
                            <a href="#"><font-awesome-icon icon="fa-brands fa-facebook-f" /></a>
                            <a href="#"><font-awesome-icon icon="fa-brands fa-twitter" /></a>
                            <a href="#"><font-awesome-icon icon="fa-brands fa-instagram" /></a>
                            <a href="#"><font-awesome-icon icon="fa-brands fa-google-plus-g" /></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1">
                    <div class="footer-widget">
                        <h5>Information</h5>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Checkout</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Serivius</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-widget">
                        <h5>My Account</h5>
                        <ul>
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Shopping Cart</a></li>
                            <li><a href="#">Shop</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="newslatter-item">
                        <h5>Join Our Newsletter Now</h5>
                        <p>Get E-mail updates about our latest shop and special offers.</p>
                        <form action="#" class="subscribe-form">
                            <input type="text" placeholder="Enter Your Mail">
                            <button type="button">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-reserved">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright-text">
                            
                        </div>
                        <div class="payment-pic">
                            <img src="@/assets/frontend/img/payment-method.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>