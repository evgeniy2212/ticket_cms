<template>
    <div v-if="Object.keys(getErrors).length" class="alert alert-danger">
        <ol>
            <div v-for="(errors, field) in getErrors">
                <li v-for="message in errors">{{ message }}</li>
            </div>
        </ol>
    </div>
</template>

<script>

    import {mapGetters} from "vuex";

    export default {
        name:     "validate-errors",
        computed: {
            ...mapGetters([
                              'getErrors'
                          ]),
        },
    }
</script>
