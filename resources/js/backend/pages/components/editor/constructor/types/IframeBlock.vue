<template>
    <div class="row">
        <div class="col-12">
            <label :for="'name' + block.uid.toString()">
                Назва
                <small class="text-muted">{{ nameCount }} / {{ getLimit }}</small>
            </label>
            <input @change="updateBlock"
                   @keyup="validateName"
                   class="form-control mb-2"
                   :id="'name' + block.uid.toString()"
                   v-model="block.title"
                   type="text">
        </div>
        <div class="col-12">
            <label :for="'url' + block.uid.toString()">
                Урл
                <small class="text-muted">{{ urlCount }} / {{ getDefaultLimit }}</small>
            </label>
            <input @change="updateBlock"
                   @keyup="validateUrl"
                   class="form-control mb-2"
                   :id="'url' + block.uid.toString()"
                   v-model="block.subtitle"
                   type="text">
        </div>
        <div class="col-12">
            <label :for="'res' + block.uid.toString()">Sizes</label>
            <select :id="'res' + block.uid.toString()"
                    @change="updateBlock"
                    class="form-control mb-2"
                    v-model="block.resolutionKey">
                <option v-for="(name, key) in getResolutionList" :value="key">{{ name }}</option>
            </select>
        </div>
    </div>
</template>

<script>

import {mapGetters} from "vuex";

export default {
    props  : {
        block: Object
    },
    methods: {
        updateBlock() {
            this.$emit('update', this.block)
        },
        validateUrl() {
            return this.block.subtitle = this.block.subtitle.substr(0, this.getDefaultLimit);
        },
        validateName() {
            return this.block.title = this.block.title.substr(0, this.getLimit);
        },
    },
    computed: {
        ...mapGetters([
            'getResolutionList',
            'getLimit',
            'getDefaultLimit',
        ]),
        urlCount() {
            return this.block && this.block.subtitle ? this.block.subtitle.length : 0;
        },
        nameCount() {
            return this.block && this.block.title ? this.block.title.length : 0;
        },
    },
    mounted() {
        this.block.resolutionKey = this.block.resolutionKey ? this.block.resolutionKey : 'lg';
    }
}
</script>

<style scoped>

</style>
