export default {
    props: {
        endpoint: {
            type: String
        }
    },
    data () {
        return {
            uploading: false
        }
    },
    methods: {
        upload (e) {
            this.uploading = true
            this.sendAs = "images"

            return axios.post(this.endpoint, this.packageUploads(e)).then((response) => {
                this.uploading = false
                return Promise.resolve(response)
            }).catch((error) => {
                this.uploading = false
                return Promise.reject(error)
            })
        },
        packageUploads (e) {
            let fileData = new FormData()
            const array = e.target.files;
            for (let i = 0; i < array.length; i++) {
                // console.log(array[i])
                fileData.append(`images[${[i]}]`, array[i])
            }
            // fileData.append(this.sendAs, array)
            return fileData
        }
    }
}