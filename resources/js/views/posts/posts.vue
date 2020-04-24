<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Posts</div>
                    <div class="card-body">
                        <form @submit.prevent="createPost">
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
                            <button type="submit" id="create-post" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
                <pre>
                    {{response}}
                </pre>
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
                response:''
            }
        },
        methods: {
            createPost() {
                axios
                    .post('api/posts', this.form)
                    .then(res => {
                        console.log(res.data)
                        this.response = res.data
                    })
            }
        }
    };
</script>
