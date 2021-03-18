import Vue from 'vue'
import Vuex, {mapGetters, mapActions} from 'vuex'
import {store} from './store/store'
import {axios} from "../axios";
import ActionBar from './components/action-bar';
import Editor from './components/editor';
import Settings from './components/settings';
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);
Vue.use(Vuex);
Vue.config.productionTip = false;

new Vue({
    el: '#app',
    name: 'PageConstructor',
    store,
    axios,
    components: {
        ActionBar,
        Editor,
        Settings,
    },
    computed: {
        ...mapGetters({
            showEditor: 'showEditor',
        })
    },
    methods: {
        ...mapActions([
            'fetchItems'
        ])
    },
    created() {
        if (window.shared.itemId) {
            this.fetchItems(
                {
                    id:     window.shared.itemId,
                    silent: false
                }
            );
        }
    }
});

