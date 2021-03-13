<template>
    <div>
        <small class="text-muted">{{ fieldLength }} / {{ getLimitBody }}</small>
        <editor
            @blur="updateField"
            :options="this.defaultOptions"
            v-model="html"
            ref="tuiEditor"
            @change="onEditorChange"
        >
        </editor>
    </div>
</template>

<script>
    import {Editor} from '@toast-ui/vue-editor'
    import {mapGetters} from "vuex";

    export default {
        props:      {
            field: Object
        },
        data() {
            return {
                html:           '',
                fieldLength:    0,
                loaded:         false,
                defaultOptions: {
                    minHeight:               '200px',
                    language:                'en-US',
                    useCommandShortcut:      true,
                    useDefaultHTMLSanitizer: true,
                    usageStatistics:         true,
                    hideModeSwitch:          false,
                    toolbarItems:            [
                        'heading',
                        'bold',
                        'italic',
                        'strike',
                        'divider',
                        'hr',
                        'quote',
                        'divider',
                        'ul',
                        'ol',
                        'task',
                        'indent',
                        'outdent',
                        'divider',
                        // 'table',
                        // 'image',
                        'link',
                        'divider',
                        'code',
                        'codeblock'
                    ]
                }
            }
        },
        components: {
            editor: Editor
        },
        methods:    {
            updateField() {
                this.$emit('update', {body: this.getHtml()})
            },
            getHtml() {
                return this.$refs.tuiEditor ? this.$refs.tuiEditor.invoke('getHtml') : "";
            },
            setHtml(html) {
                this.$refs.tuiEditor.invoke('setHtml', html.substr(0, this.getLimitBody))
            },
            onEditorChange() {
                if (!this.loaded) {
                    this.setHtml(this.field.body);
                    this.loaded = true;
                }
                this.fieldLength = this.getHtml().length;
            },
        },
        computed:   {
            ...mapGetters([
                              'getLimitBody',
                          ]),
        }
    }
</script>

<style lang="scss">
    .tui-editor-contents p,
    .te-editor .CodeMirror pre.CodeMirror-line,
    .te-editor .CodeMirror pre.CodeMirror-line-like {
        font-size: 18px;
    }
    @import '~codemirror/lib/codemirror.css';
    @import '~@toast-ui/editor/dist/toastui-editor.css';
</style>
