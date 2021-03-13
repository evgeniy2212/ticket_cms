<template>
    <div>
        <small class="text-muted">{{ bodyCount }} / {{ getDefaultLimit }}</small>
        <textarea @blur="updateField"
               @keyup="validateBody"
               class="form-control" type="text" value="header"rows="3" v-model="field.body">
        </textarea>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    props:    {
        field: Object
    },
    data() {
        return {}
    },
    methods:  {
        updateField() {
            this.$emit('update', {body: this.field.body})
        },
        validateBody() {
            return this.field.body = this.field.body.substr(0, this.getDefaultLimit);
        },
    },
    computed: {
        bodyCount() {
            return this.field && this.field.body ? this.field.body.length : 0;
        },
        ...mapGetters([
                          'getDefaultLimit',
                      ]),
    }
}
</script>

<style scoped>

</style>
