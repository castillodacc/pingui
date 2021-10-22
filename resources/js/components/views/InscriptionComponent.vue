<template>
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Tabla de Inscritos:</h3>
      <button
        @click="generate"
        data-tooltip="tooltip"
        title="Generar Dorsales"
        class="btn btn-primary btn-xs"
        v-if="can('inscription.generate')"
      >
        <i class="fa fa-refresh"></i>
      </button>
      <a
        data-tooltip="tooltip"
        class="btn btn-warning btn-xs"
        title="Generar CSV de Bailarines"
        v-if="can('inscription.generatecsv')"
        :href="'/csv-competition/' + $route.params.id"
      >
        <i class="glyphicon glyphicon-save"></i>
      </a>
      <a
        data-tooltip="tooltip"
        class="btn btn-info btn-xs"
        title="Generar PDF de Bailarines"
        v-if="can('inscription.generatepdf')"
        :href="'/pdf-lista/' + $route.params.id"
      >
        <i class="glyphicon glyphicon-circle-arrow-down"></i>
      </a>
    </div>
    <div class="box-body">
      <rs-table
        :tabla="tabla"
        id="inscription"
        uri="/inscription"
        :d="$route.params.id"
      />
    </div>
    <rs-modal-form
      :formData="form"
      @input="$children[0].get('this')"
      v-if="can(['inscription.store', 'inscription.update'])"
    />
  </div>
</template>

<script>
import rsTable from "./../partials/table.vue";
import rsModalForm from "./../forms/modal-form-inscription.vue";

export default {
  name: "Inscription",
  components: { rsTable, rsModalForm },
  data() {
    return {
      form: {
        cond: "",
        ready: "",
        url: "",
        data: {},
      },
      tabla: {
        columns: [
          { title: "Dorsales", field: "dorsal", sort: "id", sortable: true },
          { title: "Bailarín", field: "user", sort: "name_1", sortable: true },
          {
            title: "Bailarina",
            field: "pareja",
            sort: "name_2",
            sortable: true,
          },
          {
            title: "Tipo de pago",
            field: "type_pay",
            sort: "method_pay",
            sortable: true,
          },
          {
            title: "Estado del pago",
            field: "state_pay",
            sortable: true,
            class: "text-center",
          },
          {
            title: "Estado de Participación",
            field: "state",
            sortable: true,
            class: "text-center",
          },
        ],
        options: [
          {
            ico: "fa fa-edit",
            class: "btn-info",
            title: "Editar",
            func: (id) => {
              this.openForm("edit", id);
            },
            action: "tournament.update",
          },
          {
            ico: "fa fa-close",
            class: "btn-danger",
            title: "Eliminar",
            func: (id) => {
              this.deleted(
                "/inscription/" + id,
                this.$children[0].get,
                "pareja"
              );
            },
            action: "inscription.destroy",
          },
        ],
      },
    };
  },
  methods: {
    openForm: function (cond, id = null) {
      this.form.cond = cond;
      this.form.ready = false;
      this.form.url = "/inscription/" + id;
      axios.get(this.form.url).then((response) => {
        this.form.title = "Editar Participación de Pareja";
        this.form.data = response.data;
        this.form.ready = true;
        $("#inscription-form").modal("show");
      });
    },
    generate: function () {
      axios.post("/generate/" + this.$route.params.id).then((response) => {
        this.$children[0].get();
      });
    },
  },
};
</script>
