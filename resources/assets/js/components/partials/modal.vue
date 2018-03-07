<template>
  <div class="modal fade" :id="id" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <slot name="modal-title">
            <h5 class="modal-title">Modal title</h5>
          </slot>
          <button type="button" class="close" aria-label="Close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <slot name="modal-body">
            ...
          </slot>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <slot name="modal-btn">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'modal',
  props: ['id']
}
</script>
