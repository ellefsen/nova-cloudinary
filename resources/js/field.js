Nova.booting((Vue, router, store) => {
    Vue.component('index-cloudinary', require('./components/IndexField'))
    Vue.component('detail-cloudinary', require('./components/DetailField'))
    Vue.component('form-cloudinary', require('./components/FormField'))
})
