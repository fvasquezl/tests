<template>
  <div class="form-group">
    <label for="tags">Tags</label>
    <Select2
      v-model="selected"
      :options="tags"
      :settings="{multiple:true, tags:true ,theme: 'bootstrap4'}"
      :invalid="errors.has('tags')"
    />
    <span
      v-show="errors.has('tags')"
      v-text="errors.get('tags')"
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
      selected: [],
      tags: []
    };
  },
  mounted() {
    this.fetchTags();
  },
  watch: {
    selected() {
      this.$emit("selected", this.selected);
    }
  },
  methods: {
    fetchTags() {
      axios.get("api/tags").then(res => {
        this.tags = _.map(res.data.data, function(data) {
          let pick = _.pick(data, "name", "id");
          return { id: pick.id, text: pick.name };
        });
      });
    }
  }
};
</script>

<style>
</style>
