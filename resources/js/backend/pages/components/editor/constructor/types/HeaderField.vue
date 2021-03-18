<template>
    <div>
        <small class="text-muted">{{ bodyCount }} / {{ getDefaultLimit }}</small>
        <textarea @blur="updateField"
               @keyup="validateBody"
               class="form-control" type="text" rows="3"
                  v-model="field_items[0].body"
                  :id="0">
        </textarea>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    props:    {
        field: Object
    },
    data() {
        return {
            field_items: [
                {body: ''},
            ],
            boolean    : false
        }
    },
    methods:  {
        itemCount(name) {
            // console.log('itemCount');
            return name ? name.length : 0;
        },
        updateField() {
            // console.log('updateField');
            this.$emit('update', {
                field_items: this.field_items,
                // boolean    : this.boolean,
            })
            // this.$emit('update', {body: this.field.body})
        },
        validateBody(e) {
            let fields = JSON.parse(JSON.stringify(this.field));
            // console.log('validateBody: ', fields);
            return this.field.field_items[e.target.id].body = fields.field_items[e.target.id].body.substr(
                0,
                this.getLimit
            );
            // return this.field.body = this.field.body.substr(0, this.getDefaultLimit);
        },
        addField() {
            this.field_items.push({body: ''})
            // console.log('this.field_items: ', this.field_items);
        },
    },
    watch   : {
        field: {
            immediate: true,
            handler(field) {
                // console.log('fieldHeader: ', field);
                if(field && field.field_items){
                    this.field_items = field.field_items;
                }
                // console.log('this.field_items: ', this.field_items);
            },
            deep     : true
        }
    },
    computed: {
        bodyCount() {
            if(this.field)
            {
                let fields = JSON.parse(JSON.stringify(this.field));
                // console.log('fields: ', fields, fields.field_items, fields.field_items.length && fields.field_items[0].name);
                // this.addField();
                // console.log('this.field_items: ', this.field_items);
                return fields.field_items.length && fields.field_items[0].name ? field_items[0].name.length : 0;
            }

            return 0;
            // itemCount(field_items[0].name)
            // console.log('bodyCount', this.field, this.field.field_items, JSON.parse(JSON.stringify(this.field)));
            // return this.field && this.field.field_items[0].name ? this.field.field_items[0].name.length : 0;
        },
        ...mapGetters([
                          'getDefaultLimit',
                      ]),
    },
    beforeMount() {
        this.addField();
    }
}
</script>

<style scoped>

</style>
