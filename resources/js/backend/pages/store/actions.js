import Vue from 'vue'

export default {
    async storeNews({commit, dispatch, getters, state}) {
        try {
            const data = await dispatch('serializeContentData', state.content);
            dispatch('preloader');
            const response = await axios.post(window.shared.newsRoute, data);
            let newsId = response.data.news.id;
            commit('setNewsId', newsId);
            dispatch('fetchNews', {
                id:     newsId,
                silent: true
            });
            if (state.options.continue) {
                window.history.pushState(null, null, window.shared.newsRoute + '/' + newsId + '/edit');
            } else {
                window.location.href = window.shared.newsRoute;
            }
            dispatch('userMessage', 'Публiкацiя успiшно створена');
            commit('setErrors', {})
        } catch ({response = {}}) {
            commit('setErrors', response.data.errors);
            Vue.swal().close()
        }
    },
    async fetchNews({commit, dispatch, getters, state}, inputData) {
        try {
            if (!inputData.silent) {
                dispatch('preloader');
            }
            const response = await axios.get(window.shared.newsRoute + '/' + inputData.id);
            const data = await dispatch('deSerializeResponseData', response.data);
            commit('setContent', data)
            if (!inputData.silent) {
                Vue.swal().close()
            }
            commit('setErrors', {})
        } catch (response) {
            console.warn(response)
            commit('setErrors', response.data.errors);
            Vue.swal().close()
        }
    },
    async updateNews({commit, dispatch, getters, state}, id) {
        try {
            const data = await dispatch('serializeContentData', state.content);
            dispatch('preloader');
            const response = await axios.put(window.shared.newsRoute + '/' + id, data);
            if (!state.options.continue) {
                window.location.href = window.shared.newsRoute;
            }
            dispatch('fetchNews', {
                id:     id,
                silent: true
            });
            dispatch('userMessage', 'Публiкацiя успiшно оновлена');
            commit('setErrors', {})
        } catch ({response = {}}) {
            commit('setErrors', response.data.errors);
            Vue.swal().close()
        }
    },
    async deleteNews({commit, dispatch, getters, state}, id) {
        try {
            var config = {
                headers: {
                    accept: 'application/json',
                },
            };
            dispatch('preloader');
            const response = await axios.delete(window.shared.newsRoute + '/' + id, config);
            dispatch('userMessage', 'Публiкацiя успiшно видалена');
            window.location.replace(response.data.redirectUrl);
        } catch ({response = {}}) {
            commit('setErrors', response.data.errors);
            Vue.swal().close()
        }
    },
    async serializeContentData({state}) {
        let categories = {};
        state.content.categories.map(function (category, index) {
            categories[category.id] = {is_main: false};
        });
        categories[state.content.parent.id] = {is_main: true};

        return {
            news:       {
                alias:           state.content.alias,
                user_id:         state.content.author ? state.content.author.id : null,
                pub_date:        state.content.pub_date.toLocaleString("uk-UA"),
                pub_by_schedule: state.content.pub_by_schedule,
                name:            state.content.title,
                subtitle:        state.content.subtitle,
                tech:            state.content.tech,
                block_item_id:   state.content.image ? state.content.image.id : state.content.block_item_id,
                enable_comments: state.content.config.can_comment,
                hide_author:     state.content.config.hide_author,
                lenta:           state.content.config.lenta,
                top_lenta:       state.content.config.top_lenta,
                main_secondary:  state.content.config.main_secondary,
                main_primary:    state.content.config.main_primary,
                visibility:      state.content.config.visibility,
            },
            categories: categories,
            tags:       state.content.tags.map(a => a.id),
            blocks:     state.content.blocks.map(function (block, index) {
                return {
                    id:            block.id,
                    block_type_id: block.block_type_id,
                    body:          block.body,
                    image:         block.image,
                    block_items:   block.block_items,
                    boolean:       block.boolean,
                    visible:       block.visible,
                    title:         block.title,
                    filename:      block.filename,
                    file:          block.file,
                    subtitle:      block.subtitle,
                    component:     block.component,
                    position:      index,
                    resolutionKey: block.resolutionKey || null,
                }
            }),
        };
    },
    async deSerializeResponseData({state}, data) {
        let parent = data.categories.filter(category => category.pivot.is_main === 1).shift();
        let categories = data.categories.filter(category => category.pivot.is_main === 0);

        return {
            id:              data.id,
            alias:           data.alias,
            parent:          parent,
            author:          data.author,
            pub_date:        new Date(data.pub_date),
            pub_by_schedule: data.pub_by_schedule,
            title:           data.name,
            subtitle:        data.subtitle,
            block_item_id:   data.block_item_id,
            tech:            data.tech,
            description:     data.description,
            config:          {
                enable_comments: data.can_comment,
                hide_author:     data.hide_author,
                lenta:           data.lenta,
                top_lenta:       data.top_lenta,
                main_primary:    data.main_primary,
                main_secondary:  data.main_secondary,
                visibility:      data.visibility,
                parsed:          data.parsed,
            },
            categories:      categories,
            tags:            data.tags,
            blocks:          data.blocks
                                 .sort((a, b) => a.position - b.position)
                                 .map(function (block, index) {
                                     return {
                                         id:            block.id,
                                         uid:           Math.floor(Math.random() * 10000) + 1,
                                         body:          block.body,
                                         title:         block.title,
                                         subtitle:      block.subtitle,
                                         block_items:   block.block_items,
                                         boolean:       block.boolean,
                                         visible:       block.visible,
                                         position:      block.position,
                                         component:     block.type.component,
                                         name:          block.type.name,
                                         block_type_id: block.block_type_id,
                                         icon:          block.type.icon,
                                         resolutionKey: block.resolutionKey,
                                     }
                                 }),
        };
    },

    async preloader() {
        Vue.swal({
                     title:             'Зачекайте',
                     allowEscapeKey:    false,
                     allowOutsideClick: false,
                     showConfirmButton: false,
                     onOpen:            () => {
                         Vue.swal.showLoading();
                     }
                 })
    },

    async userMessage({state}, text) {
        Vue.swal({
                     title: text,
                     timer: 2000
                 })
    },

}

