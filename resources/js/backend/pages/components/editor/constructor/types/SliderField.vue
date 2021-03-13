<template>
    <div class="row">
        <div class="col-12">
            <div class="custom-control">
                <label :for="'name' + field.uid.toString()">
                    <span>Name</span>
                    <small class="text-muted">{{ titleCount }} / {{ getLimit }}</small>
                </label>
                <input @change="updateField"
                       @keyup="validateTitle"
                       class="form-control mb-2" :id="'name' + field.uid.toString()" v-model="field.title" type="text">
            </div>
            <div class="custom-control">
                <label :for="'res' + field.uid.toString()">Sizes</label>
                <select :id="'res' + field.uid.toString()"
                        @change="updateField"
                        class="form-control mb-2"
                        v-model="field.resolutionKey">
                    <option v-for="(name, key) in getResolutionList"
                            :value="key">
                        {{ name }}
                    </option>
                </select>
            </div>
            <div class="pl-5 pb-2 custom-control custom-checkbox">
                <input @change="updateField"
                       type="checkbox"
                       v-model="field.boolean"
                       class="custom-control-input"
                       :id="field.uid">
                <label class="custom-control-label" :for="field.uid">
                    {{ field.boolean ? 'Left cut' : 'Right cut' }}
                </label>
            </div>
            <upload-image is="upload-image"
                          :input_id="field.uid.toString()"
                          :field="field"
                          v-on:upload-image-loaded="uploadImageLoaded"
                          v-on:upload-image-clicked="uploadImageClicked"
                          v-on:upload-image-removed="uploadImageRemoved">
            </upload-image>
        </div>
    </div>
</template>

<script>
    import UploadImage from '../UploadImage';
    import {mapGetters} from "vuex";

    export default {
        components: {
            UploadImage
        },
        props:      {
            field: Object
        },
        methods:    {
            updateField() {
                this.$emit('update', this.field)
            },
            uploadImageLoaded:  function (file) {
                this.field.field_items.push(file);
                this.updateField();
            },
            uploadImageClicked: function (file) {
                this.$emit('update-news', file)
            },
            uploadImageRemoved: function (file) {
                this.field.field_items = this.field.field_items.filter(function (item) {
                    return item.name !== file.name;
                })
                this.updateField();
            },
            validateTitle() {
                return this.field.title = this.field.title.substr(0, this.getLimit);
            },
        },
        computed:   {
            ...mapGetters([
                              'getResolutionList',
                              'getErrors',
                              'getLimit',
                          ]),
            titleCount() {
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
