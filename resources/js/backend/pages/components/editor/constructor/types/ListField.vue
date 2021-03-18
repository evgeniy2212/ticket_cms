<template>
    <div class="row">
        <div class="pb-2 custom-control custom-checkbox">
            <input @change="updateField"
                   type="checkbox"
                   v-model="boolean"
                   class="custom-control-input"
                   :id="field.uid">
            <label class="custom-control-label" :for="field.uid">Numbered list</label>
        </div>
        <div class="col-12">
            <component :is="isNumered">
                <li class="mb-2" v-for="(element,key) in field_items">
                    <small class="text-muted">{{ itemCount(field_items[key].name) }} / {{ getLimit }}</small>
                    <input
                        v-model="field_items[key].body"
                        :id="key"
                        @blur="updateField"
                        @keyup="validateItem"
                        class="form-control form-control-sm"
                        placeholder="List item"
                        type="text">
                </li>
            </component>
            <div class="form-group">
                <span @click.prevent="addElement" class="btn btn-outline-success btn-sm">
                    <span class="fa fa-plus-square"></span>
                    Add element
                </span>
            </div>
        </div>
    </div>
</template>

<script>

import {mapGetters} from "vuex";

export default {
    props   : {
        field: Object
    },
    data() {
        return {
            field_items: [
                {name: ''},
                {name: ''},
                {name: ''},
            ],
            boolean    : false
        }
    },
    methods : {
        addElement() {
            this.field_items.push({name: ''})
        },
        updateField() {
            this.$emit('update', {
                field_items: this.field_items,
                boolean    : this.boolean,
            })
        },
        validateItem(e) {
            return this.field.field_items[e.target.id].name = this.field.field_items[e.target.id].name.substr(
                0,
                this.getLimit
            );
        },
        itemCount(name) {
            return name ? name.length : 0;
        },
    },
    watch   : {
        field: {
            immediate: true,
            handler(field) {
                // console.log('field: ', field);
                if(field && field.field_items){
                    this.field_items = field.field_items;
                }
            },
            deep     : true
        }
    },
    computed: {
        isNumered() {
            return this.field.boolean ? 'ol' : 'ul';
        },

        ...mapGetters([
                          'getLimit',
                      ]),
    },
}
</script>

<style scoped>

</style>
