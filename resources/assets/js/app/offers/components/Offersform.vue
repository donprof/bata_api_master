<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 v-if="state == 1" class="text-white ml-3 mt-2">Edit offer: {{base.name}}</h5>
                    <h5 v-else class="text-white ml-3 mt-2">New offer.</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>
        <div class="modalwhitepart mr-auto ml-auto">
            <div class="row">
                <div class="col-md-12 mb-1">
                    <products-upload buss="offer-image-upload" :base="base" endpoint="/api/offerimages"/>
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
                        <label>Gradient</label>
                        <v-select v-if="state == 1" :onChange="gradientUpdateCallback" label="value" v-model="base.gradient" :options="gradientlist"></v-select>
                        <v-select v-else :onChange="gradientCallback" label="value" :options="gradientlist"></v-select>
                        <formerror v-if="errors.gradient" :error="errors.gradient[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Link Category</label>
                        <v-select v-if="state == 1" :onChange="slagUpdateCallback" label="value" v-model="base.slug" :options="categorylist"></v-select>
                        <v-select v-else :onChange="slagCallback" label="value" :options="categorylist"></v-select>
                        <formerror v-if="errors.category" :error="errors.category[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Blinker</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="base.blinker">
                        <input v-else type="text" class="form-control" v-model="blinker">
                        <formerror v-if="errors.blinker" :error="errors.blinker[0]"></formerror>
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
                gradientlist: [{'value':'Red', 'lable':'danger'},{'value':'Green', 'lable':'success'},{'value':'Oranger', 'lable':'warning'},{'value':'Sky Blue', 'lable':'info'}],
                title: null,
                category: null,
                blinker: null,
                description: null,
                image: null,
                gradient: null,
                oldImage: null,
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
                updatOfers: 'offers/updatOfers',
                createOffer: 'offers/createOffer',
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
                    this.base.slugid = val.lable
                    this.base.slug = val.value
                }
            },
            newbase(){
                this.isSubmitting = true;
                this.errors = [];
                this.createOffer({
                    payload: {
                        title:      this.title,
                        category:   this.category,
                        blinker:    this.blinker,
                        description:this.description,
                        image:      this.image,
                        gradient:   this.gradient,
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
                        category:   this.base.slugid,
                        blinker:    this.base.blinker,
                        description:this.base.description,
                        image:      this.base.image,
                        gradient:   this.base.gradient,
                        oldImage:   this.oldImage,
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
                    console.log(data)
                    console.log(this.base.image)
                    this.oldImage = this.base.image
                    this.base.image = data
                }else{
                    this.image = data
                }
            })
        }
    }
</script>