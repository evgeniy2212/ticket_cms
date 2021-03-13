<template>
    <div class="card border-light mb-2">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span class="btn btn-link drag">
                        <span class="fa fa-bars"></span>
                    </span>
                    <span class="text-muted">{{ field.name }}</span>
                </div>
                <div class="col-7 mt-2 text-right custom-control custom-checkbox">
                    <input type="checkbox"
                           v-model="field.visible"
                           class="custom-control-input"
                           :id="'visible-' + field.uid">
                    <label class="custom-control-label" :for="'visible-' + field.uid">Show</label>
                </div>
                <div class="col-1 text-right">
                    <a @click.prevent="deleteCurrentField" class="btn btn-link text-danger" href="">
                        <span class="fa fa-times-circle"></span>
                    </a>
                </div>
                <div class="col-12">
                    <component :field="field"
                               @update-news="updatePages"
                               @update="updateCurrentField"
                               :is="field.component + '-field'"></component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import ParagraphField from './types/ParagraphField';
    import Html5Field from './types/Html5Field';
    import HeaderField from './types/HeaderField';
    import ListField from './types/ListField';
    import OpinionField from './types/OpinionField';
    import QuoteField from './types/QuoteField';
    import SpoilerField from './types/SpoilerField';
    import SliderField from './types/SliderField';
    import ReadMoreField from './types/ReadMoreField';
    import FileField from './types/FileField';
    import IframeField from './types/IframeField';
    import {mapMutations} from 'vuex';

    export default {
        name:       "field",
        props:      {
            field: Object
        },
        components: {
            ParagraphField,
            Html5Field,
            HeaderField,
            ListField,
            OpinionField,
            QuoteField,
            SliderField,
            ReadMoreField,
            SpoilerField,
            IframeField,
            FileField
        },
        methods:    {
            ...mapMutations([
                                'deleteField',
                                'updateField',
                                'setImage',
                            ]),
            deleteCurrentField() {
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
                        this.deleteField(this.field);
                    }
                });
            },
            updateCurrentField(value) {
                this.updateField({
                                     field: this.field,
                                     value: value
                                 })
            },
            updatePages(value) {
                this.setImage(value)
            }
        }
    }
</script>
