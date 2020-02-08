<template>
    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-info">{{book.subtotal}}</div>
</template>

<script>
export default {
    props:{
        book:{
            required:true,
            type:Object
        }
    },
    computed: {
        // total: function(){
        //     return this.book.reduce(function(sum, budge){
        //         return sum + book.subtotal;
        //     },0);
        // },
    },
}
</script>

<style>

</style>