<template>
    <div>
        <div class="text-right">
            <a v-if="this.getItemId"
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
                {{ this.getItemId ? 'Update and continue' : 'Create and continue' }}
            </a>
            <a v-if="canSave"
               @click="save"
               class="btn btn-outline-secondary"
               href="#">
                <span class="fa fa-save"></span>
                {{ this.getItemId ? 'Update' : 'Create' }}
            </a>
            <a v-if="this.getItemId && !this.getVisibility"
               @click="publishNow"
               class="btn btn-outline-info"
               href="#">
                <span class="fa fa-eye"></span>
                Опублікувати зараз
            </a>
            <a v-if="this.getItemId && !this.getVisibility &&  !this.getPubBySchedule"
               @click="publishBySchedule" class="btn btn-outline-success" href="#">
                <span class="fa fa-calendar"></span>
                Опублікувати за розкладом
            </a>
            <a v-if="this.getItemId && this.getVisibility"
               @click="hide"
               class="btn btn-outline-warning" href="#">
                <span class="fa fa-eye-slash"></span>
                Приховати
            </a>
            <a v-if="this.getItemId"
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
                              getItemId:        'getItemId',
                              getAlias:         'getAlias',
                              getTitle:         'getTitle',
                              getParent:         'getParent',
                              getPubBySchedule: 'getPubBySchedule',
                              getVisibility:    'getVisibility',
                          }),
            canSave () {
                return this.getTitle;
                // return true;
            },
            showUrl() {
                return this.getAlias ? '/' + this.getAlias + '?preview' : '#';
            }
        },
        methods:  {
            setTab(tab) {
                this.$store.commit('switchTab', tab);
            },
            deleteItem() {
                this.$swal({
                               title:               'Do you really want to delete?',
                               type:                'warning',
                               showCancelButton:    true,
                               confirmButtonText:   'Yes',
                               cancelButtonText:    'No',
                               showCloseButton:     true,
                               showLoaderOnConfirm: true
                           }).then((result) => {
                    if (result.value) {
                        this.deleteItem(this.getItemId);
                    }
                });
            },
            save() {
                this.setOptionContinue(false);
                this.getItemId ? this.update(this.getItemId) : this.store();
            },
            saveAndContinue() {
                this.setOptionContinue(true);
                this.getItemId ? this.update(this.getItemId) : this.store();
            },
            publishNow() {
                this.setConfigVisibility(true);
                this.getItemId ? this.update(this.getItemId) : this.store();
            },
            publishBySchedule() {
                this.setPubBySchedule(true);
                this.getItemId ? this.update(this.getItemId) : this.store();
            },
            hide() {
                this.setConfigVisibility(false);
                this.setPubBySchedule(false);
                this.update(this.getItemId)
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
