<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 class="text-white ml-3 mt-2">New images upload.</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>

        <div class="modalwhitepart mr-auto ml-auto animated bounceInDown">
            <div class="row no-gutters text-center fs--1">
                <div class="col-md-12 mb-1">
                    <image-upload :base="base" buss="product-icon1-upload" endpoint="/api/icons"></image-upload>
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
                base:null,
                isSubmitting: false,
                isUpdating: false,
                isAdding: false,
                isAddingVariants: false,
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
        methods:{
            ...mapActions({
                updatProduct: 'products/updatProduct',
                createVariation: 'products/createVariation',
                ProductImagesAdding: 'products/ProductImagesAdding',
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
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `Images added successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                    }
                })
            },
        },
        mounted() {
            Bus.$on('product-icon1-upload', (data)=> {
                this.$modal.hide('imageUploadModal')
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