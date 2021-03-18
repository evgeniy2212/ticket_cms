export default {
    // action panel
    switchTab(state, tab) {
        state.ui.activeTab = tab;
    },
    // editor tab
    setTitle(state, value) {
        state.content = {
            ...state.content,
            title: value.substr(0, state.ui.limit)
        };
    },
    setImage(state, value) {
        state.content = {
            ...state.content,
            image: value
        };
    },
    setParent(state, value) {
        state.content = {
            ...state.content,
            parent: value
        };
    },
    setSubTitle(state, value) {
        state.content = {
            ...state.content,
            subtitle: value.substr(0, state.ui.limit)
        }
    },
    setAuthor(state, value) {
        state.content = {
            ...state.content,
            author: value
        };
    },
    setTech(state, value) {
        state.content = {
            ...state.content,
            tech: value
        };
    },
    setItemId(state, value) {
        state.content = {
            ...state.content,
            id: value
        };
    },
    setTags(state, value) {
        state.content = {
            ...state.content,
            tags: value
        };
    },
    setCategories(state, value) {
        state.content = {
            ...state.content,
            categories: value
        };
    },
    setTemplate(state, value) {
        console.log('setTemplate: ', state, value.name);
        state.content = {
            ...state.content,
            template: value.name
        };
    },
    // constructor
    pushField(state, type) {
        if (type !== undefined) {
            let field = {
                uid          : Math.floor(Math.random() * 1000) + 1,
                component    : type.component,
                field_type_id: type.id,
                icon         : type.icon,
                name         : type.name,
                body         : type.template,
                visible      : type.visible !== undefined && type.visible !== null ? type.visible : true,
                field_items  : [],
            };
            state.content.fields.push(field);
        }
    },
    shuffleFields(state, value) {
        state.content = {
            ...state.content,
            fields: value
        }
    },
    deleteField(state, value) {
        state.content = {
            ...state.content,
            fields: state.content.fields.filter((item) => {
                return item.uid !== value.uid
            })
        }
    },
    updateField(state, payload) {
        let {field, value} = payload
        state.content.fields = state.content.fields.map(function (item) {
            if(item.uid === field.uid){
                return item = {
                    ...item,
                    ...value
                }
            } else {
                return item;
            }

        });
    },

    // settings tab
    setPubDate(state, value) {
        state.content = {
            ...state.content,
            pub_date: new Date(value)
        };
    },
    setPubBySchedule(state, value) {
        state.content = {
            ...state.content,
            pub_by_schedule: value
        };
    },
    setAlias(state, value) {
        state.content = {
            ...state.content,
            alias: value
        };
    },
    setConfigLenta(state, value) {
        state.content.config = {
            ...state.content.config,
            lenta: value
        }
    },
    setConfigTopLenta(state, value) {
        state.content.config = {
            ...state.content.config,
            top_lenta: value
        }
    },
    setConfigMainPrimary(state, value) {
        state.content.config = {
            ...state.content.config,
            main_primary: value
        }
    },
    setConfigMainSecondary(state, value) {
        state.content.config = {
            ...state.content.config,
            main_secondary: value
        }
    },
    setConfigHideAuthor(state, value) {
        state.content.config = {
            ...state.content.config,
            hide_author: value
        }
    },
    setConfigCanComment(state, value) {
        state.content.config = {
            ...state.content.config,
            can_comment: value
        }
    },
    setConfigVisibility(state, value) {
        state.content.config = {
            ...state.content.config,
            visibility: value
        }
    },
    setContent(state, value) {
        console.log('setContent', value);
        state.content = value;
    },
    setErrors(state, value) {
        if(value['news.alias']){
            this.commit('switchTab', 'settings');
        }
        state.errors = value;
    },
    setOptionContinue(state, value) {
        state.options = {
            ...state.options,
            continue: value
        };
    },
}
