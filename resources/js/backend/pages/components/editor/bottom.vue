<template>
    <div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="tags"><b>Теги (ключові слова)</b></label>
                            <multiselect
                                :clear-on-select="false"
                                :close-on-select="false"
                                :hide-selected="true"
                                :internal-search="false"
                                :limit="10"
                                :loading="tag.loading"
                                :max-height="600"
                                :multiple="true"
                                :options="tag.results"
                                :options-limit="300"
                                :searchable="true"
                                @search-change="searchTag"
                                id="tags"
                                label="name"
                                open-direction="bottom"
                                placeholder="Почнiть писати щоб отримати список доступних тегiв"
                                selectLabel="Enter щоб обрати"
                                selectedLabel="Обраний"
                                track-by="id"
                                v-model="tags">
                                <span slot="noResult">Нiчого не знайдено</span>
                            </multiselect>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-danger mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="tech">
                                <b>Технiчне вiкно</b>
                                <small class="text-muted">{{ techCount }} / {{ getDefaultLimit }}</small>
                            </label>
                            <textarea @keyup="validateTech" class="form-control" id="tech" v-model="tech"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import {mapGetters} from "vuex";
    // import {axios} from "../../../axios";

    export default {
        name:       "bottom",
        components: {Multiselect},
        data() {
            return {
                tag: {
                    loading: false,
                    results: []
                }
            }
        },
        computed:   {
            tags: {
                get() {
                    return this.arrTags
                },
                set(value) {
                    this.$store.commit('setTags', value)
                }
            },
            tech: {
                get() {
                    return this.textTech
                },
                set(value) {
                    this.$store.commit('setTech', value)
                }
            },
            ...mapGetters({
                              textTech:        'getTechInfo',
                              arrTags:         'getTags',
                              getDefaultLimit: 'getDefaultLimit',
                          }),
            techCount() {
                return this.tech ? this.tech.length : 0;
            },
        },
        methods:    {
            validateTech () {
                return  this.tech = this.tech.substr(0, this.getDefaultLimit);
            },
            searchTag(query) {
                this.tag.loading = true;
                axios
                    .get(window.shared.tagSearchRoute + '?query=' + query)
                    .then((response) => {
                        this.tag.loading = false;
                        this.tag.results = response.data;
                    })
            }
        }
    }
</script>

