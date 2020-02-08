<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 v-if="state == 1" class="text-white ml-3 mt-2">Edit data: {{base.name}}</h5>
                    <h5 v-else class="text-white ml-3 mt-2">New data.</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>
        <div class="modalwhitepart mr-auto ml-auto">
            <div class="row">
                <div class="col-md-12 mb-1">
                    <products-upload buss="offer-image-upload" :base="base" endpoint="/api/waveimages"/>
                    <formerror v-if="errors.image" :error="errors.image[0]"></formerror>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Title</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="base.title">
                        <input v-else type="text" class="form-control" v-model="title">
                        <formerror v-if="errors.title" :error="errors.title[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Offer</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="base.offer">
                        <input v-else type="text" class="form-control" v-model="offer">
                        <formerror v-if="errors.offer" :error="errors.offer[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Category</label>
                        <v-select v-if="state == 1" :onChange="slagUpdateCallback" label="value" v-model="base.slug" :options="categorylist"></v-select>
                        <v-select v-else :onChange="slagCallback" label="value" :options="categorylist"></v-select>
                        <formerror v-if="errors.category" :error="errors.category[0]"></formerror>
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
                title: null,
                category: null,
                description: null,
                offer: null,
                image: null,
                newImage: null,
                newdata:[],
                isSubmitting: false,
                isUpdating: false,
                errors: [],
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
            categorylist:{
                required: true,
                type: Array
            }
        },
        methods:{
            ...mapActions({
                updatOfers: 'wavesection/updatOfers',
                createOffer: 'wavesection/createOffer',
            }),
            closemodal: function () {
                Bus.$emit('close-variationtypesform-modal')
            },
            gradientCallback(val){
                if (val.lable) {
                    this.gradient = val.lable
                }
            },
            gradientUpdateCallback(val){
                if (val.lable) {
                    this.base.gradient = val.lable
                }
            },
            slagCallback(val){
                if (val.lable) {
                    this.category = val.lable
                }
            },
            slagUpdateCallback(val){
                if (val.lable) {
                    this.base.categoriesid = val.lable
                    this.base.slug = val.value
                }
            },
            newbase(){
                this.isSubmitting = true;
                this.errors = [];
                this.createOffer({
                    payload: {
                        title:      this.title,
                        offer:      this.offer,
                        category:   this.category,
                        description:this.description,
                        image:      this.image,
                    },
                    context: this
                })
                .then(() => {
                    this.isSubmitting = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Created.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.description} created successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                        Bus.$emit('new-offer-data', this.newdata)
                    }
                })
            },
            update(){
                this.isUpdating = true;
                this.errors = [];
                this.updatOfers({
                    payload: {
                        id:         this.base.id,
                        title:      this.base.title,
                        offer:      this.base.offer,
                        category:   this.base.categoriesid,
                        description:this.base.description,
                        image:      this.base.image,
                        newImage:   this.newImage,
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
            Bus.$on('offer-image-upload', (data)=> {
                if (this.state == 1) {
                    this.newImage = data
                }else{
                    this.image = data
                }
            })
        }
    }
</script>