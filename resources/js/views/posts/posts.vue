<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Posts
                        <button type="button" id="create-modal" class="btn btn-primary" @click="postCreated">Create Posts</button>
                    </div>
                    <div class="card-body">
                      <p>Posts list</p>
                    </div>
                </div>
            </div>
        </div>
        <modal title="Create Posts" :isXLarge="true" :backdropClose="false" v-if="show_modal" @close="show_modal = false">
            <post-form @close="show_modal = false"
                       :edit_mode=false
                       :edit_post=false>
            </post-form>
        </modal>
    </div>
</template>

<script>
    import Modal from '../../components/modal';
    import PostForm from './partials/form'
    export default {
        components:{
            Modal,
            PostForm
        },
        data(){
            return {
                show_modal: false,
            }
        },
        methods:{
            postCreated(){
                this.show_modal = true
            }
        }
    };
</script>
