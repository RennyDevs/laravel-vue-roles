<template>
  <div>
    <modal id="ModalChangePassword">

      <h4 class="card-title" slot="modal-title">Cambio de Contraseña.</h4>

      <template slot="modal-body">
        <div class="row justify-content-center">
          <div class="col-md-10">
            <form id="ChangePassword" class="form-horizontal" @keyup.enter="register()">

              <inputC required="true"
                      v-model="pass.passwordold"
                      name="passwordold" type="password"
                      @input="pass.passwordold = arguments[0]">
                <span slot="text">Ingrese su contraseña actual</span>
                <span slot="help" v-text="msg.passwordold"></span>
              </inputC>

              <inputC required="true"
                      v-model="pass.passwordnew"
                      name="passwordnew" type="password"
                      @input="pass.passwordnew = arguments[0]">
                <span slot="text">Ingrese su nueva contraseña</span>
                <span slot="help" v-text="msg.passwordnew"></span>
              </inputC>

              <inputC required="true"
                      v-model="pass.passwordnew_confirmation"
                      name="passwordnew_confirmation" type="password"
                      @input="pass.passwordnew_confirmation = arguments[0]">
                <span slot="text">Confirme su nueva contraseña</span>
                <span slot="help" v-text="msg.passwordnew_confirmation"></span>
              </inputC>

            </form>
          </div>
        </div>
      </template>

      <button type="button" class="btn btn-primary" slot="modal-btn" @click="register()">Modificar</button>

    </modal>
  </div>
</template>

<script>
  import Modal from './../partials/modal.vue';
  import Input from './../partials/input.vue';

  export default {
    name: 'modal-changePassword-user',
    components: {
      'modal': Modal,
      'inputC': Input
    },
    data () {
      return {
        pass: {
          passwordold: '',
          passwordnew: '',
          passwordnew_confirmation: ''
        },
        msg: {
          passwordold: 'Contraseña Actual.',
          passwordnew: 'Nueva Contraseña.',
          passwordnew_confirmation: 'Confirmacion de nueva contraseña.'
        }
      };
    },
    methods: {
      register: function () {
        axios.post('/edit-password', this.pass)
        .then(response => {
          console.log('Contraseña Cambiada con exito.');
          this.pass = {
            passwordold: '',
            passwordnew: '',
            passwordnew_confirmation: ''
          };
          $('#ModalChangePassword').modal('toggle');
        });
      }
    }
  }
</script>
