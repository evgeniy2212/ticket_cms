<template>
    <div class="vue_component__upload--image" v-bind:class="{ 'dragover': onDragover }">
        <form v-bind:id="'upload_image_form--' + input_id" enctype="multipart/form-data">
            <div class="upload_image_form__thumbnails">
                <div v-for="(value, key) in files" class="upload_image_form__thumbnail"
                     v-on:dblclick="fileClick($event, key)"
                     v-bind:class="{
                             'main-image' : value ? value.id === getImageId : 0,
                             'uploaded': value ? value.uploaded : false,
                             'bad-size': value ? value.bad_size : false
                         }">
                    <span v-on:click="fileDelete($event, key)"> &#x2716;</span>
                    <img v-bind:src="image[key]" v-bind:class="{ 'show': image[key]}">
                    <small v-if="value.bad_size">Великий обсяг файлу</small>
                    <small v-if="!value.id">Невідповідний формат файлу</small>
                </div>
            </div>
            <input type="file" v-bind:id="'upload_image_form__input--' + input_id" hidden multiple/>
            <div>
                <button type="submit"
                        v-bind:class="button_class"
                        v-on:click="submit"
                        v-bind:disabled="onUploading"
                        v-html="button_html"></button>
            </div>
        </form>
    </div>
</template>

<script>

    import draggable from 'vuedraggable'
    import {mapGetters} from "vuex";

    export default {
        name:       'upload-image',
        props:      {
            block:             {
                type:     Object,
                required: false,
            },
            input_id:          {
                type:     String,
                required: false,
                default:  "default"
            },
            name:              {
                type:     String,
                required: false,
                default:  'images[]'
            },
            max_files:         {
                type:     Number,
                required: false,
                default:  10
            },
            max_filesize:      {
                type:     Number,
                required: false,
                default:  6000
            },
            resize_enabled:    {
                type:     Boolean,
                required: false,
                default:  false
            },
            resize_max_width:  {
                type:     Number,
                required: false,
                default:  800
            },
            resize_max_height: {
                type:     Number,
                required: false,
                default:  600
            },
            button_html:       {
                type:     String,
                required: false,
                default:  'Upload photo'
            },
            button_class:      {
                type:     String,
                required: false,
                default:  'btn btn-primary'
            },
        },
        components: {
            draggable
        },
        data:       function () {
            return {
                form:         null,
                input:        null,
                index:        0,
                total:        0,
                files:        [],
                image:        [],
                initedImages: false,
                onDragover:   false,
                onUploading:  false
            }
        },
        mounted:    function () {
            this.form = document.getElementById('upload_image_form--' + this.input_id);
            this.input = document.getElementById('upload_image_form__input--' + this.input_id);

            [
                'drag', 'dragstart', 'dragend',
                'dragover', 'dragenter', 'dragleave', 'drop'
            ].forEach(event => this.form.addEventListener(event, (e) => {
                e.preventDefault();
                e.stopPropagation();
            }));

            ['dragover', 'dragenter']
                .forEach(event => this.form.addEventListener(event, this.dragEnter));

            ['dragleave', 'dragend', 'drop']
                .forEach(event => this.form.addEventListener(event, this.dragLeave));

            ['drop']
                .forEach(event => this.form.addEventListener(event, this.fileDrop));

            ['change']
                .forEach(event => this.input.addEventListener(event, this.fileDrop));

        },
        methods:    {
            _can_upload_file(key) {
                let file = this.files[key];

                if (file.attempted || file.bad_size) {
                    return false;
                }
                return true;
            },
            submit:     function (e) {
                e.preventDefault();
                e.stopPropagation();
                this.$emit('upload-image-submit', this.files);

                this.input = document.getElementById('upload_image_form__input--' + this.input_id);
                this.input.click();
            },
            dragEnter:  function (e) {
                e.preventDefault();
                this.onDragover = true;
            },
            dragLeave:  function (e) {
                e.preventDefault();
                this.onDragover = false;
            },
            fileDrop:   function (e) {
                e.preventDefault();
                let newFiles = e.target.files || e.dataTransfer.files;
                for (let i = 0; i < newFiles.length; i++) {
                    this.$set(this.files, this.index, newFiles[i]);
                    if (newFiles[i].type.match(/image.*/)) {
                        this.fileInit(this.index);
                        this.fileRead(this.index);
                        if (this.index + 1 < this.max_files) {
                            this.index++;
                        }
                    }
                }
                e.target.value = '';
            },
            fileInit:   function (key) {
                let file = this.files[key];
                let uid = Math.floor(Math.random() * 10000) + 1;
                this.files[key] = {
                    name: this.files[key].name,
                    file: this.files[key],
                    id:   uid,
                };
                if ((file.size * 0.001) > this.max_filesize) {
                    this.$set(this.files[key], 'bad_size', true);
                }
            },
            fileRead:   function (key) {
                let reader = new FileReader();

                reader.addEventListener("load", (e) => {
                    this.$set(this.image, key, reader.result);
                    let imager = new Image();
                    imager.onload = () => {
                        if (this._can_upload_file(key)) {
                            this.$emit('upload-image-loaded', {
                                file: reader.result,
                                name: this.files[key].name,
                                id:   this.files[key].id
                            });
                        }
                    };
                    imager.src = reader.result;
                });

                reader.readAsDataURL(this.files[key].file);
            },
            fileDelete: function (e, key) {
                this.$emit('upload-image-removed', this.files[key]);
                this.$delete(this.files, key);
                if(this.image && this.image[key]){
                    this.$delete(this.image, key);
                    this.index--;
                }
            },
            fileClick:  function (e, key) {
                e.preventDefault();
                e.stopPropagation();
                if (!this.files[key].id) {
                    return
                }
                $('.upload_image_form__thumbnail').removeClass('main-image')
                $(e.target).parents('.upload_image_form__thumbnail').addClass('main-image')
                this.$emit('upload-image-clicked', this.files[key]);
            }
        },
        watch:      {
            block: {
                immediate: true,
                handler(block) {
                    if (!this.initedImages) {
                        for (let index in block.block_items) {
                            if (block.block_items[index]['id']) {
                                let link = this.isParsed
                                           ? '/' + block.block_items[index]['name']
                                           : '/storage/news/' + this.getNewsId + '/' + block.block_items[index]['name'];
                                this.files[index] = {
                                    id:   block.block_items[index]['id'],
                                    name: block.block_items[index]['name'],
                                };
                                this.image[index] = link;
                            }
                            this.index++;
                        }
                        this.initedImages = true;
                    }
                },
                deep:      true
            }
        },
        computed:   {
            ...mapGetters([
                              'getImageId',
                              'getNewsId',
                              'isParsed'
                          ])
        }
    }
