<template>
    <div class="row">
        <div class="col-12">
            <div class="custom-control">
                <label :for="'name' + block.uid.toString()">
                    <span>Name</span>
                    <small class="text-muted">{{ titleCount }} / {{ getLimit }}</small>
                </label>
                <input @change="updateBlock"
                       @keyup="validateTitle"
                       class="form-control mb-2" :id="'name' + block.uid.toString()" v-model="block.title" type="text">
            </div>
            <div class="custom-control">
                <label :for="'res' + block.uid.toString()">Sizes</label>
                <select :id="'res' + block.uid.toString()"
                        @change="updateBlock"
                        class="form-control mb-2"
                        v-model="block.resolutionKey">
                    <option v-for="(name, key) in getResolutionList"
                            :value="key">
                        {{ name }}
                    </option>
                </select>
            </div>
            <div class="pl-5 pb-2 custom-control custom-checkbox">
                <input @change="updateBlock"
                       type="checkbox"
                       v-model="block.boolean"
                       class="custom-control-input"
                       :id="block.uid">
                <label class="custom-control-label" :for="block.uid">
                    {{ block.boolean ? 'Left cut' : 'Right cut' }}
                </label>
            </div>
            <upload-image is="upload-image"
                          :input_id="block.uid.toString()"
                          :block="block"
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
            block: Object
        },
        methods:    {
            updateBlock() {
                this.$emit('update', this.block)
            },
            uploadImageLoaded:  function (file) {
                this.block.block_items.push(file);
                this.updateBlock();
            },
            uploadImageClicked: function (file) {
                this.$emit('update-news', file)
            },
            uploadImageRemoved: function (file) {
                this.block.block_items = this.block.block_items.filter(function (item) {
                    return item.name !== file.name;
                })
                this.updateBlock();
            },
            validateTitle() {
                return this.block.title = this.block.title.substr(0, this.getLimit);
            },
        },
        computed:   {
            ...mapGetters([
                              'getResolutionList',
                              'getErrors',
                              'getLimit',
                          ]),
            titleCount() {
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
