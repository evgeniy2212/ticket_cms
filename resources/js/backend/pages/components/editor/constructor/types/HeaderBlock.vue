<template>
    <div>
        <small class="text-muted">{{ bodyCount }} / {{ getDefaultLimit }}</small>
        <textarea @blur="updateBlock"
               @keyup="validateBody"
               class="form-control" type="text" value="header"rows="3" v-model="block.body">
        </textarea>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
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
            return this.block.body = this.block.body.substr(0, this.getDefaultLimit);
        },
    },
    computed: {
        bodyCount() {
            return this.block && this.block.body ? this.block.body.length : 0;
        },
        ...mapGetters([
                          'getDefaultLimit',
                      ]),
    }
}
</script>

<style scoped>

</style>