</script>

<style lang="css" scoped>
    .vue_component__upload--image {
        padding: 5px;
        cursor: pointer;
        min-height: 200px;
        border-radius: 5px;
        border: 1px solid blue;
    }

    .main-image {
        border: 5px dotted red;
    }

    .vue_component__upload--image.dragover {
    }

    .vue_component__upload--image form > div {
        text-align: center;
    }

    .vue_component__upload--image .upload_image_form__thumbnails {
        margin-bottom: 1em;
        min-height: 200px;
    }

    .vue_component__upload--image .upload_image_form__thumbnail {
        border-radius: 2.5px;
        position: relative;
        width: 20%;
        padding: 20% 0 0;
        overflow: hidden;
        margin: 10px;
        display: inline-block;
        min-height: 150px;
        min-width: 150px;
    }

    .vue_component__upload--image .upload_image_form__thumbnail img {
        position: absolute;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        max-height: 150%;
        opacity: 0;
        transform: translateX(-50%) translateY(-50%);
        transition: 1s opacity;
    }

    .vue_component__upload--image .upload_image_form__thumbnail img.show {
        opacity: 1;
    }

    .vue_component__upload--image .upload_image_form__thumbnail img:hover {
        filter: blur(2px);
    }

    .vue_component__upload--image .upload_image_form__thumbnail.bad-size img {
        filter: grayscale(100%);
    }

    .vue_component__upload--image .upload_image_form__thumbnail.uploaded img {
        opacity: 0.1;
    }

    .vue_component__upload--image .upload_image_form__thumbnail span {
        position: absolute;
        top: -5px;
        left: 0px;
        z-index: 100;
        padding: 0px 1px;
        border-radius: 2px;
        background-color: grey;
    }
    .vue_component__upload--image .upload_image_form__thumbnail small {
        position: absolute;
        bottom: 0;
        left: 40px;
        padding: 2px;
        z-index: 100;
        color:white;
        background-color: red;
    }

    .under-image {
        top: -10px;
    }
</style>
