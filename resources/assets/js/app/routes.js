import dashboard from './dashboard/routes'
import users from './users/routes'
import messages from './messages/routes'
import auth from './auth/routes'
import errors from './errors/routes'
import welcome from './welcome/routes'
import costcenters from './costcenters/routes'
import variationtypes from './variationtypes/routes'
import products from './products/routes'
import categories from './categories/routes'
import offers from './offers/routes'
import banners from './banners/routes'
import wavesection from './wavesection/routes'
import orders from './orders/routes'
import shippingarea from './shippingarea/routes'
import shippingmethods from './shippingmethods/routes'
import shippingcost from './shippingcost/routes'
import stock from './stock/routes'
import productcategory from './productcategory/routes'
import reports from './reports/routes'
import logs from './logs/routes'
import admin from './admin/routes'

export default 
[
    ...dashboard,
    ...users,
    ...messages,
    ...auth,
    ...welcome,
    ...costcenters,
    ...variationtypes,
    ...products,
    ...categories,
    ...offers,
    ...banners,
    ...wavesection,
    ...orders,
    ...shippingarea,
    ...shippingmethods,
    ...shippingcost,
    ...stock,
    ...productcategory,
    ...reports,
    ...logs,
    ...admin,
    ...errors
]