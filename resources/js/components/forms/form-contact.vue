<template>
  <form class="form-horizontal" method="post" @submit.prevent="save">
    <fieldset>
      <legend class="text-center header">Contáctenos</legend>

      <div class="form-group">
        <span class="col-md-1 col-md-offset-2 text-center"
          ><i class="fa fa-user bigicon"></i
        ></span>
        <div class="col-md-8">
          <input
            id="name"
            type="text"
            placeholder="Nombres"
            class="form-control"
            v-model="data.name"
          />
          <small id="nameHelp" class="form-text text-muted"></small>
        </div>
      </div>
      <div class="form-group">
        <span class="col-md-1 col-md-offset-2 text-center"
          ><i class="fa fa-user-o bigicon"></i
        ></span>
        <div class="col-md-8">
          <input
            id="last_name"
            type="text"
            placeholder="Apellidos"
            class="form-control"
            v-model="data.last_name"
          />
          <small id="last_nameHelp" class="form-text text-muted"></small>
        </div>
      </div>
      <div class="form-group">
        <span class="col-md-1 col-md-offset-2 text-center"
          ><i class="fa fa-phone bigicon"></i
        ></span>
        <div class="col-md-8">
          <input
            id="phone"
            type="text"
            placeholder="Teléfono"
            class="form-control"
            v-model="data.phone"
          />
          <small id="phoneHelp" class="form-text text-muted"></small>
        </div>
      </div>
      <div class="form-group">
        <span class="col-md-1 col-md-offset-2 text-center"
          ><i class="fa fa-envelope-o bigicon"></i
        ></span>
        <div class="col-md-8">
          <input
            id="email"
            type="text"
            placeholder="Correo Electronico"
            class="form-control"
            v-model="data.email"
          />
          <small id="emailHelp" class="form-text text-muted"></small>
        </div>
      </div>
      <div class="form-group">
        <span class="col-md-1 col-md-offset-2 text-center"
          ><i class="fa fa-pencil-square-o bigicon"></i
        ></span>
        <div class="col-md-8">
          <textarea
            class="form-control"
            id="message"
            placeholder="Ingrese su mensaje para nosotros aquí. Nos pondremos en contacto con usted."
            rows="7"
            v-model="data.message"
          ></textarea>
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
  data() {
    return {
      data: {},
    };
  },
  methods: {
    save() {
      $("small").text("");
      toastr.info("Espere un momento, Estamos procesando su mensaje.");
      axios.post("/contact-save", this.data).then((response) => {
        toastr.success("Su Correo ha sido enviado con exito.");
      });
    },
  },
};
</script>
