<template>
    <div>
        <label :for="'img'+n">Imagen {{ n }}:</label>
        <div class="col div-img" :style="{'background-image': 'url('+image+')'}">
            <input type="file" :id="'img'+n" class="form-control" @change="getImage" accept="image/*">
        </div>
    </div>
</template>

<script>
    export default {
        name: 'input-form',
        props: ['n'],
        data() {
            return {
                image: location.origin + "/favicon.png"
            }
        },
        methods: {
            getImage(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;
                this.read(files[0]);
            },
            read: function (file) {
                let reader = new FileReader();
                reader.onload = e => this.image = e.target.result;
                reader.readAsDataURL(file);
                this.update({
                    num: this.n,
                    file: file
                });
            },
            update: function (value) {
                this.$emit('img', value);
            }
        }
    }
</script>

<style>
.div-img {
    border: 3px solid rgba(93,93,93,.5);
    border-radius: 10px;
    height: 250px;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: cover;
}
input[type='file'], input[type='file']:focus, input[type='file']:active {
    z-index: 999;
    opacity: 0;
    min-width: 100%;
    min-height: 100%;
    cursor: pointer;
}
</style>