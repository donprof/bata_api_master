<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 v-if="state == 1" class="text-white ml-3 mt-2">{{base.name}}</h5>
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
                        <label>Name</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="base.name">
                        <input v-else type="text" class="form-control" v-model="name">
                        <formerror v-if="errors.name" :error="errors.name[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="base.description">
                        <input v-else type="text" class="form-control" v-model="description">
                        <formerror v-if="errors.description" :error="errors.description[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Price</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="base.realprice">
                        <input v-else type="text" class="form-control" v-model="price">
                        <formerror v-if="errors.price" :error="errors.price[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button v-if="state == 1" @click.prevent="update" :disabled="isUpdating" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Update</span>
                    </button>
                    <button v-else @click.prevent="newbase" :disabled="isSubmitting" class="btn btn-sm btn-success btn-rounded">
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
                isSubmitting: false,
                isUpdating: false,
                errors: [],
                name: null,
                description: null,
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
            }
        },
        methods:{
            ...mapActions({
                updateShippingMethods: 'shippingmethods/updateShippingMethods',
                createShippingMethods: 'shippingmethods/createShippingMethods',
            }),
            closemodal: function () {
                Bus.$emit('close-variationtypesform-modal')
            },
            newbase(){
                this.isSubmitting = true;
                this.errors = [];
                this.createShippingMethods({
                    payload: {
                        name: this.name,
                        description: this.description,
                        price: this.price,
                    },
                    context: this
                })
                .then(() => {
                    this.isSubmitting = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Created.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'fas fa-thumbs-up', 'message': `${this.name} created successfully !`}
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
                        name: this.base.name,
                        description: this.base.description,
                        price: this.base.realprice,
                        id: this.base.id
                    },
                    context: this
                })
                .then(() => {
                    this.isUpdating = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'fas fa-thumbs-up', 'message': `${this.base.name} updated successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                    }
                })
            },
        }
    }
</script>