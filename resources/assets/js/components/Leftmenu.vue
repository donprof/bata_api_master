<template>
    <nav :class="[user.authenticated == true ? '' : 'hider']" class="navbar navbar-vertical navbar-expand-xl navbar-light navbar-glass">
        <router-link to="/" class="navbar-brand text-left">
            <div class="d-flex align-items-center py-3">
                <img class="mr-2" src="/assets/img/illustrations/Bata-logo.png" alt width="150">
            </div>
        </router-link>
        <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fa fa-chart-pie"></span></span>
                            <span>Dashboard</span>
                        </div>
                    </router-link>
                </li>
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#pages" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="pages">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-shoe-prints"></span></span><span>Product</span></div>
                    </a>
                    <ul class="nav collapse" id="pages" data-parent="#navbarVerticalCollapse">
                        <li class="nav-item">
                            <router-link to="/variation-types" class="nav-link">Variation type</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/products" class="nav-link">Products</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/categories" class="nav-link">Categories</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/product-category" class="nav-link">Products category</router-link>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <router-link to="/stock" class="nav-link">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-inbox"></span></span><span>Stocks</span></div>
                    </router-link>
                    <!-- <span class="badge badge-pill ml-2 badge-soft-danger animated heartBeat infinite">12</span> -->
                </li>
                <li class="nav-item">
                    <router-link to="/admin" class="nav-link">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-users"></span></span><span>Admins</span></div>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/logs" class="nav-link">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-users"></span></span><span>Logs</span></div>
                    </router-link>
                </li>
                
                <li class="nav-item"><a class="nav-link dropdown-indicator" href="#email" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="email">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-shipping-fast"></span></span><span>Shipping</span><span class="badge badge-pill ml-2 badge-soft-success"></span></div>
                    </a>
                    <ul class="nav collapse" id="email" data-parent="#navbarVerticalCollapse">
                    <li class="nav-item">
                        <router-link to="/shippingarea" class="nav-link">Shipping areas</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/shippingmethods" class="nav-link">Shipping methods</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/shippingcost" class="nav-link">Shipping cost per area</router-link>
                    </li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link dropdown-indicator" href="#orders" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="orders">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-cart-plus"></span></span><span>Orders</span><span class="badge badge-pill ml-2 badge-soft-success"></span></div>
                    </a>
                    <ul class="nav collapse" id="orders" data-parent="#navbarVerticalCollapse">
                    <!-- <li class="nav-item"><a class="nav-link" href="orders">Completed orders</a></li> -->
                    <li class="nav-item"><router-link to="/orders" class="nav-link">Orders</router-link></li>
                    <!-- <li class="nav-item"><router-link to="/orders" class="nav-link">Orders in progress</router-link></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="#">Canceled orders</a></li> -->
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link dropdown-indicator" href="#authentication" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="authentication">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-address-card"></span></span><span>Customers</span></div>
                    </a>
                    <ul class="nav collapse" id="authentication" data-parent="#navbarVerticalCollapse">
                    <li class="nav-item"><router-link to="/users" class="nav-link">All customers</router-link></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="/authentication/log-in.html">Log in</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="/authentication/log-out.html">Log out</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="/authentication/register.html">Register</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="/authentication/forget-password.html">Forget password</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="/authentication/password-reset.html">Password reset</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="/authentication/confirm-mail.html">Confirm mail</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="/authentication/lock-screen.html">Lock screen</a></li> -->
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link dropdown-indicator" href="#e-commerce" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="e-commerce">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-home"></span></span><span>Home page</span></div>
                    </a>
                    <ul class="nav collapse" id="e-commerce" data-parent="#navbarVerticalCollapse">
                    <li class="nav-item"><router-link to="/banners" class="nav-link">Banners</router-link></li>
                    <li class="nav-item"><router-link to="/offers" class="nav-link">Offers</router-link></li>
                    <li class="nav-item"><router-link to="/wavesection" class="nav-link">Wavey section</router-link></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="/e-commerce/orders.html">Fashion trends</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="/e-commerce/order-details.html">Order details</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="/e-commerce/customers.html">Footer</a></li> -->
                    </ul>
                </li>
                <li class="nav-item">
                    <router-link to="/reports" class="nav-link">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fa fa-copy"></span></span>
                            <span>Reports</span>
                        </div>
                    </router-link>
                </li>
            </ul>
            <hr class="border-300 my-2" />
            <!-- <ul class="navbar-nav flex-column">
                <li class="nav-item"><a class="nav-link" href="#">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-qrcode"></span></span><span>User reports</span></div>
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-puzzle-piece"></span></span><span>Products reports</span></div>
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fab fa-hotjar"></span></span><span>Sales reports</span></div>
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-plug"></span></span><span>Customers reports</span></div>
                    </a>
                </li>
            </ul> -->
        </div>
    </nav>
</template>
<script>
    import {mapGetters} from 'vuex'
    export default {
        computed: {
            ...mapGetters({
                user: 'auth/user'
            }),
            theme(){
                return this.filterByDay()
            }
        },
        methods: {
            filterByDay() {
                if (this.user.data != null) {
                     if (this.user.data.theme == 1) {
                        return true
                    }else{
                        return false
                    }
                }
            },
        }
    }
</script>
