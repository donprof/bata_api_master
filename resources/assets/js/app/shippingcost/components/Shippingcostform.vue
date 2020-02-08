<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 v-if="state == 1" class="text-white ml-3 mt-2">Editing Shipping area and cost</h5>
                    <h5 v-else class="text-white ml-3 mt-2">New shipping area.</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>
        <div class="modalwhitepart mr-auto ml-auto">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Region</label>
                        <v-select v-if="state == 1" :onChange="areaUpdCallback" label="value" v-model="base.countries.name" :options="areas"></v-select>
                        <v-select v-else :onChange="areaCallback" label="value" :options="areas"></v-select>
                        <formerror v-if="errors.name" :error="errors.name[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Method</label>
                        <v-select v-if="state == 1" :onChange="costUpdCallback" label="value" v-model="base.shippingmethods.name" :options="costs"></v-select>
                        <v-select v-else :onChange="costCallback" label="value" :options="costs"></v-select>
                        <formerror v-if="errors.description" :error="errors.description[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button v-if="state == 1" @click.prevent="update" :disabled="isUpdating" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Update</span>
                    </button>
                    <button v-else @click.prevent="newShippingcost" :disabled="isSubmitting" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isSubmitting" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Save</span>
                    </button>
                </div>
            </div>
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
                country_id: null,
                shipping_method_id: null,
                isSubmitting: false,
                isUpdating: false,
                errors: [],
                price: null,
            }
        },
        filters:{
            moment: function(date) {
                return moment(date, 'YYYY-M-D').fromNow()
            }
        },
        props:{
            base:{
                required: false,
                type: Object
            },
            state:{
                required: true,
                type: Number
            },
            areas:{
                required: true,
                type: Array
            },
            costs:{
                required: true,
                type: Array
            }
        },
        methods:{
            ...mapActions({
                updateShippingMethods: 'shippingcost/updateShippingMethods',
                createShippingMethods: 'shippingcost/createShippingMethods',
            }),
            closemodal: function () {
                Bus.$emit('close-variationtypesform-modal')
            },
            areaUpdCallback(val){
                if (val.lable) {
                    this.base.countries.name = val.value
                    this.base.country_id = val.lable
                }
            },
            areaCallback(val){
                if (val.lable) {
                    this.country_id = val.lable
                }
            },
            costUpdCallback(val){
                if (val.lable) {
                    this.base.shippingmethods.name = val.value
                    this.base.shippingmethods.price = val.price
                    this.base.shippingmethods.description = val.description
                    this.base.shipping_method_id = val.lable
                }
            },
            costCallback(val){
                if (val.lable) {
                    this.shipping_method_id = val.lable
                }
            },
            newShippingcost(){
                this.isSubmitting = true;
                this.errors = [];
                this.createShippingMethods({
                    payload: {
                        country_id: this.country_id,
                        shipping_method_id: this.shipping_method_id,
                    },
                    context: this
                })
                .then(() => {
                    this.isSubmitting = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Created.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'fas fa-thumbs-up', 'message': `Created successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                        Bus.$emit('new-shipping-methods-data', this.newdata)
                    }
                })
            },
            update(){
                this.isUpdating = true;
                this.errors = [];
                this.updateShippingMethods({
                    payload: {
                        country_id: this.base.country_id,
                        shipping_method_id: this.base.shipping_method_id,
                        id: this.base.id
                    },
                    context: this
                })
                .then(() => {
                    this.isUpdating = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'fas fa-thumbs-up', 'message': `Updated successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                    }
                })
            },
        }
    }
</script>