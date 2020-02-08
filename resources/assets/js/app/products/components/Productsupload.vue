<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 class="text-white ml-3 mt-2">New product upload.</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>
        <div class="modalwhitepart mr-auto ml-auto">
            <div class="row">
                <div class="col-md-12 mb-1">
                    <products-upload buss="product-icon1-upload" endpoint="/api/auth/productupload"/>
                    <formerror v-if="errors.icon1" :error="errors.icon1[0]"></formerror>
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
            // base:{
            //     required: false,
            //     type: Object
            // },
            // state:{
            //     required: true,
            //     type: Number
            // },
        },
        methods:{
            ...mapActions({
                updatProduct: 'products/updatProduct',
                createProduct: 'products/createProduct',
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
            newProduct(){
                this.isSubmitting = true;
                this.errors = [];
                this.createProduct({
                    payload: {
                        name: this.name,
                        price: this.price,
                        icon1: this.icon1,
                        icon2: this.icon2,
                        latest: this.latest,
                        description: this.description,
                    },
                    context: this
                })
                .then(() => {
                    this.isSubmitting = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Created.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.description} created successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                        Bus.$emit('new-product-data', this.newdata)
                    }
                })
            },
            update(){
                this.isUpdating = true;
                this.errors = [];
                this.updatProduct({
                    payload: {
                        name: this.base.name,
                        price: this.base.price,
                        latest: this.base.latest,
                        description: this.base.description,
                        icon: this.base.icon,
                        icon2: this.base.icon2,
                        iconOldFile1 : this.iconOldFile1,
                        iconOldFile2 : this.iconOldFile2,
                        id: this.base.id
                    },
                    context: this
                })
                .then(() => {
                    this.isUpdating = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.base.name} updated successfully !`}
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