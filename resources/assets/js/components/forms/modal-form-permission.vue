<template>
  <div>
    <modal id="ModalPermission">

      <h4 class="card-title" slot="modal-title" v-text="formData.title"></h4>

      <template slot="modal-body">
        <div class="row justify-content-center">
          <div class="col-md-10">
            <form id="PermissionsForm" class="form-horizontal" @keyup.enter="registrar()">

              <div v-if="!formData.ready">Cargando...</div>
              <div v-else>
                <inputC name="name" required="true"
                        v-model="formData.permission.name"
                        @input="formData.permission.name = arguments[0]">
                  <span slot="text">Nombre</span>
                  <span slot="help" v-text="msg.name"></span>
                </inputC>

                <inputC name="module" required="true" readonly="true"
                        v-model="formData.permission.module"
                        @input="formData.permission.module = arguments[0]">
                  <span slot="text">Modulo</span>
                  <span slot="help" v-text="msg.module"></span>
                </inputC>

                <inputC name="action" required="true" readonly="true"
                        v-model="formData.permission.action"
                        @input="formData.permission.action = arguments[0]">
                  <span slot="text">Acción</span>
                  <span slot="help" v-text="msg.action"></span>
                </inputC>

                <inputC name="description" required="true"
                        v-model="formData.permission.description"
                        @input="formData.permission.description = arguments[0]">
                  <span slot="text">Descripción</span>
                  <span slot="help" v-text="msg.description"></span>
                </inputC>

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

  export default {
    name: 'modal-form-permission',
    components: {
      'modal': Modal,
      'inputC': Input
    },
    props: ['formData'],
    data () {
      return {
        msg: {
          name: 'Nombre del Permiso.',
          module: 'Modulo a ejecutarse.',
          action: 'Acción a Realizar.',
          description: 'Descripción a realizar.'
        }
      };
    },
    methods: {
      registrar: function () {
        if (this.formData.cond === 'edit') {
          axios.put(this.formData.url, this.formData.permission)
          .then(response => {
            console.log('Permiso Editado Exitosamente');
            $('#ModalPermission').modal('toggle');
            this.$emit('update');
          });
        }
      }
    }
  }
</script>
