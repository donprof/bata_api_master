<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 v-if="state == 1" class="text-white ml-3 mt-2">{{base.product.name}} -> {{base.variationtypename}} -> {{base.name}}</h5>
                    <h5 v-else class="text-white ml-3 mt-2">New product.</h5>
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
                        <label>Quanty</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="base.stock[0].pivot.stock">
                        <formerror v-if="errors.quantity" :error="errors.quantity[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button v-if="state == 1" @click.prevent="update" :disabled="isUpdating" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Update</span>
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
                latestlist: [{value: "Latest", lable: 1}, {value: "Not latest", lable: 4}],
                isSubmitting: false,
                isUpdating: false,
                errors: [],
                name: null,
                price: null,
                icon1: null,
                icon2: null,
                iconOldFile1: null,
                iconOldFile2: null,
                latest: null,
                description: null,
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
            state:{
                required: true,
                type: Number
            },
        },
        methods:{
            ...mapActions({
                updateProductStock: 'stock/updateProductStock',
            }),
            latestUpdCallback(val){
                if (val.lable) {
                    this.base.latest = val.lable
                    this.base.latestname = val.value
                }
            },
            latestCallback(val){
                if (val.lable) {
                    this.latest = val.lable
                }
            },
            closemodal: function () {
                Bus.$emit('close-variationtypesform-modal')
            },
            update(){
                this.isUpdating = true;
                this.errors = [];
                this.updateProductStock({
                    payload: {
                        quantity: this.base.stock[0].pivot.stock,
                        product_variation_id: this.base.stock[0].pivot.product_variation_id,
                    },
                    context: this
                })
                .then(() => {
                    this.isUpdating = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'fas fa-thumbs-up', 'message': `Quantity updated successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                    }
                })
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
            Bus.$on('product-icon2-upload', (data)=> {
                if (this.state == 1) {
                    this.iconOldFile2 = this.base.icon2
                    this.base.icon2 = data
                }else{
                    this.icon2 = data
                }
            })
        }
    }
</script>