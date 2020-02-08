<template>
    <div class="form-text text-danger animated zoomIn faster small">
        <ul class="list-unstyled">
            <li>{{error}}</li>
        </ul>
    </div>
</template>
<script>
    export default {
        props:{
            error:{
                required: true,
                type: String
            }
        }
    }
</script>
