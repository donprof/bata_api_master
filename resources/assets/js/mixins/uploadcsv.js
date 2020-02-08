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
            this.sendAs = "products"

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
            fileData.append(this.sendAs, e.target.files[0])
            return fileData
        }
        // packageUploads (e) {
        //     let fileData = new FormData()
        //     const array = e.target.files;
        //     for (let i = 0; i < array.length; i++) {
        //         fileData.append(`images[${[i]}]`, array[i])
        //     }
        //     return fileData
        // }
    }
}