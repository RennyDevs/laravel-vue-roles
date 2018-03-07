<template>
	<div :id="id" class="alert alert-dismissible fade show" :class="'alert-' + type" role="alert">
		<slot name="text"></slot>
		<button type="button" class="close" aria-label="Close" @click="cerrar()">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
</template>

<script>
export default {
	name: 'alert-form',
	props: {
		type: {},
		id: {},
	},
	methods: {
		cerrar: function (asd) {
			$('.alert').fadeOut();
		}
	}
}
</script>

<!-- 
<div class="alert alert-primary" role="alert">
  This is a primary alert—check it out!
</div>
<div class="alert alert-secondary" role="alert">
  This is a secondary alert—check it out!
</div>
<div class="alert alert-success" role="alert">
  This is a success alert—check it out!
</div>
<div class="alert alert-danger" role="alert">
  This is a danger alert—check it out!
</div>
<div class="alert alert-warning" role="alert">
  This is a warning alert—check it out!
</div>
<div class="alert alert-info" role="alert">
  This is a info alert—check it out!
</div>
<div class="alert alert-light" role="alert">
  This is a light alert—check it out!
</div>
<div class="alert alert-dark" role="alert">
  This is a dark alert—check it out!
</div>
 -->