<template>
  <div class="form-group">
    <label for="categories">Categories</label>
    <Select2
      v-model="selected"
      :options="categories"
      :settings="{ placeholder:'Select Category',tags:true}"
      :class="{'is-invalid': errors.category }"
    />
    <span v-if="errors.category" class="invalid-feedback" role="alert">
      <strong>{{ errors.category[0] }}</strong>
    </span>
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
    selected(val) {
        this.$emit('category', val)
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
