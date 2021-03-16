<template>
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-8 offset-xl-2">
            <div class="row">
                <div class="col-12 col-xl-12">
                    <top></top>
                    <constructor :fields="fields"></constructor>
<!--                    <bottom></bottom>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {mapGetters} from "vuex";
import Constructor from './editor/constructor';
import Top from './editor/top';

export default {
    name: "editor",
    components: {
        constructor: Constructor,
        top: Top,
    },
    computed: {
        fields: {
            get() {
                console.log('get');
                return this.arrFields
            },
            set(value) {
                console.log('set');
                this.$store.commit('shuffleFields', value)
            }
        },
        ...mapGetters({
            arrFieldTypes: 'getFieldTypes',
            arrFields: 'getFields'
        })
    }

}
</script>

<style lang="scss" scoped>
@import "~vue-multiselect/dist/vue-multiselect.min.css";
</style>
