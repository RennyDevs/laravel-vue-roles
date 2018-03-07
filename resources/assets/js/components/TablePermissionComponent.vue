<template>
    <div v-if="action('index')">
        <modalFormComponent @update="get(pagination.current_page)" :formData="formData" v-if="action('update')"></modalFormComponent>
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
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody v-if="permisos">
                <tr v-for="permission in permisos">
                    <td>{{ permission.id }}</td>
                    <td>{{ permission.name }}</td>
                    <td>{{ permission.description }}</td>
                    <td class="text-center" v-if="action('desActived')">
                        <a href="#" class="btn btn-default btn-sm" @click.prevent="restore(permission)"
                        v-if="permission.deleted_at">Desactivado</a>
                        <a href="#" class="btn btn-default btn-sm" @click.prevent="destroy(permission)" v-else>Activo</a>
                    </td>
                    <td v-else>
                        <span v-if="permission.deleted_at">Desactivado</span>
                        <span v-else>Activo</span>
                    </td>
                    <td>
                        <a href="#"
                        class="btn btn-default btn-sm"
                        data-toggle="modal"
                        data-target="#ModalPermission"
                        @click.prevent="openform('edit', permission)"
                        v-if="action('update')">Editar</a>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td class="text-center" colspan="5">Cargando...</td>
                </tr>
            </tbody>
        </table>
        <div class="row justify-content-center">
            <pagination @changePage="get(arguments[0])" :data="pagination"></pagination>
        </div>
    </div>
</template>

<script>
import ModalForm from './forms/modal-form-permission.vue';
import Pagination from './partials/pagination.vue';

export default {
    components: {
        'modalFormComponent': ModalForm,
        'pagination': Pagination
    },
    data() {
        return {
            permisos: false,
            permissions: [],
            formData: {
                ready: false,
                cond: '',
                url: '',
                permission: {},
                permissions: []
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
            let url =  '/permisos?page=' + ((page) ? page : 1);
            if (this.search) {url += '&search=' + this.search; }
            if (this.num) {url += '&num=' + this.num; }
            axios.get(url)
            .then(response => {
                this.permisos = response.data.permissions;
                this.permissions = response.data.permissionsUser;
                this.formData.permissions = response.data.permissionsUser;
                this.pagination = response.data.pagination;
            });
        },
        openform: function (cond, permission = null) {
            this.formData.ready = false;
            if (cond == 'edit') {
                this.formData.url = '/permisos/' + permission.id;
                axios.get(this.formData.url)
                .then(response => {
                    this.formData.permission = response.data;
                    this.formData.title = 'Editar Permiso: ' + response.data.name + '.';
                    this.formData.ready = true;
                });
            }
            this.formData.cond = cond;
        },
        destroy: function (permission) {
            axios.delete('/permisos/' + permission.id)
            .then(response => {
                console.log('Permiso borrado de forma exitosa');
                permission.deleted_at = true;
            });
        },
        restore: function (permission) {
            axios.post('/restore-permission/' + permission.id)
            .then(response => {
                console.log('Permiso restaurado de forma exitosa');
                permission.deleted_at = false;
            });
        }
    }
}
</script>
