<template>
  <form @submit.prevent="edit_mode ? updatePost() : createPost()">
    <div class="modal-body">
      <div class="row">
        <div class="col-md-8">
          <div class="form-group">
            <label for="title">Title</label>
            <input
              type="text"
              id="title"
              name="title"
              class="form-control"
              placeholder="Type your title"
              v-model="post.title"
              :class="{'is-invalid': post.errors.has('title') }"
              @keydown="post.errors.clear('title')"
            />
            <span
              class="invalid-feedback"
              role="alert"
              v-show="post.errors.has('title')"
              v-text="post.errors.get('title')"
            ></span>
          </div>

          <select2-categories
          :errors="post.errors"
          @selected="addSelectedCategory">
          </select2-categories>
          <select2-tags :errors="post.errors" @selected="addSelectedTags"></select2-tags>

          <div class="form-group">
            <label for="excerpt">Excerpt</label>
            <vue-editor
              id="excerpt"
              name="excerpt"
              :class="{'is-invalid': post.errors.has('excerpt') }"
              v-model="post.excerpt"
              @keydown="post.errors.clear('excerpt')"
            />
            <span
              class="invalid-feedback"
              role="alert"
              v-show="post.errors.has('excerpt')"
              v-text="post.errors.get('excerpt')"
            ></span>
          </div>
        </div>
        <div class="col-md-4">
          <b-form-group
            description="Let us know your name."
            label="Enter your name"
            label-for="published_at"
          >
            <b-form-datepicker id="published_at" v-model="post.published_at" class="mb-2"></b-form-datepicker>

            <span
              class="invalid-feedback"
              role="alert"
              v-show="post.errors.has('published_at')"
              v-text="post.errors.get('published_at')"
            ></span>
          </b-form-group>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" @click="close">Cancel</button>
      <button
        v-show="edit_mode"
        type="submit"
        class="btn btn-primary"
        id="submit-update-btn"
      >Update Posts</button>
      <button
        v-show="!edit_mode"
        type="submit"
        class="btn btn-primary"
        dusk="submit-create-btn"
      >Create Posts</button>
    </div>
  </form>
</template>

<script>
import { VueEditor } from "vue2-editor";
import Select2Categories from "./catSelect2";
import Select2Tags from "./tagsSelect2";

export default {
  props: ["edit_post", "edit_mode"],
  components: { VueEditor, Select2Categories, Select2Tags },
  data() {
    return {
      post: new Form({
        title: "",
        excerpt: "",
        published_at: "",
        category: "",
        tags: []
      })
    };
  },
  mounted() {},
  methods: {
    createPost() {
      let data = new FormData();
      data.append("title", this.post.title);
      data.append("excerpt", this.post.excerpt);
      data.append("published_at", this.post.published_at);
      data.append("category", this.post.category);
      data.append("tags", this.post.tags);

      axios
        .post("api/posts", data)
        .then(response => {
          this.persistData(response);
          this.post.reset();
        })
        .catch(
          error => {
            this.post.errors.record(error.response.data);
          }
        );
    },
    updatePost() {
      console.log("update Posts");
    },
    persistData(res) {
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: res.data.success,
        showConfirmButton: false,
        timer: 1500
      });
      this.$Progress.finish();

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
    addSelectedCategory($event) {
      this.post.category = $event;
    },
    addSelectedTags($event) {
      console.log($event);
      this.post.tags = $event;
    }
  }
};
</script>

<style scoped>
</style>
