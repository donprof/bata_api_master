<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 v-if="state == 1" class="text-white ml-3 mt-2">{{base.name}}</h5>
                    <h5 v-else class="text-white ml-3 mt-2">New product.</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>
        <div class="modalwhitepart mr-auto ml-auto">
            <!-- <div class="row">
                <div class="col-md-6 mb-1">
                    <image-upload :base="base" buss="product-icon1-upload" endpoint="/api/icons"></image-upload>
                    <formerror v-if="errors.icon1" :error="errors.icon1[0]"></formerror>
                </div>
                <div class="col-md-6 mb-1">
                    <image-upload :base="base" buss="product-icon2-upload" endpoint="/api/icons"></image-upload>
                    <formerror v-if="errors.icon2" :error="errors.icon2[0]"></formerror>
                </div>
            </div> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="base.name">
                        <input v-else type="text" class="form-control" v-model="name">
                        <formerror v-if="errors.name" :error="errors.name[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Price</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="base.price">
                        <input v-else type="number" class="form-control" v-model="price">
                        <formerror v-if="errors.price" :error="errors.price[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Latest</label>
                        <v-select v-if="state == 1" :onChange="latestUpdCallback" label="value" v-model="base.latestname" :options="latestlist"></v-select>
                        <v-select v-else :onChange="latestCallback" label="value" :options="latestlist"></v-select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Description</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="base.description">
                        <input v-else type="text" class="form-control" v-model="description">
                        <formerror v-if="errors.description" :error="errors.description[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row" v-if="state == 1">
                <div class="col-md-12 text-right">
                    <span class="lablevalue">{{base.created_at | moment}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button v-if="state == 1" @click.prevent="update" :disabled="isUpdating" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Update</span>
                    </button>
                    <button v-else @click.prevent="newProduct" :disabled="isSubmitting" class="btn btn-sm btn-success btn-rounded">
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
                        // icon1: this.icon1,
                        // icon2: this.icon2,
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