<template>
  <div>
    <select class="form-control"></select>
  </div>
</template>

<script>
import $ from "jquery";

export default {
  name: "Select2",
  data() {
    return {
      select2: null
    };
  },
  model: {
    event: "change",
    prop: "value"
  },
  props: {
    options: {
      type: Array,
      default: () => []
    },
    placeholder: {
      type: String,
      default: ""
    },
    settings: {
      type: Object,
      default: () => {}
    },
    placeholder: {
      type: String,
      default: ""
    },
    invalid: {
      type: Boolean,
      default: false
    },

    value: null
  },
  watch: {
    options(val) {
      this.setOption(val);
    },
    value(val) {
      this.setValue(val);
    },
    invalid() {
      this.invalid
        ? this.select2.addClass("is-invalid")
        : this.select2.hasClass("is-invalid")
        ? this.select2.removeClass("is-invalid")
        : "";
    }
  },
  methods: {
    setOption(val = []) {
      this.select2.empty();
      this.select2.select2({
        placeholder: this.placeholder,
        ...this.settings,
        data: val
      });
      this.setValue(this.value);
    },

    setValue(val) {
      if (val instanceof Array) {
        this.select2.val([...val]);
      } else {
        this.select2.val([val]);
      }

      this.select2.trigger("change");
    }
  },
  mounted() {
    this.select2 = $(this.$el)
      .find("select")
      .select2({
        placeholder: this.placeholder,
        ...this.settings,
        data: this.options
      })
      .on("select2:select select2:unselect", ev => {
        this.$emit("change", this.select2.val());
        this.$emit("select", ev["params"]["data"]);
      });

    this.setValue(this.value);
  },
  beforeDestroy() {
    this.select2.select2("destroy");
  }
};
</script>
