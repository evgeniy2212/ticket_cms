<template>
    <div>
        <div class="row" id="constructor">
            <div class="col-12">
                <draggable
                    @end="drag=false"
                    @start="drag=true"
                    group="people"
                    handle=".drag"
                    :list="fields">
                    <field
                        :field="field"
                        :key="field.uid"
                        v-for="field in fields">
                    </field>
                </draggable>
            </div>
        </div>
        <div class="card border-primary mt-2">
            <div class="card-body">
                <ul class="nav nav-pills">
                    <type
                        :key="button.id"
                        :type="button"
                        v-for="button in arrFieldTypes"></type>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex"
import draggable from 'vuedraggable'
import Type from './constructor/type';
import Field from './constructor/field';

export default {
    name: "constructor",
    props: {
        fields: {
            type: Array,
        },
    },
    components: {
        type: Type,
        field: Field,
        draggable
    },
    computed: {

        ...mapGetters({
            arrFieldTypes: 'getFieldTypes',
            arrFields: 'getFields'
        })
    }
}
</script>
