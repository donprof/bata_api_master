<template>
	<div>
        <input style="visibility: hidden; height: 0; position: absolute;" v-on:change="fileChange" :name="sendAs" type="file" ref="fileInput"/>
        <!-- <span v-if="base != null">
            <span v-if="buss == 'product-icon1-upload'">
                <img class="img-thumbnail img-fluid rounded mb-3 shadow-sm" :src="base.imagelink+base.icon" alt="" width="100">
            </span>
            <span v-else>
                <img class="img-thumbnail img-fluid rounded mb-3 shadow-sm" :src="base.imagelink+base.icon2" alt="" width="100">
            </span>
        </span> -->
        <span>
            <span v-if="avatar">
                <img class="img-thumbnail img-fluid rounded-circle mb-3 shadow-sm" :src="avatar" alt="" width="100">
            </span>
            <span v-else>
                <img class="img-thumbnail img-fluid rounded-circle mb-3 shadow-sm" src="/assets/img/default/default.jpg" alt="" width="100">
            </span>
        </span>

        <div class="row">
            <div class="col-6 text-right">
                <span :disabled="uploading" class="badge badge-soft-danger rounded-capsule point" @click="removeimage(index)">
                    <span class="fas fa-ban" data-fa-transform="shrink-2"></span>
                </span>
            </div>
            <div class="col-6 text-left">
                <span @click="trigger" :disabled="uploading" class="badge badge-soft-success rounded-capsule point">
                    <span class="fas fa-upload"></span>
                </span>
            </div>
        </div>
        
        

        <!-- <button @click="trigger" :disabled="uploading" type="button" class="btn btn-outline-primary btn-sm w-100 text-left">
            <i :class="[uploading == true ? 'fa os-icon os-icon-grid-18 fa-spin' : 'os-icon os-icon-documents-07']"></i>
            <span v-if="avatar">{{avatar}}</span>
            <span v-else>
                <span v-if="uploading">Uploading the file, please wait.</span>
                <span v-else>Pick a file</span>
            </span>
        </button> -->
        <formerror v-if="errors[this.sendAs]" :error="errors[this.sendAs][0]"></formerror>
	</div>
</template>

<script>
    import upload from '../mixins/singleupload'
    import Bus from '../bus'

    export default {
        props: [
            'currentAvatar',
            'user',
            'buss',
            'base',
            'index'
        ],
        data () {
            return {
                errors: [],
            	sendAs: {
		            type: String,
		            default: 'file'
		        },
                avatar: null,
            }
        },
        mixins: [
            upload
        ],
        methods: {
            removeimage(index){
                Bus.$emit('remove-this-image', index)
            },
            trigger () {
                this.$refs.fileInput.click()
            },
            fileChange (e) {
            	this.errors = []
                this.upload(e).then((response) => {
                    this.avatar = response.data.show
                    Bus.$emit(this.buss, response.data.data)
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data
                        return
                    }
                    this.errors = 'Something went wrong. Try again.'
                })
            }
        }
    }
</script>
<style scoped>
    .newHidden {
        display: none !important;
    }
</style>