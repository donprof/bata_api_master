<template>
	<div>
        <input type="file" v-on:change="fileChange" :name="sendAs" class="form-control">
        <div v-if="uploading">Processing</div>
        <ul class="parsley-errors-list filled" id="parsley-id-4" v-if="errors[this.sendAs]">
            <li class="parsley-required">{{ errors[this.sendAs][0] }}</li>
        </ul>
	</div>
</template>

<script>
    import upload from '../mixins/upload'
    import Bus from '../../../bus'

    export default {
        props: [
            'currentAvatar',
            'user'
        ],
        data () {
            return {
                errors: [],
            	sendAs: {
		            type: String,
		            default: 'file'
		        },
                avatar: {
                    id: null,
                    path: this.currentAvatar
                }
            }
        },
        mixins: [
            upload
        ],
        methods: {
            fileChange (e) {
            	this.errors = []
                this.upload(e).then((response) => {
                    this.avatar = response.data.data
                    Bus.$emit('image-upload-switch'+this.user, response.data.data.path)
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