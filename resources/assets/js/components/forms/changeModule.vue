<template>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-for="module in module_current">
      {{ module }} <span class="caret" v-if="modules"></span>
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown" v-if="modules">
      <a v-for="(module, key) in modules"
        :href="'change-module-user/'+key"
        class="dropdown-item"
        @click.prevent="change(key)">{{ module }}</a>
    </div>
  </li>
</template>

<script>
  export default {
    name: 'dropdown-change-module',
    data () {
      return {
        module_current: '',
        modules: []
      };
    },
    mounted: function () {
      axios.get('change-module-user')
      .then(response => {
        this.module_current = response.data.module;
        this.modules = response.data.modules;
      });
    },
    methods: {
      change: function (key) {
        axios.post('change-module-user', {key})
        .then(response => {
          location.reload();
        });
      }
    }
  }
</script>