<template>
    <span>
        <div class="card mb-3">
            <div class="card-header rounded badge-soft-success">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">Parent Category</h5>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-falcon-default btn-sm" @click="newcategory" type="button">
                            <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                            <span class="d-none d-sm-inline-block ml-1">New parent category</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3 animated zoomIn faster" v-for="dt in data" :key="dt.id">
            <div class="card-header">
                <div class="row align-items-center justify-content-between">
                    <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{dt.name}}.</h5>
                    </div>
                    <div class="col-6 col-sm-auto ml-auto text-right pl-0">
                        <div id="dashboard-actions">
                            <button class="btn btn-falcon-default btn-sm" @click="newChildCategory(dt)" type="button">
                                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                                <span class="d-none d-sm-inline-block ml-1">New {{dt.name}} category</span>
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
                        <th>
                            <div class="custom-control custom-checkbox ml-1 pl-1"></div>
                        </th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="purchases">
                        <tr v-for="(ch, index) in dt.children" :key="index" class="btn-reveal-trigger">
                            <td class="align-middle">
                                <div class="custom-control custom-checkbox ml-1 pl-1"></div>
                            </td>
                            <th class="align-middle">{{ch.name}}</th>
                            <td class="align-middle">{{ch.slug}}</td>
                            <td class="align-middle white-space-nowrap">
                                <div class="dropdown text-sans-serif">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dropdown1" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                    <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown1">
                                        <div class="bg-white py-2">
                                            <a class="dropdown-item" href="#!" @click="open(ch)">Edit Category</a>
                                            <a class="dropdown-item" href="#!" @click="openSubCaregory(ch)">Edit Sub Category</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" href="#!">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <modal name="newCategoryModal" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :pivotY="0.2">
            <categoriesform :base="base" :state="state"/>
        </modal>

        <modal name="newSubCategoryModal" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :pivotY="0.2">
            <subchildrenform :base="sub" :state="substate"/>
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
            isLoadingMc: false,
            errors: null,
            state: null,
            childstate: null,
            substate: null
        }
    },
    computed: {
        ...mapGetters({
            data: 'categories/getCategories',
            base: 'categories/getChildCategory',
            sub: 'categories/getSubCategory',
        })
    },
    methods: {
        ...mapActions({
            fetchCategories: 'categories/fetchCategories',
            selectedChild: 'categories/selectedChild',
            selectedSubChild: 'categories/selectedSubChild',
        }),
        newcategory(){
            this.selectedChild()
            this.errors = [];
            this.state = 2
            this.$modal.show('newCategoryModal')
        },
        open(cnt){
            this.selectedChild(cnt)
            this.errors = [];
            this.state = 1
            this.$modal.show('newCategoryModal')
        },

        newChildCategory(cnt){
            this.selectedChild(cnt)
            this.errors = [];
            this.state = 3
            this.$modal.show('newCategoryModal')
        },

        openSubCaregory(cnt){
            this.selectedSubChild(cnt)
            this.errors = [];
            this.substate = 1
            this.$modal.show('newSubCategoryModal')
        },
        newSubChildCategory(){
            this.selectedSubChild()
            this.errors = [];
            this.substate = 2
            this.$modal.show('newSubCategoryModal')
        },
    },
    mounted (){
        this.fetchCategories()
        Bus.$on('new-category-data', (data)=> {
            this.fetchCategories()
            // this.data.unshift(data)
        })
        Bus.$on('close-variationtypesform-modal', ()=> {
            this.$modal.hide('newCategoryModal');
        })
    }
}
</script>