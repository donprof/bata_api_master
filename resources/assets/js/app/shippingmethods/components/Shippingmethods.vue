<template>
    <span>
        <div class="card mb-3 animated zoomIn faster">
            <div class="card-header">
                <div class="row align-items-center justify-content-between">
                    <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Shipping methods</h5>
                    </div>
                    <div class="col-6 col-sm-auto ml-auto text-right pl-0">
                        <div id="dashboard-actions">
                            <button class="btn btn-falcon-default btn-sm" @click="newcenter" type="button">
                                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                                <span class="d-none d-sm-inline-block ml-1">New method</span>
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
                        <th class="ml-3">Name</th>
                        <th class="ml-3">Description</th>
                        <th class="ml-3">Price</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="purchases">
                        <tr v-for="dt in data" :key="dt.id" class="btn-reveal-trigger">
                            <th class="ml-3 align-middle">{{dt.name}}</th>
                            <th class="ml-3 align-middle">{{dt.description}}</th>
                            <th class="ml-3 align-middle">{{dt.price}}</th>
                            <td class="align-middle white-space-nowrap">
                                <div class="dropdown text-sans-serif">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dropdown1" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                    <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown1">
                                        <div class="bg-white py-2">
                                            <a class="dropdown-item" href="#!" @click="open(dt)">View / Edit</a>
                                            <!-- <a class="dropdown-item" href="#!">Edit</a> -->
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
            <div class="card-footer border-top">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="mb-0 fs--1"><span class="d-none d-sm-inline-block mr-1">11 Items</span></p>
                    </div>
                    <div class="col-auto"><button class="btn btn-light btn-sm" type="button" disabled="disabled"><span>Previous</span></button><button class="btn btn-primary btn-sm px-4 ml-2" type="button"><span>Next</span></button></div>
                </div>
            </div>
        </div>

        <modal name="shippingMethodesModal" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :pivotY="0.2">
            <shippingmethodsform :base="variation" :state="state"/>
        </modal>

        <footernav/>
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
        }
    },
    computed: {
        ...mapGetters({
            data: 'shippingmethods/getShippingmethods',
            variation: 'variationtypes/getVariation',
        })
    },
    methods: {
        ...mapActions({
            ShippingmethodData: 'shippingmethods/ShippingmethodData',
            selectedVariation: 'variationtypes/selectedVariation',
            fetchSerciceCountData: 'dashboard/fetchSerciceCountData',
        }),
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
        newcenter(){
            this.selectedVariation()
            this.errors = [];
            this.state = 2
            this.$modal.show('shippingMethodesModal')
        },
        open(cnt){
            this.selectedVariation(cnt)
            this.errors = [];
            this.state = 1
            this.$modal.show('shippingMethodesModal')
        },
    },
    mounted (){
        this.ShippingmethodData()
        Bus.$on('close-variationtypesform-modal', ()=> {
            this.$modal.hide('shippingMethodesModal');
        })
        Bus.$on('new-shipping-methods-data', (data)=> {
            this.data.unshift(data)
        })
    }
}
</script>