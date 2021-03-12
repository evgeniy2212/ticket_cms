<template>
    <div>
        <div class="text-right">
            <a v-if="this.getNewsId" target="_blank"
               class="btn btn-outline-info" :href="showUrl">
                <span class="fa fa-eye"></span>
                Перегляд
            </a>
            <a v-if="canSave"  @click="saveAndContinueArticle" class="btn btn-outline-primary" href="#">
                <span class="fa fa-save"></span>
                {{ this.getNewsId ? 'Оновити та продовжити' : 'Створити та продовжити' }}
            </a>
            <a v-if="canSave" @click="saveArticle" class="btn btn-outline-secondary" href="#">
                <span class="fa fa-save"></span>
                {{ this.getNewsId ? 'Оновити' : 'Створити' }}
            </a>
            <a v-if="this.getNewsId && !this.getVisibility"
               @click="publishNowArticle" class="btn btn-outline-info" href="#">
                <span class="fa fa-eye"></span>
                Опублікувати зараз
            </a>
            <a v-if="this.getNewsId && !this.getVisibility &&  !this.getPubBySchedule"
               @click="publishByScheduleArticle" class="btn btn-outline-success" href="#">
                <span class="fa fa-calendar"></span>
                Опублікувати за розкладом
            </a>
            <a v-if="this.getNewsId && this.getVisibility"
               @click="hideArticle"
               class="btn btn-outline-warning" href="#">
                <span class="fa fa-eye-slash"></span>
                Приховати
            </a>
            <a v-if="this.getNewsId"
               @click="deleteArticle" class="btn btn-outline-danger" href="#">
                <span class="fa fa-trash"></span>
                Видалити
            </a>
        </div>
<!--        <ul class="nav nav-pills mb-3">-->
<!--            <li class="nav-item">-->
<!--                <a :class="{'active':showEditor}" @click="setTab('editor')" class="nav-link" href="#">-->
<!--                    Редактор-->
<!--                </a>-->
<!--            </li>-->
<!--            <li class="nav-item">-->
<!--                <a :class="{'active':showSettings}" @click="setTab('settings')" class="nav-link" href="#">-->
<!--                    Налаштування публікації-->
<!--                </a>-->
<!--            </li>-->
<!--        </ul>-->
    </div>
</template>

<script>
    import {mapGetters, mapActions, mapMutations} from "vuex";
    import ValidateErrors from "./editor/validate-errors";

    export default {
        name:     "action-bar",
        components: {ValidateErrors},
        computed: {
            ...mapGetters({
                              showEditor:       'showEditor',
                              showSettings:     'showSettings',
                              getNewsId:        'getNewsId',
                              getAlias:         'getAlias',
                              getTitle:         'getTitle',
                              getParent:         'getParent',
                              getPubBySchedule: 'getPubBySchedule',
                              getVisibility:    'getVisibility',
                          }),
            canSave () {
                return this.getAlias && this.getTitle && this.getParent;
            },
            showUrl() {
                return this.getAlias ? '/' + this.getAlias + '-article?preview' : '#';
            }
        },
        methods:  {
            setTab(tab) {
                this.$store.commit('switchTab', tab);
            },
            deleteArticle() {
                this.$swal({
                               title:               'Ви дійсно хочете видалити новину?',
                               type:                'warning',
                               showCancelButton:    true,
                               confirmButtonText:   'Так',
                               cancelButtonText:    'Ні',
                               showCloseButton:     true,
                               showLoaderOnConfirm: true
                           }).then((result) => {
                    if (result.value) {
                        this.deleteNews(this.getNewsId);
                    }
                });
            },
            saveArticle() {
                this.setOptionContinue(false);
                this.getNewsId ? this.updateNews(this.getNewsId) : this.storeNews();
            },
            saveAndContinueArticle() {
                this.setOptionContinue(true);
                this.getNewsId ? this.updateNews(this.getNewsId) : this.storeNews();
            },
            publishNowArticle() {
                this.setConfigVisibility(true);
                this.getNewsId ? this.updateNews(this.getNewsId) : this.storeNews();
            },
            publishByScheduleArticle() {
                this.setPubBySchedule(true);
                this.getNewsId ? this.updateNews(this.getNewsId) : this.storeNews();
            },
            hideArticle() {
                this.setConfigVisibility(false);
                this.setPubBySchedule(false);
                this.updateNews(this.getNewsId)
            },
            ...mapActions([
                              'storeNews',
                              'updateNews',
                              'deleteNews'
                          ]),
            ...mapMutations([
                                'setPubBySchedule',
                                'setConfigVisibility',
                                'setOptionContinue',
                            ]),
        }
    }
</script>
