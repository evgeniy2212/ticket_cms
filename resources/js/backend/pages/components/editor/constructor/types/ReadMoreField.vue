<template>
    <div class="row">
        <div class="col-4">
<!--            <label for="">TODO</label>-->
<!--            <input id="" name="" type="text">-->
        </div>
    </div>
</template>

<script>
export default {
    name: "read-more-field",
    props:{
        field: Object
    },
    data() {
        return {
            data: {
            }
        }
    },
    methods: {
        updateField() {
            this.$emit('update', this.data)
        }
    }
}
</script>

<style scoped>

</style>
