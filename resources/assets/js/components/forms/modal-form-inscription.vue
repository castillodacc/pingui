<template>
  <div>
    <rs-modal id="inscription-form">

      <h4 class="card-title" slot="modal-title">
        <span class="glyphicon glyphicon-edit"></span>
        {{ formData.title }}
      </h4>

      <template slot="modal-body">
        <div class="row justify-content-center">
          <div class="col-md-10 col-md-offset-1">
            <form @keyup.enter="registrar">

              <spinner v-if="!formData.ready"></spinner>
              <div v-else>
                <div class="col-md-12" v-for="input in entries[0]">
                  <rs-input :name="input" required="true"
                  :readonly="input.readonly"
                  v-model="formData.data[input.id]"
                  :msg="msg[input.id]"
                  @input="formData.data[input.id] = arguments[0]"></rs-input>
                </div>

                <div class="col-md-6" v-for="input in entries[1]">
                  <rs-input :name="input" required="true"
                  :readonly="input.readonly"
                  v-model="formData.data[input.id]"
                  :msg="msg[input.id]"
                  @input="formData.data[input.id] = arguments[0]"></rs-input>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="method_pay" class="control-label">
                      <span class="glyphicon glyphicon-inbox"></span> Tipo de pago:
                    </label>
                    <select id="method_pay" required="true" class="form-control" v-model="formData.data.method_pay" disabled="">
                      <option value="1">Transferencia</option>
                      <option value="2">Paypal</option>
                    </select>
                    <small id="method_payHelp" class="form-text text-muted">
                      <span v-text="msg.method_pay"></span>
                    </small>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="state_pay" class="control-label">
                      <span class="glyphicon glyphicon-inbox"></span> Estado del pago:
                    </label>
                    <select id="state_pay" required="true" class="form-control" v-model="formData.data.state_pay">
                      <option value="1">Pagado</option>
                      <option :value="null">No Aprovado</option>
                    </select>
                    <small id="state_payHelp" class="form-text text-muted">
                      <span v-text="msg.state_pay"></span>
                    </small>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="state" class="control-label">
                      <span class="glyphicon glyphicon-inbox"></span> Aprovar Participación:
                    </label>
                    <select id="state" required="true" class="form-control" v-model="formData.data.state">
                      <option value="1">Aprovado</option>
                      <option :value="null">No Aprovado</option>
                    </select>
                    <small id="stateHelp" class="form-text text-muted">
                      <span v-text="msg.state"></span>
                    </small>
                  </div>
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
        [
        {label: 'Nombre Usuario', id: 'usuario', icon: 'user', readonly: true},
        {label: 'Nombre pareja', id: 'pareja', icon: 'user', readonly: true},
        ],
        [
        {label: 'FEBD usuario', id: 'febd_num_1', icon: 'user', readonly: true},
        {label: 'FEBD pareja', id: 'febd_num_2', icon: 'user', readonly: true},
        ]
        ]
      };
    },
    methods: {
      registrar: function () {
        this.restoreMsg(this.msg);
        if (this.formData.cond === 'edit') {
          axios.put(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Registro Editado');
            $('#inscription-form').modal('hide');
            this.$emit('input');
          });
        }
      }
    }
  }
</script>
