<template>
  <div class="form-group">
    <label :for="name.id" class="control-label">
      <span :class="name.icon"></span> {{ name.label }}:
    </label>
    <input
      :type="type"
      :id="name.id"
      :value="value"
      class="form-control"
      :required="required"
      :readonly="readonly"
      :placeholder="placeholder"
      @input="updateValue($event.target.value)"
    />
    <small :id="name.id + 'Help'" class="form-text text-muted">{{ msg }}</small>
  </div>
</template>

<script>
export default {
  name: "input-form",
  props: {
    name: {},
    msg: {},
    type: {
      default: "text",
    },
    placeholder: {},
    required: {},
    value: {},
    readonly: {
      default: false,
    },
  },
  methods: {
    updateValue: function (value) {
      this.$emit("input", value);
    },
  },
};
</script>
