<template>
  <div class="form-group">
    <label for="categories">Categories</label>
    <Select2
      v-model="selected"
      :options="categories"
      :settings="{ placeholder:'Select Category',tags:true,theme: 'bootstrap4'}"
      :invalid="errors.has('category')"
      @keydown="errors.clear('category')"
    />
    <span
      class="invalid-feedback"
      role="alert"
      v-show="errors.has('category')"
      v-text="errors.get('category')"
    ></span>
  </div>
</template>

<script>
import Select2 from "../../../components/select2";
export default {
  components: { Select2 },
  props: ["errors"],
  data() {
    return {
      selected: "",
      categories: []
    };
  },
  mounted() {
    this.fetchCategories();
  },
  watch: {
    selected() {
      this.$emit("selected", this.selected);
    }
  },
  methods: {
    fetchCategories() {
      let first = [{ id: "", text: "" }];
      axios.get("api/categories").then(res => {
        this.categories = _.concat(first, this.options(res.data.data));
      });
    },
    options(data) {
      return _.map(data, function(data) {
        let pick = _.pick(data, "name", "id");
        return { id: pick.id, text: pick.name };
      });
    }
  }
};
</script>

<style>
</style>
