<template>
    <div>
        <small class="text-muted">{{ bodyCount }} / {{ getLimitBody }}</small>
        <textarea @blur="updateBlock"
                  @keyup="validateBody"
                  class="form-control" placeholder="Текст параграфу" rows="3" v-model="block.body"></textarea>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name:     "paragraph",
        props:    {
            block: Object
        },
        data() {
            return {}
        },
        methods:  {
            updateBlock() {
                this.$emit('update', {body: this.block.body})
            },
            validateBody() {
                return this.block.body = this.block.body.substr(0, this.getLimitBody);
            },
        },
        computed: {
            bodyCount() {
                return this.block && this.block.body ? this.block.body.length : 0;
            },
            ...mapGetters([
                              'getLimitBody',
                          ]),
        }
    }
</script>

<style scoped>

</style>
