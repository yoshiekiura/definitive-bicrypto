export function loadLanguage() {
    return axios.get(route('language.load')).then(response => {
        return response.data;
    })
};
