<template>
    <div class="content-box">
        <div class="control-header">
            <div class="row align-items-center">
                <div class="col-8 col-lg-7">
                    <div class="form-group mr-4">
                        <label class="mr-2">Users</label>
                    </div>
                </div>
                <div class="col-4 col-lg-5 text-right">
                    <router-link class="btn btn-sm btn-primary btn-upper" to="/new-user">
                        <i class="os-icon os-icon-ui-22"></i>
                        <span>Add User</span>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .pipeline.white .pipeline-item{
        cursor: auto;
    }
    .pipeline-item .pi-foot .tags .tag{
        border: 1px solid #04780000;
    }
</style>
