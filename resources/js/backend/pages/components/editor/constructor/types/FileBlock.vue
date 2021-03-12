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
            <a :href="block.subtitle" download>Upload File</a>
        </div>
        <div class="col-12">
            <vue-dropzone :ref="'dropzone_' + block.uid.toString()"
                          @vdropzone-file-added="addedfile"
                          id="customdropzone"
                          :options="dropzoneOptions">
            </vue-dropzone>
        </div>
    </div>
</template>

<script>

    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import {mapGetters} from "vuex";

    export default {
        name:       "file-block",
        props:      {
            block: Object
        },
        components: {
            vueDropzone: vue2Dropzone
        },
        data() {
            return {
                files:           [],
                dropzoneOptions: {
                    url:                  'empty',
                    autoProcessQueue:     false,
                    maxFilesize:          25,
                    thumbnailWidth:       150,
                    acceptedFiles:        'application/pdf',
                    maxFiles:             1,
                    addRemoveLinks:       true,
                    uploadMultiple:       false,
                    dictMaxFilesExceeded: "You may download only one file"
                }
            }
        },
        methods:    {
            validateName() {
                return this.block.title = this.block.title.substr(0, this.getLimit);
            },
            addedfile(file) {
                this.files.push(file);
                if (this.files.length > 1) {
                    let dropzoneId = 'dropzone_' + this.block.uid.toString();
                    let files = this.$refs[dropzoneId].removeFile(this.files[0]);
                    this.files.splice(0, 1);
                }
                var reader = new FileReader();
                var self = this;
                reader.addEventListener("loadend", function (event) {
                    self.block.file = event.target.result;
                    self.block.filename = file.name;
                    self.updateBlock();
                });
                reader.readAsDataURL(file);
            },
            updateBlock() {
                this.$emit('update', this.data)
            }
        },
        computed:   {
            ...mapGetters([
                              'getLimit',
                              'getResolutionList',
                          ]),
            nameCount() {
                return this.block && this.block.title ? this.block.title.length : 0;
            },
        },
        mounted() {
            this.block.resolutionKey = this.block.resolutionKey ? this.block.resolutionKey : 'lg';
        }
    }
</script>

<style>
    #customdropzone {
        font-family: 'Arial', sans-serif;
        letter-spacing: 0.2px;
        color: #777;
        transition: background-color .2s linear;
        height: 220px;
        width: 200px;
        padding: 5px;
    }

    #customdropzone .dz-preview {
        width: 160px;
        height: 85%;
        display: inline-block
    }

    #customdropzone .dz-preview.dz-file-preview {
        min-height: 180px;
    }

    #customdropzone .dz-preview .dz-image {
        width: 80px;
        height: 80px;
        margin-left: 40px;
        margin-bottom: 10px;
    }

    #customdropzone .dz-preview .dz-image > div {
        width: inherit;
        height: inherit;
        border-radius: 50%;
        background-size: contain;
    }

    #customdropzone .dz-preview .dz-image > img {
        width: 100%;
    }

    #customdropzone .dz-preview .dz-details {
        color: white;
        transition: opacity .2s linear;
        text-align: center;
    }

    #customdropzone .dz-progress {
        display: none;
    }

    #customdropzone .dz-error-message {
        top: 120px;
    }

    #customdropzone .dz-preview .dz-remove {
        bottom: 65px;
        opacity: 0;
    }
</style>
