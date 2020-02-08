<template>
    <div class="todo-list">
        <span class="todo-item complete">
            <div class="ti-info">
                <div class="ti-header">{{title}}</div>
                <div class="ti-sub-header">{{detail}}</div>
            </div>
            <div class="ti-icon">
                <i :class="icon"></i>
            </div>
        </span>
    </div>
</template>
<script>
    import Bus from '../bus'
    import moment from 'moment'
    export default {
        props:[ 'title','detail','icon' ],
    }
</script>