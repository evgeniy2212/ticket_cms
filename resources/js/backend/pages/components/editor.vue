<template>
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-8 offset-xl-2">
            <div class="row">
                <div class="col-12 col-xl-12">
<!--                    <top></top>-->
                    <constructor :blocks="blocks"></constructor>
<!--                    <bottom></bottom>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {mapGetters} from "vuex";
import Constructor from './editor/constructor';

export default {
    name: "editor",
    components: {
        constructor: Constructor,
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
