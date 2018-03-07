<template>
    <div class="form-group">
        <label :for="name" class="control-label">
            <slot name="text"></slot>:
        </label>
        <input :id="name"
                :type="type"
                class="form-control"
                :placeholder="placeholder"
                :required="required"
                :value="value"
                :readonly="readonly"
                @input="updateValue($event.target.value)">
        <small :id="name + 'Help'" class="form-text text-muted"><slot name="help"></slot></small>
    </div>
</template>

<script>
export default {
    name: 'input-form',
    props: {
        name: {},
        type: {
            default: 'text'
        },
        placeholder: {},
        required: {},
        value: {},
        readonly: {}
    },
    methods: {
        updateValue: function (value) {
          var formattedValue = value.trim()
          this.$emit('input', formattedValue)
      }
    }
}
</script>
