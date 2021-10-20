<template>
  <div>
    <rs-modal id="permission-form">

      <h4 class="card-title" slot="modal-title">
        <span class="glyphicon glyphicon-edit"></span>
        {{ formData.title }}
      </h4>

      <template slot="modal-body">
        <div class="row justify-content-center">
          <div class="col-md-10 col-md-offset-1">
            <form id="PermissionsForm" @keyup.enter="registrar">

              <spinner v-if="!formData.ready"></spinner>
              <div v-else>
                <template v-for="input in entries">
                  <rs-input :name="input" required="true"
                          :readonly="input.readonly"
                          v-model="formData.permission[input.id]"
                          :msg="msg[input.id]"
                          @input="formData.permission[input.id] = arguments[0]">
                  </rs-input>
                </template>

                <div class="form-group">
                  <label for="state" class="control-label">
                    <span class="glyphicon glyphicon-inbox"></span> Activo:
                  </label>
                  <select id="state" required="true" class="form-control" v-model="formData.permission.state">
                    <option :value="true">Activo</option>
                    <option :value="false">Inactivo</option>
                  </select>
                  <small id="stateHelp" class="form-text text-muted">
                    <span v-text="msg.state"></span>
                  </small>
                </div>
              </div>

            </form>
          </div>
        </div>
      </template>

      <template slot="modal-btn">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
        <button type="button" class="btn btn-primary" @click="registrar"><span class="glyphicon glyphicon-saved"></span> Guardar</button>
      </template>

    </rs-modal>
  </div>
</template>

<script>
  import Modal from './../partials/modal.vue';
  import Input from './../partials/input.vue';

  export default {
    name: 'modal-form-permission',
    components: {
      'rs-modal': Modal,
      'rs-input': Input
    },
    props: ['formData'],
    data () {
      return {
        msg: {
          name: 'Nombre del Permiso.',
          description: 'Descripción a realizar.',
          deleted_at: 'Activar o Inactivar permiso.'
        },
        entries: [
          {label: 'Nombre', id: 'name', icon: 'edit'},
          {label: 'Descripción', id: 'description', icon: 'edit'},
        ]
      };
    },
    methods: {
      registrar: function () {
        this.restoreMsg(this.msg);
        if (this.formData.cond === 'edit') {
          axios.put(this.formData.url, this.formData.permission)
          .then(response => {
            toastr.success('Permiso Editado');
            $('#permission-form').modal('hide');
            this.$emit('input');
          });
        }
      }
    }
  }
</script>
