<template>
    <div v-if="action('index')">
        <div class="row">
            <div class="col-sm-4">
                <button type="button"
                    class="btn btn-default btn-sm"
                    data-toggle="modal"
                    data-target="#ModalRol"
                    @click="openform('create')"
                    v-if="action('create')">Crear</button>
            </div>
            <modalFormComponent @update="get(pagination.current_page)" :formData="formData" v-if="action('create') || action('update')"></modalFormComponent>
        </div>
        <div class="row justify-content-between">
            <div class="col-sm-1">
                <select v-model="num" class="form-control">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-sm-2">
                <input type="text" class="form-control" v-model="search" placeholder="Busqueda">
            </div>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Alias</th>
                        <th>Caracteristica Especial</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody v-if="roles">
                    <tr v-for="rol in roles" v-if="rol.name">
                        <td>{{ rol.id }}</td>
                        <td>{{ rol.name }}</td>
                        <td>{{ rol.slug }}</td>
                        <td>{{ rol.special }}</td>
                        <td>
                            <a href="#"
                            class="btn btn-default btn-sm"
                            data-toggle="modal"
                            data-target="#ModalRol"
                            @click.prevent="openform('edit', rol)"
                            v-if="action('update')">Editar</a>
                        </td>
                        <td>
                            <a href="#"
                            class="btn btn-default btn-sm"
                            @click.prevent="destroy(rol)"
                            v-if="action('destroy')">Eliminar</a>
                        </td>
                    </tr>
                    <tr class="text-center" v-else>
                        <td colspan="7">
                            Rol Eliminado con exito. Desea deshacer el cambio?
                            <a href="#"
                            class="btn btn-default btn-sm"
                            @click.prevent="restore(rol)"
                            v-if="action('restore')">click aqui.</a>
                            <a href="#"
                            class="btn btn-default btn-sm"
                            @click.prevent="get">Continuar.</a>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td class="text-center" colspan="7">Cargando...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row justify-content-center">
            <pagination @changePage="get(arguments[0])" :data="pagination"></pagination>
        </div>
    </div>
</template>

<script>
import ModalForm from './forms/modal-form-rol.vue';
import Pagination from './partials/pagination.vue';

export default {
    components: {
        'modalFormComponent': ModalForm,
        'pagination': Pagination
    },
    data() {
        return {
            roles: false,
            permissions: [],
            formData: {
                ready: false,
                url: '',
                rol: {}
            },
            pagination: {},
            search: '',
            num: 10
        };
    },
    mounted() {
        this.get();
    },
    watch: {
        search: _.debounce(function () {this.get(); }, 500),
        num: function () {this.get(); }
    },
    methods: {
        action: function (accion) {
            return this.can(accion, this.permissions);
        },
        get: function (page = null) {
            let url =  '/roles?page=' + ((page) ? page : 1);
            if (this.search) {url += '&search=' + this.search;}
            if (this.num) {url += '&num=' + this.num;}
            axios.get(url)
            .then(response => {
                this.roles = response.data.roles;
                this.pagination = response.data.pagination;
                this.permissions = response.data.permissionsUser;
            });
        },
        openform: function (cond, rol = null) {
            this.formData.ready = false;
            if (cond == 'create') {
                this.formData.url = '/roles';
                this.formData.title = 'Registrar Rol.';
                this.formData.rol = {
                    name: '',
                    slug: '',
                    description: '',
                    from_at: '',
                    to_at: '',
                    special: '',
                    permissions: []
                };
                this.formData.ready = true;
            } else if (cond == 'edit') {
                this.formData.url = '/roles/' + rol.id;
                this.formData.title = 'Editar Rol ' + rol.name + '.';
                axios.get('/roles/' + rol.id)
                .then(response => {
                    this.formData.rol = response.data;
                    this.formData.ready = true;
                });
            }
            this.formData.cond = cond;
        },
        destroy: function (rol) {
            if (rol.id === 1) return;
            axios.delete('/roles/' + rol.id)
            .then(response => {
                console.log('Rol borrado de forma exitosa.');
                rol.name = false;
            });
        },
        restore: function (rol) {
            axios.post('/restore-rol/' + rol.id)
            .then(response => {
                console.log('Rol restaurado de forma exitosa.');
                rol.name = response.data;
            });
        }
    }
}
</script>
