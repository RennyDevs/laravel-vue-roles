

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Formulario de Registro</div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent="upload">

                            <a href="#" @click.prevent="numImg++" class="btn btn btn-primary btn-sm">+</a>
                            <div class="row justify-content-around">
                                <div class="col-md-5" v-for="n in numImg">
                                    <input-img :n="n" @img="changeImg(arguments[0])"></input-img>
                                </div>
                            </div>

                            <a href="#" @click.prevent="upload" class="btn btn btn-primary btn-sm">Enviar</a>
                            <div class="col-md-12">
                                <pre>{{$data || json}}</pre>
                            </div>

<!--                                 <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="user">Banco:</label>
                                        <input id="user" type="user" class="form-control" name="user">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="user">Fecha:</label>
                                        <input id="user" type="user" class="form-control" name="user">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="user">Beneficiario:</label>
                                        <input id="user" type="user" class="form-control" name="user">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="user">Monto:</label>
                                        <input id="user" type="user" class="form-control" name="user">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="user">N° de cheque:</label>
                                        <input id="user" type="user" class="form-control" name="user">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="user">N° de carpeta:</label>
                                        <input id="user" type="user" class="form-control" name="user">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="user">N° de estante:</label>
                                        <input id="user" type="user" class="form-control" name="user">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="user">N° de caja:</label>
                                        <input id="user" type="user" class="form-control" name="user">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="user">Estado del documento:</label>
                                        <input id="user" type="user" class="form-control" name="user">
                                    </div>
                                </div> -->

                                <!-- </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import imageComponent from './imageComponent.vue';

    export default {
        components: {
            'input-img': imageComponent
        },
        data() {
            return {
                numImg: 1,
                files: []
            }
        },
        methods: {
            changeImg: function (data) {
                for (var i = 0; i < this.files.length; i++) {
                    if (this.files[i].num == data.num) {
                        this.files[i].file = data.file;
                        return;
                    };
                }
                this.files.push(data);
            },
            upload() {
                let form = new FormData();
                let img = [];
                for (var i = 0; i < this.files.length; i++) {
                    form.append('image[]', this.files[i].file);
                }
                axios.post('/test', form);
            }
        }
    }
</script>
