export const mixins = {
    methods: {
        /**
         * Converts Date object to YYYY-MM-DD HH:mm format
         * @param date
         * @returns {string}
         */
        convertDateToString(date) {
            return date.getFullYear() +
                '-' + (date.getMonth() + 1) +
                '-' + date.getDate() +
                ' ' + date.getHours() +
                ':' + date.getMinutes();
        }

    }
}
