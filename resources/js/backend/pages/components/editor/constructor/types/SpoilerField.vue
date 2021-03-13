<template>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="title">
                    <span>Spoiler header</span>
                    <small class="text-muted">{{ titleCount }} / {{ getLimit }}</small>
                </label>
                <input @blur="updateField"
                       @keyup="validateTitle"
                       id="title"
                       class="form-control form-control-sm"
                       placeholder="Spoiler header"
                       type="text" v-model="field.title">
            </div>
            <div class="form-group">
                <label for="subtitle">
                    <span>Spoiler subheader</span>
                    <small class="text-muted">{{ subtitleCount }} / {{ getLimit }}</small>
                </label>
                <input @blur="updateField"
                       @keyup="validateSubtitle"
                       class="form-control form-control-sm"
                       id="subtitle"
                       placeholder="Spoiler subheader"
                       type="text" v-model="field.subtitle">
            </div>
            <div class="form-group">
                <label for="body">
                    <span>Текст спойлеру</span>
                    <small class="text-muted">{{ bodyCount }} / {{ getLimitBody }}</small>
                </label>
                <textarea
                    id="body"
                    @blur="updateField"
                    @keyup="validateBody"
                    class="form-control form-control-sm"
                    placeholder="Spoiler text"
                    rows="5"
                          v-model="field.body"></textarea>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name:     "spoiler",
        props:    {
            field: Object
        },
        data() {
            return {}
        },
        methods:  {
            updateField() {
                this.$emit('update', this.field)
            },
            validateBody () {
                return this.field.body = this.field.body.substr(0, this.getLimitBody);
            },
            validateTitle () {
                return this.field.title = this.field.title.substr(0, this.getLimit);
            },
            validateSubtitle () {
                return this.field.subtitle = this.field.subtitle.substr(0, this.getLimit);
            },
        },
        computed: {
            titleCount() {
                return this.field && this.field.title ? this.field.title.length : 0;
            },
            subtitleCount() {
                return this.field && this.field.subtitle ? this.field.subtitle.length : 0;
            },
            bodyCount() {
                return this.field && this.field.body ? this.field.body.length : 0;
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
