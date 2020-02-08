<template>
    <div class="col-md-12">
        <div class="pipeline white">
            <div class="pipeline-header">
                <h5 class="pipeline-name">{{holdertitle}}</h5>
                <div class="pipeline-settings os-dropdown-trigger"></div>
            </div>
            <div class="pipeline-body">
                <div class="support-index">
                    <div class="row" v-if="user.data">
                        <report-card v-for="rpt in data" :key="rpt.id"
                            :carddesc='rpt'
                            cardclass='col-md-6 mb-3 col-xxl-4'
                            :user='user.data.roleid'
                        ></report-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Bus from '../bus'
    export default {
        data(){
            return{
                loadingReport: false,
            }
        },
        props:{
            data:{
                required: true,
                type: Array
            },
            holdertitle:{
                required: true,
                type: String
            },
            user:{
                required: true,
            },
        },
    }
</script>

<style>

</style>
