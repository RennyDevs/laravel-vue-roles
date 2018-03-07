<template>
  <div>
    <modal id="ModalUser">

      <h4 class="card-title" slot="modal-title" v-text="formData.title"></h4>

      <template slot="modal-body">
        <div class="row justify-content-center">
          <div class="col-md-10">
            <form id="UserForm" class="form-horizontal" @keyup.enter="registrar()">

              <div v-if="!formData.ready">Cargando...</div>
              <div v-else>
                <inputC name="user" required="true"
                        v-model="formData.user.user"
                        @input="formData.user.user = arguments[0]">
                  <span slot="text">Usuario</span>
                  <span slot="help" v-text="msg.user"></span>
                </inputC>

                <inputC name="name" required="true"
                        v-model="formData.user.name"
                        @input="formData.user.name = arguments[0]">
                  <span slot="text">Nombre</span>
                  <span slot="help" v-text="msg.name"></span>
                </inputC>

                <inputC name="last_name" required="true"
                        v-model="formData.user.last_name"
                        @input="formData.user.last_name = arguments[0]">
                  <span slot="text">Apellido</span>
                  <span slot="help" v-text="msg.last_name"></span>
                </inputC>

                <inputC name="num_id" required="true"
                        v-model="formData.user.num_id"
                        @input="formData.user.num_id = arguments[0]">
                  <span slot="text">Cedula</span>
                  <span slot="help" v-text="msg.num_id"></span>
                </inputC>

                <inputC name="email" type="email" required="true"
                        v-model="formData.user.email"
                        @input="formData.user.email = arguments[0]">
                  <span slot="text">E-Mail</span>
                  <span slot="help" v-text="msg.email"></span>
                </inputC>

                <inputC name="password" type="password" required="true"
                        v-model="formData.user.password"
                        @input="formData.user.password = arguments[0]">
                  <span slot="text">Password</span>
                  <span slot="help" v-text="msg.password"></span>
                </inputC>

                <inputC name="password_confirmation" type="password" required="true"
                        v-model="formData.user.password_confirmation"
                        @input="formData.user.password_confirmation = arguments[0]">
                  <span slot="text">Password Confirmatión</span>
                  <span slot="help" v-text="msg.password_confirmation"></span>
                </inputC>

                <selectC name="module_id" required="true"
                        v-model="formData.user.module_id"
                        @input="formData.user.module_id = arguments[0]">
                  <span slot="text">Módulo</span>
                  <template slot="options">
                    <option value="">Seleccione un Modulo</option>
                    <option v-for="(module, key, index) in modules" :value="key">{{ module }}</option>
                  </template>
                  <span slot="help" v-text="msg.module_id"></span>
                </selectC>

                <div class="form-group">
                  <label for="roles" class="control-label">Roles:</label>
                  <select class="form-control" required multiple v-model="formData.user.roles">
                    <option v-for="(rol, key, index) in roles" :value="key">{{ rol }}</option>
                  </select>
                  <small id="rolesHelp" class="form-text text-muted">
                    <span slot="help" v-text="msg.roles"></span>
                  </small>
                </div>

              </div>

            </form>
          </div>
        </div>
      </template>

      <button type="button" class="btn btn-primary" slot="modal-btn" @click="registrar()">Guardar</button>

    </modal>
  </div>
</template>

<script>
  import Modal from './../partials/modal.vue';
  import Input from './../partials/input.vue';
  import Select from './../partials/select.vue';

  export default {
    name: 'modal-form-user',
    components: {
      'modal': Modal,
      'inputC': Input,
      'selectC': Select
    },
    props: ['formData'],
    data () {
      return {
        modules: [],
        roles: [],
        msg: {
          user: 'Usuario unico.',
          name: 'Nombre del usuario.',
          last_name: 'Apellido del usuario.',
          num_id: 'Cedula de identidad.',
          email: 'Correo electronico.',
          password: 'Contraseña.',
          password_confirmation: 'Confirmacion de Contraseña.',
          roles: 'Rol a desempeñar.',
          module_id: 'Modulo a desempeñar.'
        }
      };
    },
    mounted: function () {
      axios.post('/get-data-users')
      .then(response => {
        this.modules = response.data.modules;
        this.roles = response.data.roles;
      });
    },
    methods: {
      registrar: function () {
        if (this.formData.cond === 'create') {
          axios.post(this.formData.url, this.formData.user)
          .then(response => {
            console.log('usuario Creado Exitosamente');
            $('#ModalUser').modal('toggle');
            this.$emit('updateUsers');
          }).catch(errors => {this.errorsManager(errors.response); });
        } else {
          axios.put(this.formData.url, this.formData.user)
          .then(response => {
            console.log('usuario Editado Exitosamente');
            $('#ModalUser').modal('toggle');
            this.$emit('updateUsers');
          });
        }
      },
      restoremsg: function function_name() {
        for(let n in this.msg) {
          $('small#' + n + 'Help').removeClass('text-danger');
          $('small#' + n + 'Help').addClass('text-muted');
          $('small#' + n + 'Help').text(this.msg[n]);
        }
      }
    }
  }
</script>
