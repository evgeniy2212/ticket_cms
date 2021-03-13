<template>
    <div class="row">
        <div class="col-12">
            <label :for="'name' + field.uid.toString()">
                Назва
                <small class="text-muted">{{ nameCount }} / {{ getLimit }}</small>
            </label>
            <input @change="updateField"
                   @keyup="validateName"
                   class="form-control mb-2"
                   :id="'name' + field.uid.toString()"
                   v-model="field.title"
                   type="text">
        </div>
        <div class="col-12">
            <label :for="'url' + field.uid.toString()">
                Урл
                <small class="text-muted">{{ urlCount }} / {{ getDefaultLimit }}</small>
            </label>
            <input @change="updateField"
                   @keyup="validateUrl"
                   class="form-control mb-2"
                   :id="'url' + field.uid.toString()"
                   v-model="field.subtitle"
                   type="text">
        </div>
        <div class="col-12">
            <label :for="'res' + field.uid.toString()">Sizes</label>
            <select :id="'res' + field.uid.toString()"
                    @change="updateField"
                    class="form-control mb-2"
                    v-model="field.resolutionKey">
                <option v-for="(name, key) in getResolutionList" :value="key">{{ name }}</option>
            </select>
        </div>
    </div>
</template>

<script>

import {mapGetters} from "vuex";

export default {
    props  : {
        field: Object
    },
    methods: {
        updateField() {
            this.$emit('update', this.field)
        },
        validateUrl() {
            return this.field.subtitle = this.field.subtitle.substr(0, this.getDefaultLimit);
        },
        validateName() {
            return this.field.title = this.field.title.substr(0, this.getLimit);
        },
    },
    computed: {
        ...mapGetters([
            'getResolutionList',
            'getLimit',
            'getDefaultLimit',
        ]),
        urlCount() {
            return this.field && this.field.subtitle ? this.field.subtitle.length : 0;
        },
        nameCount() {
            return this.field && this.field.title ? this.field.title.length : 0;
        },
    },
    mounted() {
        this.field.resolutionKey = this.field.resolutionKey ? this.field.resolutionKey : 'lg';
    }
}
</script>

<style scoped>

</style>
