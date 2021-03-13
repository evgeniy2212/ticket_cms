<template>
    <div class="card mb-2">
        <div class="card-body">
<!--            <div class="row">-->
<!--                <div class="col-6">-->
<!--                    <div class="form-group">-->
<!--                        <label for="main_category"><b>Parent page</b></label>-->
<!--                        <multiselect-->
<!--                            :multiple="false"-->
<!--                            :options="arrCategoriesList"-->
<!--                            :searchable="true"-->
<!--                            id="main_category"-->
<!--                            label="name"-->
<!--                            placeholder="Select parent page"-->
<!--                            selectLabel="Enter for selecting"-->
<!--                            selectedLabel="Selected"-->
<!--                            track-by="id"-->
<!--                            v-model="parent"></multiselect>-->
<!--                        <small v-if="!parent" class="text-danger">-->
<!--                            Required-->
<!--                        </small>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-6">-->
<!--                    <div class="form-group">-->
<!--                        <label for="category"><b>Розділ</b></label>-->
<!--                        <multiselect-->
<!--                            :clear-on-select="false"-->
<!--                            :close-on-select="false"-->
<!--                            :hide-selected="true"-->
<!--                            :internal-search="false"-->
<!--                            :multiple="true"-->
<!--                            :options="arrCategoriesList"-->
<!--                            :searchable="true"-->
<!--                            id="category"-->
<!--                            label="name"-->
<!--                            placeholder="Оберiть декiлька категорiй"-->
<!--                            selectLabel="Enter щоб обрати"-->
<!--                            selectedLabel="Обраний"-->
<!--                            track-by="id"-->
<!--                            v-model="categories"></multiselect>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="title">
                            <b>Name</b>
                            <small class="text-muted">{{ title_count }} / {{ limit }}</small>
                        </label>
                        <input class="form-control" id="title" type="text" v-model="title">
                        <small v-if="!title" class="text-danger">
                            Required
                        </small>
                    </div>
                </div>
            </div>
<!--            <div class="row">-->
<!--                <div class="col-12">-->
<!--                    <div class="form-group">-->
<!--                        <label for="author"><b>Автор</b></label>-->
<!--                        <multiselect-->
<!--                            :custom-label="optionAuthor"-->
<!--                            :options="arrAuthors"-->
<!--                            :searchable="true"-->
<!--                            id="author"-->
<!--                            label="name"-->
<!--                            placeholder="Оберiть автора"-->
<!--                            selectLabel="Enter щоб обрати"-->
<!--                            selectedLabel="Обраний"-->
<!--                            track-by="id"-->
<!--                            v-model="author"></multiselect>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <div class="col-12">-->
<!--                    <div class="form-group">-->
<!--                        <label for="subtitle">-->
<!--                            <b>Subheader</b>-->
<!--                            <small class="text-muted">{{ subtitle_count }} / {{ limit }}</small>-->
<!--                        </label>-->
<!--                        <textarea class="form-control" id="subtitle" rows="3"-->
<!--                                  v-model="subtitle"></textarea>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import {mapGetters} from "vuex";
import { slugify } from 'transliteration';

export default {
    name: "top",
    components: {
        Multiselect
    },
    computed: {
        title_count() {
            return this.textTitle ? this.textTitle.length : 0;
        },
        subtitle_count() {
            return this.textSubTitle ? this.textSubTitle.length : 0;
        },
        parent: {
            get() {
                return this.getParent
            },
            set(value) {
                this.$store.commit('setParent',value)
            }
        },
        title: {
            get() {
                return this.textTitle
            },
            set(value) {
                this.$store.commit('setAlias', slugify(value, { replace: [[',', ''], ['.', '']] }))
                this.$store.commit('setTitle', value)
            }
        },
        subtitle: {
            get() {
                return this.textSubTitle
            },
            set(value) {
                this.$store.commit('setSubTitle', value)
            }
        },
        author: {
            get() {
                return this.objAuthor
            },
            set(value) {
                this.$store.commit('setAuthor', value)
            }
        },
        categories: {
            get() {
                return this.arrCategories
            },
            set(value) {
                this.$store.commit('setCategories', value)
            }
        },
        ...mapGetters({
            textTitle: 'getTitle',
            textSubTitle: 'getSubTitle',
            arrCategories: 'getCategories',
            arrCategoriesList: 'getCategoriesList',
            arrAuthors: 'getAuthorsList',
            objAuthor: 'getAuthor',
            limit: 'getLimit',
            getParent: 'getParent'
        })
    },
    methods: {
        optionAuthor({name_last, name_first}) {
            return `${name_last} ${name_first}`
        },
    }
}
</script>

<style scoped>

</style>
