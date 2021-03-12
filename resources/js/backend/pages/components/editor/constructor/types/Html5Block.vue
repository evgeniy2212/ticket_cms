<template>
    <div>
        <small class="text-muted">{{ blockLength }} / {{ getLimitBody }}</small>
        <editor
            @blur="updateBlock"
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
            block: Object
        },
        data() {
            return {
                html:           '',
                blockLength:    0,
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
            updateBlock() {
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
                    this.setHtml(this.block.body);
                    this.loaded = true;
                }
                this.blockLength = this.getHtml().length;
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
