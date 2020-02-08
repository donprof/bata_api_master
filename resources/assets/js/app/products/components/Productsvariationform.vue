<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 v-if="state == 1" class="text-white ml-3 mt-2">{{base.name}}</h5>
                    <h5 v-else class="text-white ml-3 mt-2">New product variation.</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>

        <div class="modalwhitepart mr-auto ml-auto animated bounceInUp" v-if="isAddingVariants">
            <div class="row no-gutters text-center fs--1">
                <div class="col-12">
                    <button class="btn btn-sm btn-falcon-default rounded-capsule mx-auto mb-1" @click="addImage" type="button">Add image for size: {{postingimages.name}}</button>
                </div>

                <div class="col-6 col-md-4 col-xl-3 col-xxl-3 mb-1" v-for="(img, index) in images" :key="index">
                    <div class="bg-white p-1 h-100">
                        <shoes-upload buss="shoe-variant-image" :index="index" endpoint="/api/images"/>
                    </div>
                </div>

            </div>
            <div class="mt-3 row">
                <div class="col-md-12 text-right">
                    <button @click.prevent="addproductimages" :disabled="isSubmitting" class="btn btn-falcon-default btn-sm mr-1 mb-1" type="button">
                        <span :class="[isSubmitting == true ? 'fa os-icon os-icon-grid-18 fa-spin':'fas fa-plus mr-1']" class="fas fa-plus mr-1" data-fa-transform="shrink-3"></span>Save
                    </button>

                    <!-- <button v-else @click.prevent="update" :disabled="isUpdating" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>update</span>
                    </button>

                    <button v-if="isAdding" @click.prevent="newProductVariation" :disabled="isSubmitting" class="btn btn-sm btn-danger btn-rounded">
                        <i v-if="isSubmitting" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>cancel</span>
                    </button> -->
                </div>
            </div>
        </div>

        <div class="modalwhitepart mr-auto ml-auto animated bounceInDown" v-if="isAdding">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Size</label>
                        <input type="number" class="form-control" v-model="size">
                        <formerror v-if="errors.name" :error="errors.name[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" v-model="price">
                        <formerror v-if="errors.price" :error="errors.price[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Color</label>
                        <v-select :onChange="colorCallback" label="value" :options="variationlist"></v-select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button v-if="isAdding" @click.prevent="newProductVariation" :disabled="isSubmitting" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isSubmitting" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Save</span>
                    </button>

                    <button v-else @click.prevent="update" :disabled="isUpdating" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Update</span>
                    </button>

                    <button v-if="isAdding == true" @click="isAdding = false" class="btn btn-sm btn-danger btn-rounded">
                        <i class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span>Cancel</span>
                    </button>
                    
                </div>
            </div>
        </div>

        <div class="modalwhitepart mr-auto ml-auto animated bounceInDown" v-if="editingVariant">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Size</label>
                        <input type="number" class="form-control" v-model="edits.name">
                        <formerror v-if="errors.name" :error="errors.name[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Color</label>
                        <v-select :onChange="colorUpdateCallback" label="value" v-model="edits.variationtypename" :options="variationlist"></v-select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button @click.prevent="updateVariant" :disabled="isUpdating" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Update</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="card mb-3 animated zoomIn faster">
            <div class="card-header">
                <div class="row align-items-center justify-content-between">
                    <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Variations.</h5>
                    </div>
                    <div class="col-6 col-sm-auto ml-auto text-right pl-0" v-if="isAdding == false">
                        <div id="dashboard-actions">
                            <button class="btn btn-falcon-default btn-sm" @click="addingvariant" type="button">
                                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                                <span class="d-none d-sm-inline-block ml-1">New variant</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table table-sm mb-0 table-dashboard fs--1">
                    <thead class="bg-200 text-900">
                    <tr>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="purchases">
                        <tr class="btn-reveal-trigger" v-for="vr in base.variations" :key="vr.id">
                            <th class="align-middle">{{vr.variationtypename}}</th>
                            <td class="align-middle">{{vr.name}}</td>
                            <td class="align-middle white-space-nowrap">
                                <div class="dropdown text-sans-serif">
                                    <button class="btn btn-link text-600 btn-sm btn-reveal mr-3" @click="addImageVariants(vr)" type="button"><span class="fas fa-upload fs--1"></span></button>
                                    <button class="btn btn-link text-600 btn-sm btn-reveal mr-3" @click="editingVariants(vr)" type="button"><span class="far fa-edit fs--1"></span></button>
                                    <button class="btn btn-link text-600 btn-sm btn-reveal mr-3" @click="deleteVariant(vr)" type="button"><span class="far fa-trash-alt fs--1"></span></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                isAdding: false,
                isAddingVariants: false,
                editingVariant:false,
                edits: null,
                images: [],
                variantsImages: [],
                errors: [],
                size: null,
                price: null,
                color: null,
                icon1: null,
                icon2: null,
                iconOldFile1: null,
                iconOldFile2: null,
                latest: null,
                postingimages: null
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
            variationlist:{
                required: true,
                type: Array
            },
        },
        methods:{
            ...mapActions({
                updatProduct: 'products/updatProduct',
                createVariation: 'products/createVariation',
                ProductImagesAdding: 'products/ProductImagesAdding',
                deleteVariation: 'products/deleteVariation',
                updatSelectedVariation: 'products/updatSelectedVariation',
            }),
            latestUpdCallback(val){
                if (val.lable) {
                    this.base.latest = val.lable
                    this.base.latestname = val.value
                }
            },
            addImageVariants(vr){
                this.postingimages = vr
                this.isAdding = false
                this.isAddingVariants = true
                this.editingVariant = false
                this.images = []
                this.variantsImages = []
            },
            editingVariants(vr){
                this.edits = vr
                this.isAdding = false
                this.isAddingVariants = false
                this.editingVariant = true
                this.images = []
                this.variantsImages = []
            },
            addImage(){
                this.images.push(1)
            },
            // removeimage(index){
            //     this.images.splice(index, 1)
            //     this.variantsImages.splice(index, 1)
            // },
            colorCallback(val){
                if (val.lable) {
                    this.color = val.lable
                }
            },
            colorUpdateCallback(val){
                if (val.lable) {
                    this.edits.product_variation_type_id = val.lable
                }
            },
            addingvariant(val){
                if (this.isAdding == true) {
                    this.isAddingVariants = false
                    this.isAdding = false
                }else{
                    this.isAddingVariants = false
                    this.isAdding = true
                }
            },
            closemodal: function () {
                Bus.$emit('close-productvariationform-modal')
            },
            newProductVariation(){
                this.isSubmitting = true;
                this.errors = [];
                this.createVariation({
                    payload: {
                        size: this.size,
                        price: this.price,
                        color: this.color,
                        product: this.base.id,
                    },
                    context: this
                })
                .then(() => {
                    this.isSubmitting = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Created.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.size} created successfully !`}
                        this.isAdding = false
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                        Bus.$emit('new-base-data', this.newdata)
                    }
                })
            },
            deleteVariant(val){
                this.isUpdating = true;
                this.errors = [];
                this.deleteVariation({
                    payload: {
                        id: val.id
                    },
                    context: this
                })
                .then(() => {
                    this.isUpdating = false;
                    alert('Deleted!')
                    // if (isEmpty(this.errors)) {
                    //     let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.base.name} updated successfully !`}
                    //     Bus.$emit('close-variationtypesform-modal')
                    //     Bus.$emit('show-message-swal', data)
                    // }
                })
            },
            updateVariant(){
                this.isUpdating = true;
                this.errors = [];
                this.updatSelectedVariation({
                    payload: {
                        color : this.edits.product_variation_type_id,
                        size : this.edits.name,
                        id: this.edits.id
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
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'fas fa-thumbs-up', 'message': `${this.base.name} updated successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                    }
                })
            },
            addproductimages(){
                this.isUpdating = true;
                this.errors = [];
                this.ProductImagesAdding({
                    payload: {
                        product: this.postingimages.product_id,
                        color: this.postingimages.product_variation_type_id,
                        images: this.variantsImages,
                    },
                    context: this
                })
                .then(() => {
                    this.isUpdating = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'fas fa-thumbs-up', 'message': `Images added successfully !`}
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
            Bus.$on('shoe-variant-image', (data)=> {
                if (this.state == 1) {
                    this.variantsImages.push(data)
                }
            })
            Bus.$on('remove-this-image', (data)=> {
                if (this.state == 1) {
                    this.images.splice(data,1)
                    this.variantsImages.splice(data,1)
                }
            })
        }
    }
</script>