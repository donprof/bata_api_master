<template>
    <span>
        <div class="card mb-3 animated zoomIn faster">
            <div class="card-header">
                <div class="row align-items-center justify-content-between">
                    <div class="col-2 col-sm-auto d-flex align-items-center pr-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Products.</h5>
                    </div>
                    <div class="col-10 col-sm-auto ml-auto text-right pl-0">
                        <div id="dashboard-actions">
                            <button class="btn btn-falcon-default btn-sm" @click="newcenter" type="button">
                                <span class="d-none d-sm-inline-block ml-1">New product</span>
                            </button>
                            <button class="btn btn-falcon-default btn-sm" @click="newupload" type="button">
                                <span class="d-none d-sm-inline-block ml-1">Upload products in CSV</span>
                            </button>
                            <button class="btn btn-falcon-default btn-sm" @click="newimageupload" type="button">
                                <span class="d-none d-sm-inline-block ml-1">Image upload</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3">
                        <form class="form-inline search-box" @submit.prevent="submitsearch">
                            <input @keyup="searchQuery" v-model="search" class="form-control w-100 rounded-pill search-input" placeholder="Search by description..." type="text">
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <loading v-if="isLoading == true"></loading>
                    <table v-else class="table table-sm mb-0 table-dashboard fs--1">
                        <thead class="bg-200 text-900">
                        <tr>
                            <th>Details</th>
                            <th>Code</th>
                            <th>Price</th>
                            <th>On home page</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="purchases">
                            <tr v-for="dt in data" :key="dt.id" class="btn-reveal-trigger">
                                <th class="align-middle">
                                    <div class="media align-items-center position-relative">
                                        <img v-if="dt.icon == null" class="rounded border border-200" src="/assets/img/default/default.jpg" width="60" alt="">
                                        <img v-else class="rounded border border-200" :src="dt.imagelink+'icons/'+dt.icon" width="60" alt="">
                                        <div class="media-body ml-3">
                                        <h6 class="mb-1 font-weight-semi-bold"><span class="text-dark stretched-link">{{dt.name}}</span></h6>
                                        <p class="font-weight-semi-bold mb-0 text-500">{{dt.material}}</p>
                                        </div>
                                    </div>
                                </th>
                                <th class="align-middle">{{dt.productcode}}</th>
                                <td class="align-middle">{{dt.price}}</td>
                                <td class="align-middle">{{dt.latestname}}</td>
                                <td class="align-middle">{{dt.description}}</td>
                                <td class="align-middle white-space-nowrap">
                                    <div class="dropdown text-sans-serif">
                                        <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dropdown1" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                        <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown1">
                                            <div class="bg-white py-2">
                                                <a class="dropdown-item" href="#!" @click="open(dt)">View / Edit</a>
                                                <a class="dropdown-item" href="#!" @click="openVariations(dt)">Variations</a>
                                                <div class="dropdown-divider"></div>
                                                <a v-if="dt.shoe_status == null" class="dropdown-item text-danger" href="#!" @click="delProduct(dt)">Deactivate</a>
                                                <a v-else class="dropdown-item text-success" href="#!" @click="actProduct(dt)">Activate</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer border-top">
                <div class="row align-items-center">
                    <data-pages :meta="meta" busname="product-pages"></data-pages>
                </div>
            </div>
        </div>

        <modal name="baseModal" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :pivotY="0.2">
            <productsform :base="product" :state="state"/>
        </modal>

        <modal name="variationModal" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :pivotY="0.2">
            <productsvariationform :variationlist="variationlist" :base="product" :state="state"/>
        </modal>
        
        <modal name="productUploadModal" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :pivotY="0.2">
            <productsupload/>
        </modal>

        <modal name="imageUploadModal" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :pivotY="0.2">
            <imageuploadform/>
        </modal>

        <!-- <footernav/> -->
    </span>
