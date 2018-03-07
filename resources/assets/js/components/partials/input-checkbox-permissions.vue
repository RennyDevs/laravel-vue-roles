<template>
	<div class="row">
		<div class="col-md-6" v-for="(module, keym, indexm) in modules">
			<div class="card card-default">
				<div class="card-header">{{ module }}.</div>
				<div class="card-body" style="font-size: 13px;">
					<div class="form-group form-inline"
								v-for="(p, key, index) in permissions"
								v-if="p.module == keym">
						<label :for="'perm'+p.id" class="control-label">{{ p.name }}:</label>
						<input :id=" 'perm'+p.id"" type="checkbox" class="form-control" :value="p.id" v-model="permissionsRol" @change="update" :rs="p.action">
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'checkbox-permissions',
	props: ['user'],
	data () {
		return {
			permissionsRol: this.user,
			permissions: [],
			modules: {
				'module': 'Modulos',
				'user': 'Usuarios',
				'rol': 'Roles',
				'permission': 'Permisos',
			},
		};
	},
	mounted: function () {
		axios.post('/get-data-roles')
		.then(response => {
			this.permissions = response.data.permissions;
		})
		.then( () => {
			setTimeout(function () {
				let index = $('input[rs="index"]')
				for (var i = 0; i < index.length; i++) {
					if (!index[i].checked)
						$(index[i]).parent().parent().find('input[type="checkbox"]').attr('disabled', 'disabled');
				}
				index.removeAttr('disabled');
			}, 50);
			$('input[rs="index"]').change(function (e) {
				let all = $(this).parent().parent().find('input[type="checkbox"]');
				if (this.checked) {
					all.removeAttr('disabled', 'disabled');
				} else {
					all.attr('disabled', 'disabled');
				}
				$(this).removeAttr('disabled');
			});
		});
	},
	methods: {
		update: function () {
			this.$emit('check', this.permissionsRol);
		}
	}
}
</script>
