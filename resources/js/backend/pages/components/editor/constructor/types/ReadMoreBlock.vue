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
    name: "read-more-block",
    props:{
        block: Object
    },
    data() {
        return {
            data: {
            }
        }
    },
    methods: {
        updateBlock() {
            this.$emit('update', this.data)
        }
    }
}
</script>

<style scoped>

</style>
