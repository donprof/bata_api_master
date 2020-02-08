<template>
    <div class="col-md-12 mr-auto ml-auto">
        <ul class="pagination pagination-primary">
            <li class="page-item" :class="{'disabled': meta.current_page == 1 }">
                <a href="javascript:void(0);" class="page-link" @click.prevent="switched(meta.current_page - 1)"> Prev</a>
            </li>
            <template v-if="section > 1">
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" @click.prevent="switched(1)">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" @click.prevent="goBackASection">...</a>
                </li>
            </template>

            <li class="page-item" v-for="page in pages" :key="page.id" :class="{'active':page === meta.current_page }">
                <a class="page-link" v-if="meta.current_page === page" href="javascript:void(0);">{{page}}</a>
                <a v-else class="page-link" href="javascript:void(0);" @click.prevent="switched(page)">{{page}}</a>
            </li>

            <template v-if="section < sections">
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" @click.prevent="goForwardASection">...</a>
                </li>

                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" @click.prevent="switched(meta.last_page)">{{meta.last_page}}</a>
                </li>
            </template>
            <li class="page-item" :class="{'disabled': meta.current_page === meta.last_page }">
                <a class="page-link" href="javascript:void(0);" @click.prevent="switched(meta.current_page + 1)">Next</a>
            </li>
        </ul>
    <div class="btn btn-sm btn-primary footercounter">{{ meta.total }}</div>
    </div>
</template>
<script>
  import Bus from '../bus'
  export default{
        props:{
            meta:{
                required: true,
                type: Object
            },
            busname:{
                required: true,
                type: String
            },
        },
        data(){
            return{
                numbersPerSection: 7
            }
        },
        computed: {
            section(){
                return Math.ceil(this.meta.current_page / this.numbersPerSection)
            },
            sections(){
                return Math.ceil(this.meta.last_page / this.numbersPerSection)
            },
            lastPage(){
                let lastPage = ((this.section - 1) * this.numbersPerSection) + this.numbersPerSection

                if (this.section === this.sections) {
                    lastPage = this.meta.last_page
                }
                return lastPage
            },
            pages(){
                return _.range((this.section - 1) * this.numbersPerSection + 1, this.lastPage + 1)
            }
        },
        methods : {
            switched (page) {
                if (page <= 0 || page > this.meta.last_page) {
                    return
                }
                Bus.$emit(this.busname, page)
            },
            goForwardASection(){
                this.switched(
                    this.firstPageOfSection(this.section + 1)
                )
            },
            goBackASection(){
                this.switched(
                    this.firstPageOfSection(this.section - 1)
                )
            },
            firstPageOfSection(section){
                return (section - 1) * this.numbersPerSection + 1
            }
        }
    }
</script>