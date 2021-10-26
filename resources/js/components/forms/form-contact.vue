<template>
  <form class="form-horizontal" method="post" @submit.prevent="save">
    <fieldset>
      <legend class="text-center header">Contáctenos</legend>

      <div class="form-group">
        <span class="col-md-1 col-md-offset-2 text-center">
          <i class="fa fa-user bigicon"></i>
        </span>
        <div class="col-md-8">
          <input
            id="name"
            type="text"
            v-model="data.name"
            class="form-control"
            placeholder="Nombres"
          />
          <small id="nameHelp" class="form-text text-muted"></small>
        </div>
      </div>
      <div class="form-group">
        <span class="col-md-1 col-md-offset-2 text-center">
          <i class="fa fa-user-o bigicon"></i>
        </span>
        <div class="col-md-8">
          <input
            type="text"
            id="last_name"
            class="form-control"
            placeholder="Apellidos"
            v-model="data.last_name"
          />
          <small id="last_nameHelp" class="form-text text-muted"></small>
        </div>
      </div>
      <div class="form-group">
        <span class="col-md-1 col-md-offset-2 text-center">
          <i class="fa fa-phone bigicon"></i>
        </span>
        <div class="col-md-8">
          <input
            id="phone"
            type="text"
            class="form-control"
            v-model="data.phone"
            placeholder="Teléfono"
          />
          <small id="phoneHelp" class="form-text text-muted"></small>
        </div>
      </div>
      <div class="form-group">
        <span class="col-md-1 col-md-offset-2 text-center">
          <i class="fa fa-envelope-o bigicon"></i>
        </span>
        <div class="col-md-8">
          <input
            id="email"
            type="text"
            class="form-control"
            v-model="data.email"
            placeholder="Correo Electronico"
          />
          <small id="emailHelp" class="form-text text-muted"></small>
        </div>
      </div>
      <div class="form-group">
        <span class="col-md-1 col-md-offset-2 text-center">
          <i class="fa fa-pencil-square-o bigicon"></i>
        </span>
        <div class="col-md-8">
          <textarea
            rows="7"
            id="message"
            class="form-control"
            v-model="data.message"
            placeholder="Ingrese su mensaje para nosotros aquí. Nos pondremos en contacto con usted."
          />
          <small id="messageHelp" class="form-text text-muted"></small>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-12 text-center">
          <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
        </div>
      </div>
    </fieldset>
    <h5 class="text-right">
      Télefono para Urgencias: <b class="text-danger">609712229</b>
    </h5>
  </form>
</template>

<script>
export default {
  name: "Contact",
  data: () => ({
    data: {},
  }),
  methods: {
    save() {
      $("small").text("");
      toastr.info("Espere un momento, Estamos procesando su mensaje.");
      axios.post("/contact-save", this.data).then((response) => {
        this.data = {};
        toastr.success("Su Correo ha sido enviado con exito.");
      });
    },
  },
};
</script>
