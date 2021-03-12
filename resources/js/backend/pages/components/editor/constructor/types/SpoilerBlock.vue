<template>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="title">
                    <span>Spoiler header</span>
                    <small class="text-muted">{{ titleCount }} / {{ getLimit }}</small>
                </label>
                <input @blur="updateBlock"
                       @keyup="validateTitle"
                       id="title"
                       class="form-control form-control-sm"
                       placeholder="Spoiler header"
                       type="text" v-model="block.title">
            </div>
            <div class="form-group">
                <label for="subtitle">
                    <span>Spoiler subheader</span>
                    <small class="text-muted">{{ subtitleCount }} / {{ getLimit }}</small>
                </label>
                <input @blur="updateBlock"
                       @keyup="validateSubtitle"
                       class="form-control form-control-sm"
                       id="subtitle"
                       placeholder="Spoiler subheader"
                       type="text" v-model="block.subtitle">
            </div>
            <div class="form-group">
                <label for="body">
                    <span>Текст спойлеру</span>
                    <small class="text-muted">{{ bodyCount }} / {{ getLimitBody }}</small>
                </label>
                <textarea
                    id="body"
                    @blur="updateBlock"
                    @keyup="validateBody"
                    class="form-control form-control-sm"
                    placeholder="Spoiler text"
                    rows="5"
                          v-model="block.body"></textarea>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name:     "spoiler",
        props:    {
            block: Object
        },
        data() {
            return {}
        },
        methods:  {
            updateBlock() {
                this.$emit('update', this.block)
            },
            validateBody () {
                return this.block.body = this.block.body.substr(0, this.getLimitBody);
            },
            validateTitle () {
                return this.block.title = this.block.title.substr(0, this.getLimit);
            },
            validateSubtitle () {
                return this.block.subtitle = this.block.subtitle.substr(0, this.getLimit);
            },
        },
        computed: {
            titleCount() {
                return this.block && this.block.title ? this.block.title.length : 0;
            },
            subtitleCount() {
                return this.block && this.block.subtitle ? this.block.subtitle.length : 0;
            },
            bodyCount() {
                return this.block && this.block.body ? this.block.body.length : 0;
            },
            ...mapGetters([
                              'getErrors',
                              'getLimit',
                              'getDefaultLimit',
                              'getLimitBody',
                          ]),
        },
    }
</script>

<style scoped>

</style>