</template>
<script>
import Bus from '../../../bus'
import { mapGetters, mapActions } from 'vuex'
import { isEmpty } from 'lodash'
import moment from 'moment'
export default {
    data () {
        return {
            isGettingMc: false,
            isLoading: false,
            isLoadingMc: false,
            errors: null,
            state: null,
            isSearching: false,
            search: null
        }
    },
    computed: {
        ...mapGetters({
            data: 'products/getProducts',
            product: 'products/getProduct',
            meta: 'products/getMeta',
            page: 'products/getPage',
            variationlist: 'variationtypes/getVariationlist',
        })
    },
    methods: {
        ...mapActions({
            fetchProducts: 'products/fetchProducts',
            fetchVariationTypesList: 'variationtypes/fetchVariationTypesList',
            selectedProduct: 'products/selectedProduct',
            deleteProduct: 'products/deleteProduct',
            searchItems: 'products/searchItems',
            activateProduct: 'products/activateProduct',
        }),
        searchQuery(){
            if (this.search.length == 0) {
                this.isSearching = false;
                this.isLoading = true;
                this.fetchProducts({
                    payload: {
                        page: this.page
                    },
                    context: this
                }).then(() => {
                    this.isLoading = false;
                })
            }
        },
        submitsearch () {
            if (this.search.length >= 3) {
                this.isSearching = true;
                this.isLoading = true;
                this.searchItems({
                    payload: {
                        search: this.search
                    },
                    context: this
                }).then(() => {
                    this.isLoading = false;
                    if (isEmpty(this.errors)) {
                    }
                })
            }
        },
        dateFormater(date){
            if (date != null && date != "") {
                var today = new Date(date);
                var dd = today.getDate();
                var mm = today.getMonth()+1;
                var yyyy = today.getFullYear();
                var dateIssued = yyyy+'-'+mm+'-'+dd;
                return dateIssued;
            }else {
                return null;
            }
        },
        newupload(){
            this.errors = [];
            this.$modal.show('productUploadModal')
        },
        newimageupload(){
            this.errors = [];
            this.$modal.show('imageUploadModal')
        },
        newcenter(){
            this.selectedProduct()
            this.errors = [];
            this.state = 2
            this.$modal.show('baseModal')
        },
        open(cnt){
            this.selectedProduct(cnt)
            this.errors = [];
            this.state = 1
            this.$modal.show('baseModal')
        },
        openVariations(cnt){
            this.selectedProduct(cnt)
            this.errors = [];
            this.state = 1
            this.$modal.show('variationModal')
        },
        delProduct(val){
            this.isUpdating = true;
            this.errors = [];
            this.deleteProduct({
                payload: {
                    id: val.id
                },
                context: this
            })
            .then(() => {
                this.isUpdating = false;
                alert('Deactivated!')
                // if (isEmpty(this.errors)) {
                //     let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.base.name} updated successfully !`}
                //     Bus.$emit('close-variationtypesform-modal')
                //     Bus.$emit('show-message-swal', data)
                // }
            })
        },
        actProduct(val){
            this.isUpdating = true;
            this.errors = [];
            this.activateProduct({
                payload: {
                    id: val.id
                },
                context: this
            })
            .then(() => {
                this.isUpdating = false;
                alert('Activated!')
                // if (isEmpty(this.errors)) {
                //     let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.base.name} updated successfully !`}
                //     Bus.$emit('close-variationtypesform-modal')
                //     Bus.$emit('show-message-swal', data)
                // }
            })
        },
    },
    mounted (){
        this.fetchProducts({
            payload: {
                page: this.page
            }
        }),
        Bus.$on('product-pages', (data)=> {
            this.isLoading = true;
            this.fetchProducts({
                payload: {
                    page: data
                },
                context: this
            }).then(() => {
                this.isLoading = false;
            })
        })
        this.fetchVariationTypesList()
        Bus.$on('close-variationtypesform-modal', ()=> {
            this.$modal.hide('baseModal');
        })
        Bus.$on('close-productvariationform-modal', ()=> {
            this.$modal.hide('variationModal');
        })
        Bus.$on('new-product-data', (data)=> {
            this.data.unshift(data)
        })
    }
}
</script>