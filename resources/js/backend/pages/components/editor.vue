<template>
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-8 offset-xl-2">
            <div class="row">
                <div class="col-12 col-xl-12">
                    <top></top>
                    <constructor :blocks="blocks"></constructor>
<!--                    <bottom></bottom>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {mapGetters} from "vuex";
import Top from './editor/top';
import Constructor from './editor/constructor';
import Bottom from './editor/bottom';

export default {
    name: "editor",
    components: {
        constructor: Constructor,
        bottom: Bottom,
        top: Top
    },
    computed: {
        blocks: {
            get() {
                return this.arrBlocks
            },
            set(value) {
                this.$store.commit('shuffleBlocks', value)
            }
        },
        ...mapGetters({
            arrBlockTypes: 'getBlockTypes',
            arrBlocks: 'getBlocks'
        })
    }

}
</script>

<style lang="scss" scoped>
@import "~vue-multiselect/dist/vue-multiselect.min.css";
</style>
