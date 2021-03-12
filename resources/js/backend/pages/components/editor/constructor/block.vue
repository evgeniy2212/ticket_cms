<template>
    <div class="card border-light mb-2">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span class="btn btn-link drag">
                        <span class="fa fa-bars"></span>
                    </span>
                    <span class="text-muted">{{ block.name }}</span>
                </div>
                <div class="col-7 mt-2 text-right custom-control custom-checkbox">
                    <input type="checkbox"
                           v-model="block.visible"
                           class="custom-control-input"
                           :id="'visible-' + block.uid">
                    <label class="custom-control-label" :for="'visible-' + block.uid">Show</label>
                </div>
                <div class="col-1 text-right">
                    <a @click.prevent="deleteCurrentBlock" class="btn btn-link text-danger" href="">
                        <span class="fa fa-times-circle"></span>
                    </a>
                </div>
                <div class="col-12">
                    <component :block="block"
                               @update-news="updatePages"
                               @update="updateCurrentBlock"
                               :is="block.component + '-block'"></component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import ParagraphBlock from './types/ParagraphBlock';
    import Html5Block from './types/Html5Block';
    import HeaderBlock from './types/HeaderBlock';
    import ListBlock from './types/ListBlock';
    import OpinionBlock from './types/OpinionBlock';
    import QuoteBlock from './types/QuoteBlock';
    import SpoilerBlock from './types/SpoilerBlock';
    import SliderBlock from './types/SliderBlock';
    import ReadMoreBlock from './types/ReadMoreBlock';
    import FileBlock from './types/FileBlock';
    import IframeBlock from './types/IframeBlock';
    import {mapMutations} from 'vuex';

    export default {
        name:       "block",
        props:      {
            block: Object
        },
        components: {
            ParagraphBlock,
            Html5Block,
            HeaderBlock,
            ListBlock,
            OpinionBlock,
            QuoteBlock,
            SliderBlock,
            ReadMoreBlock,
            SpoilerBlock,
            IframeBlock,
            FileBlock
        },
        methods:    {
            ...mapMutations([
                                'deleteBlock',
                                'updateBlock',
                                'setImage',
                            ]),
            deleteCurrentBlock() {
                this.$swal({
                               title:               'Are you sure that you want to delete?',
                               type:                'warning',
                               showCancelButton:    true,
                               confirmButtonText:   'Yes',
                               cancelButtonText:    'No',
                               showCloseButton:     true,
                               showLoaderOnConfirm: true
                           }).then((result) => {
                    if (result.value) {
                        this.deleteBlock(this.block);
                    }
                });
            },
            updateCurrentBlock(value) {
                this.updateBlock({
                                     block: this.block,
                                     value: value
                                 })
            },
            updatePages(value) {
                this.setImage(value)
            }
        }
    }
</script>
