<template>
    <div class="row">
        <div class="pb-2 custom-control custom-checkbox">
            <input @change="updateBlock"
                   type="checkbox"
                   v-model="boolean"
                   class="custom-control-input"
                   :id="block.uid">
            <label class="custom-control-label" :for="block.uid">Numbered list</label>
        </div>
        <div class="col-12">
            <component :is="isNumered">
                <li class="mb-2" v-for="(element,key) in block_items">
                    <small class="text-muted">{{ itemCount(block_items[key].name) }} / {{ getLimit }}</small>
                    <input
                        v-model="block_items[key].name"
                        :id="key"
                        @blur="updateBlock"
                        @keyup="validateItem"
                        class="form-control form-control-sm"
                        placeholder="Елемент списку"
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
        block: Object
    },
    data() {
        return {
            block_items: [
                {name: ''},
                {name: ''},
                {name: ''},
            ],
            boolean    : false
        }
    },
    methods : {
        addElement() {
            this.block_items.push({name: ''})
        },
        updateBlock() {
            this.$emit('update', {
                block_items: this.block_items,
                boolean    : this.boolean,
            })
        },
        validateItem(e) {
            return this.block.block_items[e.target.id].name = this.block.block_items[e.target.id].name.substr(
                0,
                this.getLimit
            );
        },
        itemCount(name) {
            return name ? name.length : 0;
        },
    },
    watch   : {
        block: {
            immediate: true,
            handler(block) {
                if(block && block.block_items){
                    this.block_items = block.block_items;
                    this.boolean     = block.boolean;
                }
            },
            deep     : true
        }
    },
    computed: {
        isNumered() {
            return this.block.boolean ? 'ol' : 'ul';
        },

        ...mapGetters([
                          'getLimit',
                      ]),
    },
}
</script>

<style scoped>

</style>
