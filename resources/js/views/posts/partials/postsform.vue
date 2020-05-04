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
              :class="{'is-invalid': errors.title }"
              placeholder="Type your title"
              v-model="post.title"
            />
            <span v-if="errors.title" class="invalid-feedback" role="alert">
              <strong>{{ errors.title[0] }}</strong>
            </span>
          </div>

          <div class="form-group">
            <label for="categories">Categories</label>
            <Select2
              v-model="post.category"
              id="category"
              :options="categories"
              :settings="{tags:true}"
              :class="{'is-invalid': errors.category }"

              @tags="createNewCategory($event)"
            />
            <span v-if="errors.category" class="invalid-feedback" role="alert">
              <strong>{{ errors.category[0] }}</strong>
            </span>
          </div>

          <div class="form-group">
            <label for="tags">Tags</label>
            <Select2
              v-model="post.tags"
              id="tags"
              :options="tags"
              :class="{'is-invalid': errors.tags }"
              :settings="{multiple:true, tags:true}"
              @change="myChangeEvent($event)"
              @select="mySelectEvent($event)"
              @tags="addTags($event)"
            />
            <span v-if="errors.tags" class="invalid-feedback" role="alert">
              <strong>{{ errors.tags[0] }}</strong>
            </span>
          </div>

          <div class="form-group">
            <label for="excerpt">Excerpt</label>
            <vue-editor
              id="excerpt"
              name="excerpt"
              :class="{'is-invalid': errors.excerpt }"
              v-model="post.excerpt"
            />

            <span v-if="errors.excerpt" class="invalid-feedback" role="alert">
              <strong>{{ errors.excerpt[0] }}</strong>
            </span>
          </div>
        </div>
        <div class="col-md-4">
          <b-form-group
            description="Let us know your name."
            label="Enter your name"
            label-for="published_at"
          >
            <b-form-datepicker id="published_at" v-model="post.published_at" class="mb-2"></b-form-datepicker>

            <span v-if="errors.published_at" class="invalid-feedback" role="alert">
              <strong>{{ errors.published_at[0] }}</strong>
            </span>
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
import Select2 from "v-select2-component";

export default {
  props: ["edit_post", "edit_mode"],
  components: { VueEditor, Select2 },
  data() {
    return {
      customToolbar: [
        ["bold", "italic", "underline"],
        [{ header: 1 }, { header: 2 }],
        [{ size: ["small", false, "large", "huge"] }],
        [{ list: "ordered" }, { list: "bullet" }],
        ["image", "code-block"]
      ],
      errors: [],
      categories: [],
      tags: [],
      post: {
        title: "",
        excerpt: "",
        published_at: "",
        category: "",
        tags: []
      }
    };
  },
  mounted() {
    this.fetchCategories();
    this.fetchTags();
  },
  methods: {
    fetchCategories() {
      axios.get("api/categories").then(res => {
        this.categories = _.map(res.data.data, function(data) {
          let pick = _.pick(data, "name", "id");
          return { id: pick.id, text: pick.name };
        });
      });
    },
    fetchTags() {
      axios.get("api/tags").then(res => {
        this.tags = _.map(res.data.data, function(data) {
          let pick = _.pick(data, "name", "id");
          return { id: pick.id, text: pick.name };
        });
      });
    },
    createPost() {
      axios
        .post("api/posts", this.post)
        .then(res => {
          this.persistData(res);
        })
        .catch(err => {
          this.errors = err.response.data.errors;
        });
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
    createNewCategory(cat) {
      axios
        .post("api/categories", {'name':cat})
        .then(res => {
          const category = {
            name: res.data.data.name,
            id: res.data.data.id
          };
          this.categories.push(category);
        //  this.$set(this.category, 'b', 2)
        })
        .catch(err => {
          this.errors = err.response.data.errors;
        });
    },

    createNewTag({ id, text }) {
    //  console.log({ id, text });
    }
  }
};
</script>

<style scoped>
</style>
