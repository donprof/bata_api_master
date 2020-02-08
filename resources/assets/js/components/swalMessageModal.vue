<template>
    <div class="customsweet mr-auto ml-auto animated bounceIn faster">
        <div :class="swalbottomclass" class="darkone">
            <div :class="swaltopclass" class="greenone ml-auto mr-auto">
                <div class="row pt-4">
                    <h1 :class="swalicon" class="text-white mr-auto ml-auto customicon mb-4"></h1>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="text-white mb-3">{{title}}</h3>
                        <h6 class="text-white px-1">{{message}}</h6>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <div class="col-6 mr-auto ml-auto text-center">
                    <button @click.prevent="closeMessageSwal" class="ctbutton btn-danger" type="submit">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Bus from '../bus'
    export default {
        props:{
            title:{
                required: true,
                type: String
            },
            message:{
                required: true,
                type: String
            },
            swaltopclass:{
                required: true,
                type: String
            },
            swalbottomclass:{
                required: true,
                type: String
            },
            swalicon:{
                required: true,
                type: String
            }
        },
        methods:{
            closeMessageSwal: function () {
                Bus.$emit('close-message-swal')
            }
        },
        // mounted (){
        //     window.addEventListener('keyup', event => {
        //         if (event.keyCode === 13) { 
        //             this.closeMessageSwal()
        //         }
        //     })
        // }
    }
</script>