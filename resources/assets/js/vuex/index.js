import Vue from 'vue'
import Vuex from 'vuex'
import dashboard from '../app/dashboard/vuex'
import auth from '../app/auth/vuex'
import users from '../app/users/vuex'
import costcenters from '../app/costcenters/vuex'
import messages from '../app/messages/vuex'
import variationtypes from '../app/variationtypes/vuex'
import products from '../app/products/vuex'
import categories from '../app/categories/vuex'
import offers from '../app/offers/vuex'
import banners from '../app/banners/vuex'
import wavesection from '../app/wavesection/vuex'
import orders from '../app/orders/vuex'
import shippingarea from '../app/shippingarea/vuex'
import shippingmethods from '../app/shippingmethods/vuex'
import shippingcost from '../app/shippingcost/vuex'
import stock from '../app/stock/vuex'
import productcategory from '../app/productcategory/vuex'
import reports from '../app/reports/vuex'
import logs from '../app/logs/vuex'
import admin from '../app/admin/vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        dashboard: dashboard,
        auth: auth,
        users: users,
        costcenters: costcenters,
        messages: messages,
        variationtypes: variationtypes,
        products: products,
        categories: categories,
        offers: offers,
        banners: banners,
        wavesection: wavesection,
        orders: orders,
        shippingarea: shippingarea,
        shippingmethods: shippingmethods,
        shippingcost: shippingcost,
        stock: stock,
        productcategory: productcategory,
        reports: reports,
        logs: logs,
        admin: admin
    }
})