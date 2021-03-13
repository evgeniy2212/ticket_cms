export default {
    // ui data (active tab, elements visibility etc)
    ui: {
        activeTab:      'editor',
        allowDeleteBtn: false,
        limit:          100,
        limitDefault:   255,
        limitBody:      65535,
    },
    options: {
        continue: true
    },
    // dictionaries passed from laravel
    dic:     {
        field_types: window.shared.types,
        categories:  window.shared.categories,
        authors:     window.shared.authors,
        resolutions: window.shared.resolutions,
    },
    errors: {

    },
    // main object data sent to backend
    content: {
        id:              window.shared.itemId,
        parent:          '',
        alias:           '',
        pub_date:        new Date(),
        pub_by_schedule: false,
        title:           '',
        subtitle:        '',
        tech:            '',
        categories:      [],
        tags:            [],
        author:          '',
        fields:          [],
        config:          {
            visibility:     0,
            lenta:          false,
            top_lenta:      false,
            hide_author:    false,
            main_primary:   false,
            main_secondary: false,
            can_comment:    false,
            parsed:    false
        }
    }
}
