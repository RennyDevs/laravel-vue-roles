<template>
  <div>
    <modal id="ModalRol">

      <h4 class="card-title" slot="modal-title" v-text="formData.title"></h4>

      <template slot="modal-body">
        <div class="row justify-content-center">
          <div class="col-md-10">
            <form id="RolesForm" class="form-horizontal" @keyup.enter="registrar()">

              <div v-if="!formData.ready">Cargando...</div>
              <div v-else>
                <inputC name="name" required="true"
                        v-model="formData.rol.name"
                        @input="formData.rol.name = arguments[0]">
                  <span slot="text">Nombre</span>
                  <span slot="help" v-text="msg.name"></span>
                </inputC>

                <inputC name="slug" required="true"
                        v-model="formData.rol.slug"
                        @input="formData.rol.slug = arguments[0]">
                  <span slot="text">Alias</span>
                  <span slot="help" v-text="msg.slug"></span>
                </inputC>

                <inputC name="description" required="true"
                        v-model="formData.rol.description"
                        @input="formData.rol.description = arguments[0]">
                  <span slot="text">Descripción</span>
                  <span slot="help" v-text="msg.description"></span>
                </inputC>

                <inputC name="from_at" required="true"
                        v-model="formData.rol.from_at"
                        @input="formData.rol.from_at = arguments[0]">
                  <span slot="text">Hora a comenzar la actividad</span>
                  <span slot="help" v-text="msg.from_at"></span>
                </inputC>

                <inputC name="to_at" required="true"
                        v-model="formData.rol.to_at"
                        @input="formData.rol.to_at = arguments[0]">
                  <span slot="text">Hora a finalizar la actividad</span>
                  <span slot="help" v-text="msg.to_at"></span>
                </inputC>

                <selectC name="special"
                        v-model="formData.rol.special"
                        @input="formData.rol.special = arguments[0]">
                  <span slot="text">Caracteristica especial</span>
                  <template slot="options">
                    <option value="">Ninguna</option>
                    <option value="all-access">Acceso total</option>
                    <option value="no-access">Sin acceso</option>
                  </template>
                  <span slot="help" v-text="msg.special"></span>
                </selectC>
                          
                <checkboxp v-if="!formData.rol.special"
                          :user="formData.rol.permissions"
                          @check="formData.rol.permissions = arguments[0]"
                          ></checkboxp>

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
  import CheckboxP from './../partials/input-checkbox-permissions.vue';

  export default {
    name: 'modal-form-rol',
    components: {
      'modal': Modal,
      'inputC': Input,
      'selectC': Select,
      'checkboxp': CheckboxP
    },
    props: ['formData'],
    data () {
      return {
        msg: {
          name: 'Nombre del rol.',
          slug: 'Alias del rol.',
          description: 'Descripción del rol.',
          from_at: 'Hora de actividad inicial.',
          to_at: 'Hora de actividad final.',
          special: 'Acceso privilegiado.',
          permission: 'Permisos del rol'
        }
      };
    },
    methods: {
      registrar: function () {
        if (this.formData.cond === 'create') {
          axios.post(this.formData.url, this.formData.rol)
          .then(response => {
            console.log('Rol Creado Exitosamente');
            $('#ModalRol').modal('toggle');
            this.$emit('update');
          });
        } else {
          axios.put(this.formData.url, this.formData.rol)
          .then(response => {
            console.log('Rol Editado Exitosamente');
            $('#ModalRol').modal('toggle');
            this.$emit('update');
          });
        }
      }
    }
  }
</script>
