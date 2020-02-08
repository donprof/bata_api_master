<template>
    <span>
        <div class="card mb-3 animated zoomIn faster">
            <div class="card-header">
                <div class="row align-items-center justify-content-between">
                    <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Orders.</h5>
                    </div>
                    <div class="col-6 col-sm-auto ml-auto text-right pl-0">
                        <div id="dashboard-actions"></div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table table-sm mb-0 table-dashboard fs--1">
                    <thead class="bg-200 text-900">
                    <tr>
                        <th>Details</th>
                        <th>Code</th>
                        <th>Total</th>
                        <th>Price</th>
                        <th>Shipping</th>
                        <th>Shipping cost</th>
                        <th>Status</th>
                        <th>Sub total</th>
                        <th>Order No.</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="purchases" v-for="dt in data" :key="dt.id">
                        <tr class="btn-reveal-trigger" v-for="vr in dt.products" :key="vr.id">
                            <th class="align-middle">
                                <div v-if="vr.product != null" class="media align-items-center position-relative">
                                    <img class="rounded border border-200" :alt="vr.product.name" :src="vr.product.imagelink+'icons/'+vr.product.icon" style="width: 70px;">
                                    <div class="media-body ml-3">
                                    <h6 class="mb-1 font-weight-semi-bold"><span class="text-dark stretched-link">{{vr.product.name}}</span></h6>
                                    <p class="font-weight-semi-bold mb-0 text-500">{{vr.product.material}}</p>
                                    </div>
                                </div>
                            </th>
                            <th class="align-middle" v-if="vr.product != null">{{vr.product.productcode}}</th>
                            <td class="align-middle" v-else></td>
                            <td class="align-middle">{{vr.price}}</td>
                            <td class="align-middle">Color:</td>
                            <td class="align-middle" colspan="2">{{vr.colorcode}}</td>
                            <td class="align-middle">Size:</td>
                            <td class="align-middle" colspan="3">{{vr.name}}</td>
                        </tr>
                        <td class="align-middle bg-secondary text-light"></td>
                        <td class="align-middle bg-secondary text-light"></td>
                        <td class="align-middle bg-secondary text-light">{{dt.total}}</td>
                        <td class="align-middle bg-secondary text-light" colspan="2">{{dt.shippingMethod.name}}</td>
                        <td class="align-middle bg-secondary text-light">{{dt.shippingMethod.price}}</td>
                        <td class="align-middle bg-secondary text-light">
                            <span v-if="dt.status == 'pending'" class="badge badge rounded-capsule badge-soft-warning">{{dt.status}}<span class="ml-1 fas fa-stream" data-fa-transform="shrink-2"></span></span>
                            <span v-else-if="dt.status == 'processing'" class="badge badge rounded-capsule badge-soft-info">{{dt.status}}<span class="ml-1 fas fa-exchange-alt" data-fa-transform="shrink-2"></span></span>
                            <span v-else-if="dt.status == 'completed'" class="badge badge rounded-capsule badge-soft-success">{{dt.status}}<span class="ml-1 fas fa-check" data-fa-transform="shrink-2"></span></span>
                            <span v-else-if="dt.status == 'payment_failed'" class="badge badge rounded-capsule badge-soft-danger">{{dt.status}}<span class="ml-1 fas fa-ban" data-fa-transform="shrink-2"></span></span>
                        </td>
                        <td class="align-middle bg-secondary text-light">{{dt.subtotal}}</td>
                        <td class="align-middle bg-secondary text-light">{{dt.order_number}}</td>
                        <td class="align-middle bg-secondary white-space-nowrap">
                                <div class="dropdown text-sans-serif">
                                    <button class="btn btn-link text-600 bg-white btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dropdown1" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                    <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown1">
                                        <div class="bg-white py-2">
                                            <a class="dropdown-item" href="#!" @click="shipping(dt)">View Shipping</a>
                                            <a class="dropdown-item" href="#!" @click="completed(dt,'completed')">Completed</a>
                                            <a class="dropdown-item" href="#!" @click="completed(dt,'processing')">Processing</a>
                                            <a class="dropdown-item" href="#!" @click="completed(dt,'pending')">Pendind</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="card-footer border-top">
                <div class="row align-items-center">
                    <div class="col">
                        <!-- <p class="mb-0 fs--1"><span class="d-none d-sm-inline-block mr-1">2 Items</span></p> -->
                    </div>
                    <div class="col-auto"><button class="btn btn-light btn-sm" type="button" disabled="disabled"><span>Previous</span></button><button class="btn btn-primary btn-sm px-4 ml-2" type="button"><span>Next</span></button></div>
                </div>
            </div>
        </div>

        <modal name="baseModal" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :pivotY="0.2">
            <productsform :base="product" :state="state"/>
        </modal>

        <modal name="orderShippingModal" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :pivotY="0.2">
            <ordershipping :base="orshipping"/>
        </modal>

        <!-- <footernav/> -->
    </span>
</template>
<script>
import Bus from '../../../bus'
import { mapGetters, mapActions } from 'vuex'
import { isEmpty } from 'lodash'
import moment from 'moment'
export default {
    data () {
        return {
            isGettingMc: false,
            isLoadingMc: false,
            errors: null,
            state: null,
        }
    },
    computed: {
        ...mapGetters({
            data: 'orders/getOrders',
            product: 'products/getProduct',
            orshipping: 'orders/getShipping',
            variationlist: 'variationtypes/getVariationlist',
        })
    },
    methods: {
        ...mapActions({
            fetchOrders: 'orders/fetchOrders',
            fetchVariationTypesList: 'variationtypes/fetchVariationTypesList',
            selectedProduct: 'products/selectedProduct',
            completeOrder: 'orders/completeOrder',
            selectedShipping: 'orders/selectedShipping',
        }),
        dateFormater(date){
            if (date != null && date != "") {
                var today = new Date(date);
                var dd = today.getDate();
                var mm = today.getMonth()+1;
                var yyyy = today.getFullYear();
                var dateIssued = yyyy+'-'+mm+'-'+dd;
                return dateIssued;
            }else {
                return null;
            }
        },
        newupload(){
            this.errors = [];
            this.$modal.show('productUploadModal')
        },
        newimageupload(){
            this.errors = [];
            this.$modal.show('imageUploadModal')
        },
        shipping(vr){
            this.selectedShipping(vr)
            this.$modal.show('orderShippingModal')
        },
        completed(val, state){
            this.isUpdating = true;
            this.errors = [];
            this.completeOrder({
                payload: {
                    id: val.id,
                    status: state
                },
                context: this
            })
            .then(() => {
                this.isUpdating = false;
                alert('Updated!')
                // if (isEmpty(this.errors)) {
                //     let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.base.name} updated successfully !`}
                //     Bus.$emit('close-variationtypesform-modal')
                //     Bus.$emit('show-message-swal', data)
                // }
            })
        },
    },
    mounted (){
        this.fetchOrders()
        this.fetchVariationTypesList()
        Bus.$on('close-variationtypesform-modal', ()=> {
            this.$modal.hide('baseModal');
        })
        Bus.$on('close-productvariationform-modal', ()=> {
            this.$modal.hide('variationModal');
        })
        Bus.$on('new-product-data', (data)=> {
            this.data.unshift(data)
        })
    }
}
</script>