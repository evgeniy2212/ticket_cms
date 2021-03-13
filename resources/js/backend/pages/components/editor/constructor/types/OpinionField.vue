<template>
    <div class="row">
        <div class="col-4">
            <label for="">
                Author photo
            </label>
            <upload-image is="upload-image"
                          :input_id="field.uid.toString()"
                          :field="field"
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
                                  v-model="field.body"></textarea>
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
        field: Object
    },
    components: {
        UploadImage
    },
    methods: {
        updateField() {
            this.$emit('update', this.field)
        },
        uploadImageLoaded : function (file) {
            this.field.field_items.push(file);
            this.field.resolutionKey = 'opinion';
            this.updateField();
        },
        uploadImageClicked: function (file) {
            this.$emit('update-news', file)
        },
        uploadImageRemoved: function (file) {
            this.field.field_items =  this.field.field_items.filter(function (item) {
                return item.name !== file.name;
            })
            this.updateField();
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
