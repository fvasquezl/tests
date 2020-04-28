<template>
    <form @submit.prevent="edit_mode ? updatePost() : createPost()">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text"
                               id="title"
                               name="title"
                               class="form-control"
                               :class="{'is-invalid': errors.title }"
                               placeholder="Type your title"
                               v-model="post.title">
                        <span v-if="errors.title" class="invalid-feedback" role="alert">
                            <strong>{{ errors.title[0] }}</strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="excerpt">Excerpt</label>
                        <vue-editor id="excerpt"
                                    name="excerpt"
                                    :class="{'is-invalid': errors.excerpt }"
                                    v-model="post.excerpt"
                                    :editor-toolbar="customToolbar" />

                        <span v-if="errors.excerpt" class="invalid-feedback" role="alert">
                            <strong>{{ errors.excerpt[0] }}</strong>
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="published_at">Published at</label>
                        <input type="date"
                               id="published_at"
                               name="published_at"
                               class="form-control"
                               :class="{'is-invalid': errors.published_at}"
                               v-model="post.published_at">
                        <span v-if="errors.published_at" class="invalid-feedback" role="alert">
                            <strong>{{ errors.published_at[0] }}</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="close">Cancel</button>
            <button v-show="edit_mode" type="submit" class="btn btn-primary" id="submit-update-btn">Update Posts
            </button>
            <button v-show="!edit_mode" type="submit" class="btn btn-primary" dusk="submit-create-btn">Create Posts
            </button>
        </div>
    </form>
</template>

<script>
    import {VueEditor} from "vue2-editor";

    export default {
        props: ['edit_post', 'edit_mode'],
        components: { VueEditor },
        data() {
            return {
                customToolbar: [
                    ["bold", "italic", "underline"],
                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ list: "ordered" }, { list: "bullet" }],
                    ["image", "code-block"]
                ],
                errors: [],
                post: {
                    title: '',
                    excerpt: '',
                    published_at: ''
                },
            }
        },
        methods: {
            createPost() {
                axios.post('api/posts', this.post)
                    .then(res => {
                        this.persistData(res);
                    })
                    .catch(err => {
                        this.errors = err.response.data.errors;
                    })
            },
            updatePost() {
                console.log('update Posts')
            },
            persistData(res) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: res.data.success,
                    showConfirmButton: false,
                    timer: 1500
                });
                this.$Progress.finish();
                // this.$emit("reload");
                this.$emit("close");
            },
            close() {
                this.$emit("close");
            },
            mounted() {
                if (this.edit_mode) {
                    this.post = this.edit_post;
                }
            },

        }
    }
</script>

<style scoped>

</style>
