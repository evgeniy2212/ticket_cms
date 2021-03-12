<template>
    <div>
        <div class="row" id="constructor">
            <div class="col-12">
                <draggable
                    @end="drag=false"
                    @start="drag=true"
                    group="people"
                    handle=".drag"
                    :list="blocks">
                    <block
                        :block="block"
                        :key="block.uid"
                        v-for="block in blocks">
                    </block>
                </draggable>
            </div>
        </div>
        <div class="card border-primary mt-2">
            <div class="card-body">
                <ul class="nav nav-pills">
                    <type
                        :key="button.id"
                        :type="button"
                        v-for="button in arrBlockTypes"></type>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex"
import draggable from 'vuedraggable'
import Type from './constructor/type';
import Block from './constructor/block';

export default {
    name: "constructor",
    props: {
        blocks: {
            type: Array,
        },
    },
    components: {
        type: Type,
        block: Block,
        draggable
    },
    computed: {

        ...mapGetters({
            arrBlockTypes: 'getBlockTypes',
            arrBlocks: 'getBlocks'
        })
    }
}
</script>
