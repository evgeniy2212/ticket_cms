import Vue from 'vue'
import {axios} from "../../axios";

export default {
    async store({commit, dispatch, getters, state}) {
        try {
            const data = await dispatch('serializeContentData', state.content);
            dispatch('preloader');
            // axios.get('https://api.github.com/users/benjamingeorge')
            //     .then(function (res) {
            //         console.log(res.data);
            //     })
            //     .catch(function(res) {
            //         if(res instanceof Error) {
            //             console.log(res.message);
            //         } else {
            //             console.log(res.data);
            //         }
            //     });
            const response = await axios.post(window.shared.route, data)
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log('ERROR');
                    console.log(error);
                });
            let itemId = response.data.item.id;
            commit('setItemId', itemId);
            dispatch('fetchItems', {
                id:     itemId,
                silent: true
            });
            if (state.options.continue) {
                window.history.pushState(null, null, window.shared.route + '/' + itemId + '/edit');
            } else {
                window.location.href = window.shared.route;
            }
            dispatch('userMessage', 'Created successfully');
            commit('setErrors', {})
        } catch ({response = {}}) {
            console.log('errorResponse: ', response);
            // commit('setErrors', response.data.errors);
            Vue.swal().close()
        }
    },
    async fetchItems({commit, dispatch, getters, state}, inputData) {
        try {
            if (!inputData.silent) {
                dispatch('preloader');
            }
            const response = await axios.get(window.shared.route + '/' + inputData.id);
            console.log('response: ', response);
            const data = await dispatch('deSerializeResponseData', response.data);
            commit('setContent', data)
            if (!inputData.silent) {
                Vue.swal().close()
            }
            commit('setErrors', {})
        }
        catch (response) {
            console.warn(response)
            commit('setErrors', response.data.errors);
            Vue.swal().close()
        }
    },
    async updateItems({commit, dispatch, getters, state}, id) {
        try {
            const data = await dispatch('serializeContentData', state.content);
            dispatch('preloader');
            const response = await axios.put(window.shared.route + '/' + id, data);
            if (!state.options.continue) {
                window.location.href = window.shared.route;
            }
            dispatch('fetchItems', {
                id:     id,
                silent: true
            });
            dispatch('userMessage', 'Updated successfully');
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
            const response = await axios.delete(window.shared.route + '/' + id, config);
            dispatch('userMessage', 'Deleted successfully');
            window.location.replace(response.data.redirectUrl);
        } catch ({response = {}}) {
            commit('setErrors', response.data.errors);
            Vue.swal().close()
        }
    },
    async serializeContentData({state}) {
        let categories = {};
        console.log('state.content.categories: ', state.content.categories);
        state.content.categories.map(function (category, index) {
            categories[category.id] = {is_main: false};
        });
        console.log('state.content.parent.id: ', state.content.parent.id);
        categories[state.content.parent.id] = {is_main: true};

        return {
            items:       {
                alias:           state.content.alias,
                user_id:         state.content.author ? state.content.author.id : null,
                pub_date:        state.content.pub_date.toLocaleString("uk-UA"),
                pub_by_schedule: state.content.pub_by_schedule,
                name:            state.content.title,
                subtitle:        state.content.subtitle,
                tech:            state.content.tech,
                field_item_id:   state.content.image ? state.content.image.id : state.content.field_item_id,
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
            fields:     state.content.fields.map(function (field, index) {
                return {
                    id:            field.id,
                    field_type_id: field.field_type_id,
                    body:          field.body,
                    image:         field.image,
                    field_items:   field.field_items,
                    boolean:       field.boolean,
                    visible:       field.visible,
                    title:         field.title,
                    filename:      field.filename,
                    file:          field.file,
                    subtitle:      field.subtitle,
                    component:     field.component,
                    position:      index,
                    resolutionKey: field.resolutionKey || null,
                }
            }),
        };
    },
    async deSerializeResponseData({state}, data) {
        // let parent = data.categories.filter(category => category.pivot.is_main === 1).shift();
        // let categories = data.categories.filter(category => category.pivot.is_main === 0);

        return {
            id:              data.id,
            alias:           data.alias,
            // parent:          parent,
            // author:          data.author,
            // pub_date:        new Date(data.pub_date),
            // pub_by_schedule: data.pub_by_schedule,
            title:           data.name,
            // subtitle:        data.subtitle,
            // field_item_id:   data.field_item_id,
            // tech:            data.tech,
            // description:     data.description,
            config: {
            //     enable_comments: data.can_comment,
            //     hide_author:     data.hide_author,
            //     lenta:           data.lenta,
            //     top_lenta:       data.top_lenta,
            //     main_primary:    data.main_primary,
            //     main_secondary:  data.main_secondary,
                visibility:      true,
            //     parsed:          data.parsed,
            },
            // categories:      categories,
            // tags:            data.tags,
            fields:          data.fields
                                 .sort((a, b) => a.position - b.position)
                                 .map(function (field, index) {
                                     return {
                                         id:            field.id,
                                         // uid:           Math.floor(Math.random() * 10000) + 1,
                                         // body:          field.body,
                                         // title:         field.title,
                                         // subtitle:      field.subtitle,
                                         field_items:   field.field_items,
                                         // boolean:       field.boolean,
                                         visible:       field.visible,
                                         position:      field.position,
                                         component:     field.type.component,
                                         name:          field.type.name,
                                         field_type_id: field.field_type_id,
                                         icon:          field.type.icon,
                                         // resolutionKey: field.resolutionKey,
                                     }
                                 }),
        };
    },

    async preloader() {
        Vue.swal({
                     title:             'Wait',
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

