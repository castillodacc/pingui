<template>
  <div>
    <rs-modal id="inscription-form" w="lg">

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
                <div class="row">

                  <div class="col-md-8">
                    <div class="col-md-12" v-for="input in entries[0]">
                      <rs-input :name="input" required="true"
                      :readonly="input.readonly"
                      v-model="formData.data[input.id]"
                      :msg="msg[input.id]"
                      @input="formData.data[input.id] = arguments[0]"></rs-input>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="col-md-12" v-for="input in entries[1]">
                      <rs-input :name="input" required="true"
                      :readonly="input.readonly"
                      v-model="formData.data[input.id]"
                      :msg="msg[input.id]"
                      @input="formData.data[input.id] = arguments[0]"></rs-input>
                    </div>
                  </div>
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
                      <option :value="null">No Aprobado</option>
                    </select>
                    <small id="state_payHelp" class="form-text text-muted">
                      <span v-text="msg.state_pay"></span>
                    </small>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="state" class="control-label">
                      <span class="glyphicon glyphicon-inbox"></span> Aprobar Participación:
                    </label>
                    <select id="state" required="true" class="form-control" v-model="formData.data.state">
                      <option value="1">Aprobado</option>
                      <option :value="null">No Aprobado</option>
                    </select>
                    <small id="stateHelp" class="form-text text-muted">
                      <span v-text="msg.state"></span>
                    </small>
                  </div>
                </div>

                <div class="row">
                  <h4>Total a Pagar: <b>{{ total }} €</b> <small><a :href="'/perfil/3/' + formData.data.user_id" target="_black">Ver perfil</a></small></h4>
                  <div class="col-md-12">
                    <h4>Modalidades Inscritas:</h4>
                    <div class="col-md-4">
                      <p>Standard:</p>
                      <template v-if="formData.data.tipe_id == 1">
                        <div class="form-inline"
                        v-for="p in prices"
                        v-if="p.category_id == 3 && (formData.data.user.group_s == p.subcategory_id || formData.data.prices.indexOf(p.id) != -1)">
                          <label :for="p.id">
                            <input type="checkbox" :id="p.id" class="" :value="p.id" v-model="formData.data.prices">
                            {{ p.name }} - {{ p.price }} €
                          </label>
                        </div>
                      </template>
                      <template v-else>
                        <div class="form-inline"
                        v-for="p in prices"
                        v-if="p.category_id == 3 && formData.data.prices.indexOf(p.id) != -1">
                          <label :for="p.id">
                            <input type="checkbox" :id="p.id" class="" :value="p.id" v-model="formData.data.prices">
                            {{ p.name }} - {{ p.price }} €
                          </label>
                        </div>
                      </template>
                    </div>
                    <div class="col-md-4">
                      <p>Latino:</p>
                      <template v-if="formData.data.tipe_id == 1">
                        <div class="form-inline"
                        v-for="p in prices"
                        v-if="p.category_id == 2 && (formData.data.user.group_l == p.subcategory_id || formData.data.prices.indexOf(p.id) != -1)">
                          <label :for="p.id">
                            <input type="checkbox" :id="p.id" class="" :value="p.id" v-model="formData.data.prices">
                            {{ p.name }} - {{ p.price }} €
                          </label>
                        </div>
                      </template>
                      <template v-else>
                        <div class="form-inline"
                        v-for="p in prices"
                        v-if="p.category_id == 2 && formData.data.prices.indexOf(p.id) != -1">
                          <label :for="p.id">
                            <input type="checkbox" :id="p.id" class="" :value="p.id" v-model="formData.data.prices">
                            {{ p.name }} - {{ p.price }} €
                          </label>
                        </div>
                      </template>
                    </div>
                    <div class="col-md-4">
                      <p>Open:</p>
                      <div class="form-inline" v-for="p in prices" v-if="p.category_id == 1">
                        <label :for="p.id">
                          <input type="checkbox" :id="p.id" :value="p.id" v-model="formData.data.prices">
                          {{ p.name }} - {{ p.price }} €
                        </label>
                      </div>
                    </div>
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
    name: 'modal-form-inscription',
    components: {
      'rs-modal': Modal,
      'rs-input': Input
    },
    props: ['formData'],
    data () {
      return {
        price: [],
        msg: {
          name: 'Nombre del Permiso.',
          description: 'Descripción a realizar.',
          deleted_at: 'Activar o Inactivar permiso.'
        },
        entries: [
        [
        {label: 'Bailarín', id: 'usuario', icon: 'fa fa-user', readonly: true},
        {label: 'Bailarina', id: 'pareja', icon: 'fa fa-user-o', readonly: true},
        ],
        [
        {label: 'FEBD', id: 'febd_num_1', icon: 'glyphicon glyphicon-globe', readonly: true},
        {label: 'FEBD', id: 'febd_num_2', icon: 'glyphicon glyphicon-globe', readonly: true},
        ]
        ]
      };
    },
    computed: {
      total: function () {
        let price = 0, test = 0;
        for(let i in this.formData.data.prices) {
          for(let o in this.prices) {
            if (this.prices[o].id == this.formData.data.prices[i]) {
              if (this.prices[o].category_id == 1) {
                price += Number(this.prices[o].price);
              }
              if ((this.prices[o].category_id == 2 || this.prices[o].category_id == 3) && test == 0) {
                price += Number(this.prices[o].price);
                test++;
              }
              continue;
            }
          }
        }
        return this.formData.data.pay = Number(price);
      }
    },
    mounted() {
      axios.post('/get-data-inscription', { id: this.$route.params.id })
      .then(response => {
        this.prices = response.data.price;
      });
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
