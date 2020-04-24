<template>
    <div class="modal fade" id="createPostModal" tabindex="-1" role="dialog" aria-labelledby="createPostModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="createPost">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   class="form-control"
                                   :class="{'is-invalid': errors.title }"
                                   placeholder="Type your title"
                                   v-model="form.title">
                            <span v-if="errors.title" class="invalid-feedback" role="alert">
                                <strong>{{ errors.title[0] }}</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="excerpt">Excerpt</label>
                            <textarea id="excerpt"
                                      name="excerpt"
                                      class="form-control"
                                      :class="{'is-invalid': errors.excerpt }"
                                      placeholder="Type your excerpt"
                                      v-model="form.excerpt"></textarea>
                            <span v-if="errors.excerpt" class="invalid-feedback" role="alert">
                                <strong>{{ errors.excerpt[0] }}</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="published_at">Published at</label>
                            <input type="date"
                                   id="published_at"
                                   name="published_at"
                                   class="form-control"
                                   :class="{'is-invalid': errors.published_at}"
                                   v-model="form.published_at">
                            <span v-if="errors.published_at" class="invalid-feedback" role="alert">
                                <strong>{{ errors.published_at[0] }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit-post" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                errors: [],
                form: {
                    title: '',
                    excerpt: '',
                    published_at: ''
                },
            }
        },
        methods: {
            createPost() {
                axios
                    .post('api/posts', this.form)
                    .then(res => {
                        this.form = res.data;
                        this.$emit('postCreated', this.form)
                    })
                    .catch(err=>{
                        console.log(err.response.data.errors)
                        this.errors = err.response.data.errors;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
