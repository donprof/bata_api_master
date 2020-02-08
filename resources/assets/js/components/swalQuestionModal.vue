<template>
    <div class="customsweet mr-auto ml-auto animated bounceIn faster">
        <div :class="qsdata.bottomclass" class="darkone">
            <div :class="qsdata.topclass" class="greenone ml-auto mr-auto">
                <div class="row pt-4">
                    <h1 :class="qsdata.swalicon" class="animated swing infinite text-white mr-auto ml-auto customicon mb-4"></h1>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="text-white mb-3">{{qsdata.title}}</h3>
                        <h6 class="text-white">{{qsdata.message}}</h6>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <div class="col-6 text-center">
                    <button @click="closeQuestion(1)" :disabled="isSubmitting" class="ctbutton btn-warning">
                        <i v-if="isSubmitting" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Sure</span>
                    </button>
                </div>
                <div class="col-6 text-center">
                    <button @click="closeQuestion(0)" class="ctbutton btn-danger" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Bus from '../bus'
    export default {
        data (){
            return{
                isSubmitting: false,
            }
        },
        props:{
            qsdata:{
                required: true,
                type: Object
            }
        },
        methods:{
            closeQuestion(data) {
                this.isSubmitting = true
                Bus.$emit('return-qm-data', data)
            }
        }
    }
</script>