<template>
    <li class="nav-item">
        <a @click.prevent="pushBlock" class="btn btn-link nav-link" href="">
            <h1 :class="'fa-'+type.icon" class="fa"></h1>
            <br>
            {{ type.name }}
        </a>
    </li>
</template>

<script>
export default {
    name: "type",
    props: {
        type: Object
    },
    methods: {
        pushBlock() {
            this.$store.commit('pushField', this.type)
        }
    }
}
</script>

<style scoped>
    .btn.btn-link.nav-link {
        width: 85px;
        padding: 1px;
    }
</style>
