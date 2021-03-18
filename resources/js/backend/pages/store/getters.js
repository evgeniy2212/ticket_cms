export default {
    // activity controls
    getActiveView(state) {
        return state.ui.activeTab
    },
    showEditor(state) {
        return state.ui.activeTab === 'editor'
    },
    showSettings(state) {
        return state.ui.activeTab === 'settings'
    },
    getLimit(state) {
        return state.ui.limit
    },
    getDefaultLimit(state) {
        return state.ui.limitDefault
    },
    getLimitBody(state) {
        return state.ui.limitBody
    },
    // editor tab
    // top editor
    getTitle(state) {
        return state.content.title
    },
    getCanComment(state) {
        return state.content.config.can_comment
    },
    getImageId(state) {
        return state.content.field_item_id
    },
    getSubTitle(state) {
        return state.content.subtitle
    },
    getItemId(state) {
        return state.content.id
    },
    isParsed(state) {
        return state.content.config.parsed;
    },
    getAuthor(state) {
        return state.content.author
    },
    getCategories(state) {
        return state.content.categories
    },
    getAuthorsList(state) {
        return state.dic.authors
    },
    getCategoriesList(state) {
        return state.dic.categories
    },
    getTemplate(state) {
        return state.content.template
    },
    getTemplatesList(state) {
        console.log('getTemplatesList state: ', state);
        return state.dic.templates
    },
    getPubBySchedule(state) {
        return state.content.pub_by_schedule
    },
    getResolutionList(state) {
        return state.dic.resolutions
    },
    // constructor
    getFieldTypes(state) {
        return state.dic.field_types
    },
    getFields(state) {
        console.log('state.content: ', state.content);
        return state.content.fields
    },
    // bottom editor
    getTechInfo(state) {
        return state.content.tech
    },
    getTags(state) {
        return state.content.tags
    },

    // settings tab
    getPubDate(state) {
        return state.content.pub_date
    },
    getAlias(state) {
        return state.content.alias
    },
    getVisibility(state) {
        return state.content.config.visibility
    },
    getLenta(state) {
        return state.content.config.lenta
    },
    getTopLenta(state) {
        return state.content.config.top_lenta
    },
    getTop(state) {
        return state.content.config.top
    },
    getMainPrimary(state) {
        return state.content.config.main_primary
    },
    getMainSecondary(state) {
        return state.content.config.main_secondary
    },
    getHideAuthor(state) {
        return state.content.config.hide_author
    },
    getParent(state) {
        return state.content.parent
    },
    getErrors(state) {
        return state.errors;
    },


}
