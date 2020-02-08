<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 class="text-white ml-3 mt-2">{{base.product.name}}</h5>
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
                        <label>Category</label>
                        <v-select :onChange="categoryUpdateCallback" label="value" :options="categorylist"></v-select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button @click.prevent="update" :disabled="isUpdating" class="btn btn-sm btn-success btn-rounded">
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
                category_id: null,
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
            categorylist:{
                required: false,
                type: Array
            }
        },
        methods:{
            ...mapActions({
                updatProductCategory: 'productcategory/updatProductCategory',
            }),
            categoryUpdateCallback(val){
                if (val.lable) {
                    this.category_id = val.lable
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
                this.updatProductCategory({
                    payload: {
                        product: this.base.product_id,
                        Oldcategory: this.base.category_id,
                        category_id: this.category_id
                    },
                    context: this
                })
                .then(() => {
                    this.isUpdating = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'fas fa-thumbs-up', 'message': `${this.base.product.name} updated successfully !`}
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