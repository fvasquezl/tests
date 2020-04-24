<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Posts
                        <button type="button" class="btn btn-primary" id="create-modal" data-toggle="modal" data-target="#createPostModal">
                            Create Post
                        </button>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
        <create-post-modal v-on:postCreated=postCreated ></create-post-modal>
    </div>
</template>

<script>
    import CreatePostModal from "../../components/modal";
    export default {
        components:{
            CreatePostModal
        },
        methods:{
            postCreated(){
                $('#createPostModal').modal('hide');
            }
        }
    };
</script>
