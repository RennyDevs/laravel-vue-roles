<template>
    <div v-if="action('index')">
        <div class="row">
            <div class="col-sm-4" v-if="action('create')">
                <button type="button"
                class="btn btn-default btn-xs"
                data-toggle="modal"
                data-target="#ModalUser"
                @click="openform('create')">Crear</button>
            </div>
            <modalFormComponent @updateUsers="get(pagination.current_page)" :formData="formData" v-if="action('create') || action('update')"></modalFormComponent>
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
                        <th>Email</th>
                        <th>Modulo</th>
                        <th>Rol</th>
                        <th colspan="3" class="text-center">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody v-if="users">
                    <tr v-for="user in users" v-if="user.name">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name+' '+user.last_name | capitalize }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.module.module }}</td>
                        <td>
                            <span class="badge badge-pill badge-primary" v-for="rol in user.roles">
                                {{ rol.name }}
                            </span>
                        </td>
                        <td>
                            <a href="#"
                            class="btn btn-default btn-sm"
                            data-toggle="modal"
                            data-target="#ModalUser"
                            @click.prevent="openform('edit', user)"
                            v-if="action('update')">Editar</a>
                        </td>
                        <td>
                            <a :href="'/perfil/'+user.id"
                            class="btn btn-default btn-sm"
                            v-if="action('show')">Perfil</a>
                        </td>
                        <td>
                            <a href="#"
                            class="btn btn-default btn-sm"
                            @click.prevent="destroy(user)"
                            v-if="action('destroy')">Eliminar</a>
                        </td>
                        <td>
                            <a :href="'/init-session-user/' + user.id" class="btn btn-default btn-sm" v-if="action('initWithOneUser')">iniciar</a>
                        </td>
                    </tr>
                    <tr class="text-center" v-else>
                        <td colspan="8">
                            Usuario Eliminado con éxito. Desea deshacer el cambio?
                            <a href="#"
                            class="btn btn-default btn-sm"
                            @click.prevent="restore(user)"
                            v-if="action('restore')">click aqui.</a>
                            <a href="#"
                            class="btn btn-default btn-sm"
                            @click.prevent="get">Continuar.</a>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td class="text-center" colspan="8">Cargando...</td>
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
import ModalForm from './forms/modal-form-user.vue';
import Pagination from './partials/pagination.vue';

export default {
    components: {
        'modalFormComponent': ModalForm,
        'pagination': Pagination
    },
    data() {
        return {
            users: false,
            permissions: [],
            formData: {
                ready: false,
                cond: '',
                url: '',
                user: {}
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
        search: _.debounce(function (newsearch, oldsearch) {
            this.get();
        }, 500),
        num: function () {
            this.get();
        }
    },
    methods: {
        action: function (accion) {
            return this.can(accion, this.permissions);
        },
        get: function (page = null) {
            let url =  '/usuarios?page=' + ((page) ? page : 1);
            if (this.search) {url += '&search=' + this.search; }
            if (this.num) {url += '&num=' + this.num; }
            axios.get(url)
            .then(response => {
                this.users = response.data.users;
                this.pagination = response.data.pagination;
                this.permissions = response.data.permissionsUser;
            }).catch(errors => { this.errorsManager(errors.response); });
        },
        openform: function (cond, user = null) {
            this.formData.ready = false;
            if (cond == 'create') {
                this.formData.url = '/usuarios';
                this.formData.title = 'Registrar Usuario.';
                this.formData.user = {
                    title: '',
                    name: '',
                    last_name: '',
                    num_id: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    roles: [],
                    module_id: ''
                };
                this.formData.ready = true;
            } else if (cond == 'edit') {
                this.formData.url = '/usuarios/' + user.id;
                axios.get('/usuarios/' + user.id)
                .then(response => {
                    this.formData.user = response.data;

                    let roles = response.data.roles;
                    let arreglo = [];
                    for (let rol in roles){arreglo.push(roles[rol].id);}
                        this.formData.user.roles = arreglo;

                    this.formData.title = 'Editar Usuario ' + response.data.name + '.';
                    this.formData.ready = true;
                });
            }
            this.formData.cond = cond;
        },
        destroy: function (user) {
            if (user.id === 1) return;
            axios.delete('/usuarios/' + user.id)
            .then(response => {
                console.log('usuario borrado de forma exitosa');
                user.name = false;
            });
        },
        restore: function (user) {
            axios.post('/restore-user/' + user.id)
            .then(response => {
                console.log('usuario restaurado de forma exitosa');
                user.name = response.data;
            });
        }
    }
}
</script>
