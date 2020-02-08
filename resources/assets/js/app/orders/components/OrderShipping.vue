<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 class="text-white ml-3 mt-2">{{base.order_number}} Shipping info.</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>
        <div class="modalwhitepart mr-auto ml-auto">
            <div class="card h-lg-100">
                <div class="card-header d-flex flex-between-center bg-danger py-2">
                    <h6 class="mb-0">Customer details</h6>
                </div>
                <div class="card-body pb-0">
                    <div class="media mb-3 hover-actions-trigger align-items-center">
                        <div class="media-body ml-3">
                            <h6 class="mb-1">
                                <span class="stretched-link text-900 font-weight-semi-bold">{{base.user.name}}</span>
                            </h6>
                            <div class="fs--1">
                                <span class="font-weight-semi-bold">{{base.user.email}}</span>
                            </div>
                            <div class="fs--1">
                                <span class="font-weight-semi-bold">{{base.user.phone}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card h-lg-100 mt-3">
                <div class="card-header d-flex flex-between-center bg-info py-2">
                    <h6 class="mb-0">Shipping</h6>
                </div>
                <div class="card-body pb-0">
                    <div class="media mb-3 hover-actions-trigger align-items-center">
                        <div class="media-body ml-3">
                            <h6 class="mb-1">
                                <span class="stretched-link text-900 font-weight-semi-bold">Type: {{base.shippingMethod.name}}</span>
                            </h6>
                            <div class="fs--1">
                                <span class="font-weight-semi-bold">{{base.shippingMethod.description}}</span>
                            </div>
                            <div class="fs--1">
                                <span class="font-weight-semi-bold">Price: {{base.shippingMethod.price}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card h-lg-100 mt-3">
                <div class="card-header d-flex flex-between-center bg-success py-2">
                    <h6 class="mb-0">Address</h6>
                </div>
                <div class="card-body pb-0">
                    <div class="media mb-3 hover-actions-trigger align-items-center">
                        <div class="media-body ml-3">
                            <h6 class="mb-1">
                                <span class="stretched-link text-900 font-weight-semi-bold">{{base.address.name}}</span>
                            </h6>
                            <div class="fs--1">
                                <span class="font-weight-semi-bold">{{base.address.address_1}}</span>
                            </div>
                            <div class="fs--1">
                                <span class="font-weight-semi-bold">{{base.address.city}}</span>
                            </div>
                            <div class="fs--1">
                                <span class="font-weight-semi-bold">{{base.address.postal_code}}</span>
                            </div>
                            <div class="fs--1">
                                <span class="font-weight-semi-bold">{{base.address.country.name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            







            
            <!-- <div class="row" v-if="state == 1">
                <div class="col-md-12 text-right">
                    <span class="lablevalue">{{base.created_at | moment}}</span>
                </div>
            </div> -->
            <!-- <div class="row">
                <div class="col-md-12 text-right">
                    <button @click.prevent="newProduct" :disabled="isSubmitting" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isSubmitting" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Close</span>
                    </button>
                </div>
            </div> -->
        </div>
    </div>
</template>
<script>
    import Bus from '../../../bus'
    import { mapGetters, mapActions } from 'vuex'
    import { isEmpty } from 'lodash'
    import moment from 'moment'
    export default {
        data(){
            return{
                newdata:[],
                latestlist: [{value: "Latest", lable: 1}, {value: "Not latest", lable: 4}],
                isSubmitting: false,
                isUpdating: false,
            }
        },
        filters:{
            moment: function(date) {
                return moment(date).fromNow()
            }
        },
        props:{
            base:{
                required: false,
                type: Object
            },
        },
        mounted() {
            Bus.$on('product-icon1-upload', (data)=> {
                if (this.state == 1) {
                    this.iconOldFile1 = this.base.icon
                    this.base.icon = data
                }else{
                    this.icon1 = data
                }
            })
        }
    }
</script>