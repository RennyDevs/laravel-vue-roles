<template>
	<div class="form-group">
		<label :for="name" class="control-label">
			<slot name="text"></slot>:
		</label>
		<select :id="name"
				class="form-control"
				:required="required"
				:value="value"
				@input="update($event.target.value)">
			<slot name="options">
				<option value=""></option>
			</slot>:
		</select>
		<small :id="name + 'Help'" class="form-text text-muted"><slot name="help"></slot></small>
	</div>
</template>

<script>
export default {
	name: 'select-form',
	props: {
		name: {},
		required: {},
		value: {},
	},
	methods: {
		update: function (value) {
			var formattedValue = value.trim()
			this.$emit('input', formattedValue)
		}
	}
}
</script>
