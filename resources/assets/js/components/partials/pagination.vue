<template>
    <ul class="pagination">
        <!-- <li v-if="data.current_page > 1" class="page-item"> -->
        <li class="page-item">
            <a href="#" class="page-link"
            @click.prevent="updateValue(data.current_page - 1)">
                <span>Atras</span>
            </a>
        </li>
        <li v-if="data.current_page > 3" class="page-item">
            <a href="#" class="page-link" @click.prevent="updateValue(1)">
                <span>1</span>
            </a>
        </li>
        <li v-if="data.current_page > 4" class="page-item">
            <a href="#" class="page-link" @click.prevent="">
                <span>...</span>
            </a>
        </li>
        <li v-for="page in pagesNumber" :class="isActive(page)" class="page-item">
            <a href="#" class="page-link" @click.prevent="updateValue(page)">
                <span>{{ page }}</span>
            </a>
        </li>
        <li v-if="data.current_page < data.last_page -3" class="page-item">
            <a href="#" class="page-link" @click.prevent="">
                <span>...</span>
            </a>
        </li>
        <li v-if="data.current_page < data.last_page-2" class="page-item">
            <a href="#" class="page-link" @click.prevent="updateValue(data.last_page)">
                <span>{{ data.last_page }}</span>
            </a>
        </li>
        <!-- <li v-if="data.current_page < data.last_page" class="page-item"> -->
        <li class="page-item">
            <a href="#" class="page-link" 
            @click.prevent="updateValue(data.current_page + 1)">
                <span>Siguiente</span>
            </a>
        </li>
    </ul>
</template>

<script>
export default {
    name: 'pagination',
    props: ['data'],
    computed: {
        pagesNumber: function () {
            let offset = 2;
            if (!this.data.to) {return [];}

            var from = this.data.current_page - offset;
            if (from < 1) {from = 1; }

            var to = from + (offset * 2);
            if (to >= this.data.last_page) {to = this.data.last_page; }

            var pagesArray = [];
            while(from <= to) {
                pagesArray.push(from);
                from++;
            }

            return pagesArray;
        },
        isVacio: function () {
            if (search ==='') {
                this.getTarea();
            }
        }
    },
    methods: {
        updateValue: function (value) {
            if(value == this.data.current_page) return;
            if (value < 1) return;
            if (value > this.data.last_page) return;
            this.$emit('changePage', value);
        },
        isActive: function (page) {
            return page == this.data.current_page ? 'active' : '';
        },
        change: function (argument) {
            console.log(argument)
        }
    }
}
</script>
