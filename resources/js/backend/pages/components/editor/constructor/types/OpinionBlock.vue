<template>
    <div class="row">
        <div class="col-4">
            <label for="">
                Author photo
            </label>
            <upload-image is="upload-image"
                          :input_id="block.uid.toString()"
                          :block="block"
                          :max_files="1"
                          v-on:upload-image-loaded="uploadImageLoaded"
                          v-on:upload-image-clicked="uploadImageClicked"
                          v-on:upload-image-removed="uploadImageRemoved"
            ></upload-image>
        </div>
        <div class="col-8">
            <div class="row">
<!--                <div class="col-12">-->
<!--                    <div class="form-group">-->
<!--                        <input class="form-control form-control-sm" placeholder="Iм`я автора думки" type="text"-->
<!--                               v-model="block.title">-->
<!--                    </div>-->
<!--                </div>-->
                <div class="col-12">
                    <div class="form-group">
                        <small class="text-muted">{{ bodyCount }} / {{ getDefaultLimit }}</small>
                        <textarea @keyup="validateBody" class="form-control form-control-sm" placeholder="Думка" rows="3"
                                  v-model="block.body"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UploadImage from "../UploadImage";
import {mapGetters} from "vuex";

export default {
    props  : {
        block: Object
    },
    components: {
        UploadImage
    },
    methods: {
        updateBlock() {
            this.$emit('update', this.block)
        },
        uploadImageLoaded : function (file) {
            this.block.block_items.push(file);
            this.block.resolutionKey = 'opinion';
            this.updateBlock();
        },
        uploadImageClicked: function (file) {
            this.$emit('update-news', file)
        },
        uploadImageRemoved: function (file) {
            this.block.block_items =  this.block.block_items.filter(function (item) {
                return item.name !== file.name;
            })
            this.updateBlock();
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
