<template>
    <div>
        <div class="text-right">
            <a v-if="this.getNewsId"
               target="_blank"
               class="btn btn-outline-info" :href="showUrl">
                <span class="fa fa-eye"></span>
                Show
            </a>
            <a v-if="canSave"
               @click="saveAndContinue"
               class="btn btn-outline-primary"
               href="#">
                <span class="fa fa-save"></span>
                {{ this.getNewsId ? 'Update and continue' : 'Create and continue' }}
            </a>
            <a v-if="canSave"
               @click="save"
               class="btn btn-outline-secondary"
               href="#">
                <span class="fa fa-save"></span>
                {{ this.getNewsId ? 'Update' : 'Create' }}
            </a>
            <a v-if="this.getNewsId && !this.getVisibility"
               @click="publishNow"
               class="btn btn-outline-info"
               href="#">
                <span class="fa fa-eye"></span>
                Опублікувати зараз
            </a>
            <a v-if="this.getNewsId && !this.getVisibility &&  !this.getPubBySchedule"
               @click="publishBySchedule" class="btn btn-outline-success" href="#">
                <span class="fa fa-calendar"></span>
                Опублікувати за розкладом
            </a>
            <a v-if="this.getNewsId && this.getVisibility"
               @click="hide"
               class="btn btn-outline-warning" href="#">
                <span class="fa fa-eye-slash"></span>
                Приховати
            </a>
            <a v-if="this.getNewsId"
               @click="deleteItem" class="btn btn-outline-danger" href="#">
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
                // return this.getAlias && this.getTitle && this.getParent;
                return true;
            },
            showUrl() {
                return this.getAlias ? '/' + this.getAlias + '-article?preview' : '#';
            }
        },
        methods:  {
            setTab(tab) {
                this.$store.commit('switchTab', tab);
            },
            deleteItem() {
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
                        this.deleteItem(this.getNewsId);
                    }
                });
            },
            save() {
                this.setOptionContinue(false);
                this.getNewsId ? this.update(this.getNewsId) : this.store();
            },
            saveAndContinue() {
                this.setOptionContinue(true);
                this.getNewsId ? this.update(this.getNewsId) : this.store();
            },
            publishNow() {
                this.setConfigVisibility(true);
                this.getNewsId ? this.update(this.getNewsId) : this.store();
            },
            publishBySchedule() {
                this.setPubBySchedule(true);
                this.getNewsId ? this.update(this.getNewsId) : this.store();
            },
            hide() {
                this.setConfigVisibility(false);
                this.setPubBySchedule(false);
                this.update(this.getNewsId)
            },
            ...mapActions([
                              'store',
                              'update',
                              'delete'
                          ]),
            ...mapMutations([
                                'setPubBySchedule',
                                'setConfigVisibility',
                                'setOptionContinue',
                            ]),
        }
    }
</script>
