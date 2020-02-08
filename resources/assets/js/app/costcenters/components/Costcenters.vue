<template>
    <div class="content-box">
        <div class="pipelines-w">
            <div class="row">
                <div class="col-md-10 mr-auto ml-auto">
                    <div class="pipeline white">
                        <div class="pipeline-header">
                            <div class="element-header row">
                                <div class="col-sm-3">
                                    <h4>Cost centers</h4>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control text-center form-control-sm rounded bright" placeholder="Search using name or code" type="text">
                                </div>
                                <div class="col-sm-3 text-right">
                                    <button @click="newcenter" class="mr-2 mb-2 btn btn-primary btn-sm">
                                        <i class="os-icon os-icon-ui-22"></i>
                                        <span>Add new</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="pipeline-body">
                            <div class="support-index">
                                <div class="table-responsive">
                                    <loading v-if="isLoading == true"></loading>
                                    <table v-else class="table table-padded">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Telephone</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="cent in centers" :key="cent.id">
                                                <td>{{cent.code}}</td>
                                                <td>{{cent.company}}</td>
                                                <td>{{cent.address}}</td>
                                                <td>{{cent.telephone}}</td>
                                                <td class="row-actions text-right">
                                                    <span @click="open(cent)"><i class="os-icon os-icon-common-07"></i></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <modal name="centerModal" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :pivotY="0.2">
            <centerform :cnt="cnt" :state="state"></centerform>
        </modal>
    </div>
</template>
<script>
    import Bus from '../../../bus'
    import { mapGetters, mapActions } from 'vuex'
    export default {
        data () {
            return {
                returnData: [],
                errors: [],
                state: null,
                empty:null,
                isLoading: false
            }
        },
        computed: {
            ...mapGetters({
                centers: 'costcenters/getCenters',
                cnt: 'costcenters/getCenter'
            })
        },
        methods: {
            ...mapActions({
                fetchCostcenters: 'costcenters/fetchCostcenters',
                selectedCenter: 'costcenters/selectedCenter',
            }),
            newcenter(){
                this.selectedCenter()
                this.errors = [];
                this.state = 2
                this.$modal.show('centerModal')
            },
            open(cnt){
                this.selectedCenter(cnt)
                this.errors = [];
                this.state = 1
                this.$modal.show('centerModal')
            }
        },
        mounted (){
            this.fetchCostcenters()
            Bus.$on('close-center-modal', ()=> {
                this.$modal.hide('centerModal');
            })
            Bus.$on('new-center-data', (data)=> {
                this.centers.push(data)
            })
        }
    }
</script>