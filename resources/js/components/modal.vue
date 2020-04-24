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
                                   placeholder="Type your title"
                                   v-model="form.title">
                        </div>
                        <div class="form-group">
                            <label for="excerpt">Excerpt</label>
                            <textarea id="excerpt"
                                      name="excerpt"
                                      class="form-control"
                                      placeholder="Type your excerpt"
                                      v-model="form.excerpt"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="published_at">Published at</label>
                            <input type="date"
                                   id="published_at"
                                   name="published_at"
                                   class="form-control"
                                   v-model="form.published_at">
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
                        this.$emit('postCreated',this.form)
                    })
            }
        }
    }
</script>

<style scoped>

</style>
