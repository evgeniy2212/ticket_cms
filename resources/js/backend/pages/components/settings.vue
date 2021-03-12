<template>
    <div class="row">
        <div class="col-12 col-xl-8 offset-xl-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-12 col-xl-6">
                            <div class="form-group">
                                <b class="mb-2">Запланувати випуск</b>
                                <VueCtkDateTimePicker
                                    button-now-translation="Сьогоднi"
                                    format="YYYY-MM-DD HH:mm"
                                    label="виберіть дату і час"
                                    locale="uk"
                                    v-model="date"/>
                            </div>
                            <div class="form-group custom-control custom-switch">
                                <input class="custom-control-input" id="lenta" type="checkbox" v-model="lenta">
                                <label class="custom-control-label" for="lenta">
                                    Відображати в Стрічці Новин
                                </label>
                            </div>
                            <div class="form-group custom-control custom-switch">
                                <input class="custom-control-input" id="top_lenta" type="checkbox" v-model="top_lenta">
                                <label class="custom-control-label" for="top_lenta">
                                    Головне в Стрічці новин
                                </label>
                            </div>
                            <div class="form-group custom-control custom-switch">
                                <input class="custom-control-input" id="hide_author" type="checkbox" v-model="author">
                                <label class="custom-control-label" for="hide_author">
                                    Приховати автора
                                </label>
                            </div>
                            <div class="form-group custom-control custom-switch">
                                <input class="custom-control-input" id="main_primary" type="checkbox" v-model="main_primary">
                                <label class="custom-control-label" for="main_primary">
                                    Головна новина (на головній)
                                </label>
                            </div>
                            <div class="form-group custom-control custom-switch">
                                <input class="custom-control-input" id="main_secondary" type="checkbox" v-model="main_secondary">
                                <label class="custom-control-label" for="main_secondary">
                                    Другорядна новина (на головній)
                                </label>
                            </div>
<!--                            <div class="form-group">-->
<!--                                <label for="visibility">Видимiсть</label>-->
<!--                                <select class="form-control" id="visibility" v-model="visibility">-->
<!--                                    <option value="1">Видно</option>-->
<!--                                    <option value="0">Приховано</option>-->
<!--                                </select>-->
<!--                            </div>-->
                            <div class="form-group">
                                <label for="alias">Посилання</label>
                                <input ref="alias" class="form-control" id="alias" type="text" v-model="alias">
                                <small v-if="!alias" class="text-danger">
                                    Обов'язкове для заповнення
                                </small>
                                <div v-else-if="getFieldErrors('alias')">
                                    <small class="text-danger" v-for="errorMsg in getFieldErrors('alias')">
                                        {{ errorMsg }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- Right col -->
                        <div class="col-12 col-xl-6">
                            <div class="form-group">
                                <b>Дії користувача</b>
                            </div>
                            <div class="form-group custom-control custom-switch">
                                <input class="custom-control-input" id="can_comment" type="checkbox"
                                       v-model="can_comment">
                                <label class="custom-control-label" for="can_comment">
                                    можливість коментувати
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker'
import {mapGetters} from "vuex"
import {mixins} from '../../mixins'
import { slugify } from 'transliteration';

export default {
    name: "settings",
    mixins: [mixins],
    components: {
        VueCtkDateTimePicker
    },
    methods: {
        getFieldErrors(field) {
            return this.getErrors['news.' + field];
        }
    },
    computed: {
        min_date() {
            return new Date();
        },
        alias: {
            get() {
                return this.textAlias
            },
            set(value) {
                this.$store.commit('setAlias', slugify(value))
            },
        },
        lenta: {
            get() {
                return this.switchLenta
            },
            set(value) {
                this.$store.commit('setConfigLenta', value)
            },
        },
        top_lenta: {
            get() {
                return this.switchTopLenta
            },
            set(value) {
                this.$store.commit('setConfigTopLenta', value)
            },
        },
        main_primary: {
            get() {
                return this.switchMainPrimary
            },
            set(value) {
                this.$store.commit('setConfigMainPrimary', value)
                if (value) {
                    this.$store.commit('setConfigMainSecondary', false)
                }
            }
        },
        main_secondary: {
            get() {
                return this.switchMainSecondary
            },
            set(value) {
                this.$store.commit('setConfigMainSecondary', value)
                if(value){
                    this.$store.commit('setConfigMainPrimary', false)
                }
            },
        },
        author: {
            get() {
                return this.switchAuthor
            },
            set(value) {
                this.$store.commit('setConfigHideAuthor', value)
            },
        },
        can_comment: {
            get() {
                return this.switchCanComment
            },
            set(value) {
                this.$store.commit('setConfigCanComment', value)
            },
        },
        visibility: {
            get() {
                return this.switchVisibility
            },
            set(value) {
                this.$store.commit('setConfigVisibility', value)
            },
        },
        date: {
            get() {
                return this.convertDateToString(this.datePub);
            },
            set(value) {
                this.$store.commit('setPubDate', value)
            },
        },
        ...mapGetters({
                          datePub:             'getPubDate',
                          textAlias:           'getAlias',
                          switchLenta:         'getLenta',
                          switchTopLenta:      'getTopLenta',
                          switchMainPrimary:   'getMainPrimary',
                          switchMainSecondary: 'getMainSecondary',
                          switchAuthor:        'getHideAuthor',
                          switchCanComment:    'getCanComment',
                          switchVisibility:    'getVisibility',
                          getErrors:           'getErrors'
                      })
    }
}
</script>

<style lang="scss" scoped>
@import '~vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
</style>
