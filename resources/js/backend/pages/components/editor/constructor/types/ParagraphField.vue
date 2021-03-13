<template>
    <div>
        <small class="text-muted">{{ bodyCount }} / {{ getLimitBody }}</small>
        <textarea @blur="updateField"
                  @keyup="validateBody"
                  class="form-control" placeholder="Текст параграфу" rows="3" v-model="field.body"></textarea>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name:     "paragraph",
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
                return this.field.body = this.field.body.substr(0, this.getLimitBody);
            },
        },
        computed: {
            bodyCount() {
                return this.field && this.field.body ? this.field.body.length : 0;
            },
            ...mapGetters([
                              'getLimitBody',
                          ]),
        }
    }
</script>

<style scoped>

</style>
