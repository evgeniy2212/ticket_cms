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
    setNewsId(state, value) {
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
    // constructor
    pushBlock(state, type) {
        if (type !== undefined) {
            let block = {
                uid          : Math.floor(Math.random() * 1000) + 1,
                component    : type.component,
                block_type_id: type.id,
                icon         : type.icon,
                name         : type.name,
                body         : type.template,
                visible      : type.visible !== undefined && type.visible !== null ? type.visible : true,
                block_items  : [],
            };
            state.content.blocks.push(block);
        }
    },
    shuffleBlocks(state, value) {
        state.content = {
            ...state.content,
            blocks: value
        }
    },
    deleteBlock(state, value) {
        state.content = {
            ...state.content,
            blocks: state.content.blocks.filter((item) => {
                return item.uid !== value.uid
            })
        }
    },
    updateBlock(state, payload) {
        let {block, value} = payload
        state.content.blocks = state.content.blocks.map(function (item) {
            if(item.uid === block.uid){
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
