<template>
	<div>
        <div class="bg-white p-3 h-100 text-center point">
            <input style="visibility: hidden; height: 0; position: absolute;" v-on:change="fileChange" multiple :name="sendAs" type="file" ref="fileInput"/>
            <span>
                <img class="img-thumbnail img-fluid rounded mb-3 shadow-sm" src="/assets/img/default/default.jpg" alt="" width="100">
            </span>
            <button @click="trigger" :disabled="uploading" type="button" class="btn btn-outline-primary btn-sm w-100 text-left">
                <i :class="[uploading == true ? 'fa os-icon os-icon-grid-18 fa-spin' : 'os-icon os-icon-documents-07']"></i>
                <span v-if="avatar">{{avatar}}</span>
                <span v-else>
                    <span v-if="uploading">Uploading the file, please wait.</span>
                    <span v-else>Pick a file</span>
                </span>
            </button>
        </div>
        <formerror v-if="errors[this.sendAs]" :error="errors[this.sendAs][0]"></formerror>
	</div>
</template>

<script>
    import upload from '../mixins/upload'
    import Bus from '../bus'

    export default {
        props: [
            'currentAvatar',
            'user',
            'buss',
            'base'
        ],
        data () {
            return {
                errors: [],
            	sendAs: {
		            type: String,
		            default: 'file'
		        },
                avatar: null
            }
        },
        mixins: [
            upload
        ],
        methods: {
            trigger () {
                this.$refs.fileInput.click()
            },
            fileChange (e) {
            	this.errors = []
                this.upload(e).then((response) => {
                    this.avatar = response.data.data
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