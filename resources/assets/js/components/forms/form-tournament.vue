<template>
  <div class="box">
    <div class="box-header">
      <h3 class="box-title"><span :class="'glyphicon glyphicon-'+ico"></span> {{ title }}</h3>
    </div>
    <div class="box-body">
      <div class="row">
        <form id="tournament" enctype="multipart/form-data" @submit.prevent="registrar">
          <div class="col-md-10 col-md-offset-1">

            <div class="col-md-6" v-for="input in entries[0]">
              <rs-input :name="input"
              :readonly="input.readonly"
              :type="input.type"
              v-model="data[input.id]"
              :msg="msg[input.id]"
              @input="data[input.id] = arguments[0]"></rs-input>
            </div>


            <div class="col-md-6">
              <div class="form-group">
                <label for="organizer_id" class="control-label">
                  <span class="edit"></span> Organizador:
                </label>
                <select id="organizer_id" class="form-control" v-model="data.organizer_id">
                  <option value="">Seleccione un organizador</option>
                  <option :value="o.id" v-for="o in organizers" v-text="o.name"></option>
                </select>
                <small id="organizer_idHelp" class="form-text text-muted" v-text="msg.organizer_id"></small>
              </div>
            </div>

            <div class="col-md-6" style="height: 100px;">
              <div class="checkbox" style="padding-top: 25px;">
                <label for="inscription" class="control-label" style="font-weight: 600;">
                  <input id="inscription" type="checkbox" class="checkbox" v-model="data.inscription">
                  <span class="edit"></span> Inscripción: <b>{{ (data.inscription) ? 'Abierta' : 'Cerrada' }}</b>
                </label><br>
                <small id="inscriptionHelp" class="form-text text-muted" v-text="msg.inscription"></small>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="start" class="control-label">
                  <span class="edit"></span> Fecha de inicio de competición:
                </label>
                <date-picker id="start" v-model="data.start" :config="{format: 'DD/MM/YYYY', useCurrent: true, showClear: true, showClose: true}"></date-picker>
                <small id="startHelp" class="form-text text-muted" v-text="msg.start"></small>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="end" class="control-label">
                  <span class="edit"></span> Fecha final de competición:
                </label>
                <date-picker id="end" v-model="data.end" :config="{format: 'DD/MM/YYYY', useCurrent: true, showClear: true, showClose: true}"></date-picker>
                <small id="endHelp" class="form-text text-muted" v-text="msg.end"></small>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="image" class="control-label">
                  <span class="edit"></span> Imagen:
                </label>
                <input id="image" type="file" @change="getImage" accept="image/*">
                <small id="imageHelp" class="form-text text-muted" v-html="msg.image"></small>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="hours" class="control-label">
                  <span class="edit"></span> Horario del evento:
                </label>
                <div class="input-group">
                  <input id="hours" type="file" class="form-control" accept="application/pdf" @change="onSelected">
                  <div class="input-group-addon">
                    <input type="checkbox" id="show_hour" v-model="data.show_hour">
                    <label for="show_hour" v-if="data.show_hour">Visible</label>
                    <label for="show_hour" v-else>Oculto</label>
                  </div>
                </div>
                <small id="hoursHelp" class="form-text text-muted" v-html="msg.hours"></small>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="info" class="control-label">
                  <span class="edit"></span> Información del evento:
                </label>
                <input id="info" type="file" accept="application/pdf" @change="onSelected">
                <small id="infoHelp" class="form-text text-muted" v-html="msg.info"></small>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="referee" class="control-label">
                  <span class="edit"></span> Referees del evento:
                </label>
                <rs-multiselect v-model="data.referee_tournament" :options="referees_options" :multiple="true" :hide-selected="true" :close-on-select="false"></rs-multiselect>
                <small id="refereeHelp" class="form-text text-muted" v-text="msg.referee"></small>
              </div>
            </div>

            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="hotel" class="control-label">
                      <span class="edit"></span> Nombre del hotel:
                    </label>
                    <input type="text" class="form-control" v-model="hotel">
                    <small id="hotelHelp" class="form-text text-muted" v-text="msg.hotel"></small>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="link" class="control-label">
                      <span class="edit"></span> Link de la pagina del hotel:
                    </label>
                    <input type="text" class="form-control" v-model="link">
                    <small id="linkHelp" class="form-text text-muted" v-text="msg.link"></small>
                  </div>
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-primary" style="margin-top: 27px;" @click="add"><span class="fa fa-plus"></span></button>
                </div>
                <div class="col-md-12">
                  <ul>
                    <li v-for="(h, i) in hoteles">
                      <span>
                        <a :href="h.link" v-text="h.hotel" target="_blank"></a> 
                        <button type="button" class="btn btn-danger btn-xs" @click="remove(i, 'hoteles')"><span class="fa fa-remove"></span></button>
                      </span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="type_id" class="control-label">
                      <span class="edit"></span> Tipo:
                    </label>
                    <select id="type_id" class="form-control" v-model="more_info_.type_id">
                      <option value="">Seleccione</option>
                      <option value="1">Link</option>
                      <option value="2">CSV</option>
                      <option value="3">PDF</option>
                    </select>
                    <small id="type_idHelp" class="form-text text-muted" v-text="msg.type_id"></small>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="name" class="control-label">
                      <span class="edit"></span> Nombre del Hipervinculo:
                    </label>
                    <input type="text" id="name" class="form-control" v-model="more_info_.name">
                    <small id="nameHelp" class="form-text text-muted" v-text="msg.name_"></small>
                  </div>
                </div>
                <div class="col-md-4" v-if="more_info_.type_id == 1">
                  <div class="form-group">
                    <label for="link" class="control-label">
                      <span class="edit"></span> Hipervinculo:
                    </label>
                    <input type="text" id="link" class="form-control" v-model="more_info_.link">
                    <small id="linkHelp" class="form-text text-muted" v-text="msg.link_"></small>
                  </div>
                </div>
                <div class="col-md-4" v-if="more_info_.type_id > 1">
                  <div class="form-group">
                    <label for="file" class="control-label">
                      <span class="edit"></span> Seleccione el archivo a Guardar:
                    </label>
                    <input id="file" class="form-control" type="file" @change="getFile" :accept="(more_info_.type_id == 3) ? 'application/pdf' : '.csv'">
                    <small id="fileHelp" class="form-text text-muted" v-text="msg.file"></small>
                  </div>
                </div>
                <div class="col-md-2" style="padding-top: 30px;">
                  <button type="button" class="btn btn-primary btn-xs" title="Agregar" data-tooltip="tooltip" @click="addmore_info">
                    <i class="fa fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-danger btn-xs" title="Refrescar" data-tooltip="tooltip" @click="resetmore_info">
                    <i class="fa fa-refresh"></i>
                  </button>
                </div>
                <div class="col-md-12">
                  <ul>
                    <li v-for="(m, i) in more_info">
                      <a :href="m.link" v-text="m.name" target="_blank"></a> - 
                      <span v-if="m.type_id == 1">LINK</span>
                      <span v-else-if="m.type_id == 2">CSV</span>
                      <span v-else>PDF</span>
                      <button type="button" class="btn btn-success btn-xs" @click="m.active = 0" v-if="m.active != null && m.active == 1"><i class="fa fa-check"></i></button>
                      <button type="button" class="btn btn-danger btn-xs" @click="m.active = 1" v-else-if="m.active != null && m.active == 0"><i class="fa fa-close"></i></button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="p_category" class="control-label">
                      <span class="edit"></span> Categoría:
                    </label>
                    <select id="p_category" class="form-control" v-model="p_category">
                      <option value="">Seleccione</option>
                      <option :value="1">Open</option>
                      <option :value="2">Latino</option>
                      <option :value="3">Standard</option>
                    </select>
                    <small id="p_categoryHelp" class="form-text text-muted" v-text="msg.p_category"></small>
                  </div>
                </div>
                <div class="col-md-6" v-if="p_category == 2">
                  <div class="form-group">
                    <label for="subcategory_latino" class="control-label">
                      <span class="edit"></span> Categorias Latino:
                    </label>
                    <rs-multiselect v-model="hijos" :options="category_latinos_options" :multiple="true" :hide-selected="true" :close-on-select="false"></rs-multiselect>
                    <small id="subcategory_latinoHelp" class="form-text text-muted" v-text="msg.subcategory_latino"></small>
                  </div>
                </div>
                <div class="col-md-6" v-if="p_category == 3">
                  <div class="form-group">
                    <label for="subcategory_standar" class="control-label">
                      <span class="edit"></span> Categorias Standards:
                    </label>
                    <rs-multiselect v-model="hijos" :options="category_standars_options" :multiple="true" :hide-selected="true" :close-on-select="false"></rs-multiselect>
                    <small id="subcategory_standarHelp" class="form-text text-muted" v-text="msg.subcategory_standar"></small>
                  </div>
                </div>
                <div class="col-md-6" v-if="p_category == 1">
                  <div class="form-group">
                    <label for="category_open" class="control-label">
                      <span class="edit"></span> Categorias Open:
                    </label>
                    <rs-multiselect v-model="hijos" :options="category_opens_options" :multiple="true" :hide-selected="true" :close-on-select="false"></rs-multiselect>
                    <small id="category_openHelp" class="form-text text-muted" v-text="msg.category_open"></small>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="price" class="control-label">
                      <span class="edit"></span> Precio:
                    </label>
                    <input type="text" class="form-control" v-model="price">
                    <small id="priceHelp" class="form-text text-muted" v-text="msg.price"></small>
                  </div>
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-primary" style="margin-top: 27px;" @click="addP"><span class="fa fa-plus"></span></button>
                </div>
                <div class="col-md-12 text-right">
                  <button type="submit" class="btn btn-primary btn-lg"><span class="fa fa-ok"></span> Guardar</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12" v-if="prices.length">
            <div class="row">
              <div class="col-md-4" style="max-height: 400px; min-height: 400px; overflow: scroll;">
                <h4>Precios de Categoría Open</h4>
                <table class="table table-condensed table-hover">
                  <thead>
                    <tr>
                      <th>Nivel</th>
                      <th>Precio</th>
                      <th>Borrar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(p, i) in prices" v-if="p.category_id == 1" style="font-size: 12px;">
                      <td>{{ p.level_text }}</td>
                      <td>{{ p.price }} <b>€</b></td>
                      <td>
                        <button type="button" class="btn btn-danger btn-xs" @click="remove(i, 'prices')"><span class="fa fa-remove"></span></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-4" style="max-height: 400px; min-height: 400px; overflow: scroll;">
                <h4>Precios de Categoría Latino</h4>
                <table class="table table-condensed table-hover">
                  <thead>
                    <tr>
                      <th>Nivel</th>
                      <th>SubCategoría</th>
                      <th>Precio</th>
                      <th>Borrar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(p, i) in prices" v-if="p.category_id == 2" style="font-size: 12px;">
                      <td>{{ p.level_text }}</td>
                      <td>{{ p.subcategory_text }}</td>
                      <td>{{ p.price }} <b>€</b></td>
                      <td>
                        <button type="button" class="btn btn-danger btn-xs" @click="remove(i, 'prices')"><span class="fa fa-remove"></span></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-4" style="max-height: 400px; min-height: 400px; overflow: scroll;">
                <h4>Precios de Categoría Standard</h4>
                <table class="table table-condensed table-hover">
                  <thead>
                    <tr>
                      <th>Nivel</th>
                      <th>SubCategoría</th>
                      <th>Precio</th>
                      <th>Borrar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(p, i) in prices" v-if="p.category_id == 3" style="font-size: 12px;">
                      <td>{{ p.level_text }}</td>
                      <td>{{ p.subcategory_text }}</td>
                      <td>{{ p.price }} <b>€</b></td>
                      <td>
                        <button type="button" class="btn btn-danger btn-xs" @click="remove(i, 'prices')"><span class="fa fa-remove"></span></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>

<script>
  import Input from './../partials/input.vue';
  import Multiselect from 'vue-multiselect';
  import DatePicker from 'vue-bootstrap-datetimepicker';
  import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';

  export default {
    name: 'form-tournament',
    components: {
      'rs-input': Input,
      'rs-multiselect': Multiselect,
      DatePicker
    },
    props: ['formData'],
    data () {
      return {
        hijos: [],
        p_category: '',
        price: '',
        prices: [],
        more_info_: {
          type_id: ''
        },
        more_info: [],
        organizers: [],
        link: '',
        hotel: '',
        hoteles: [],
        referees: [],
        file: null,
        referees_options: [],
        category_opens: [],
        category_latinos: [],
        category_standars: [],
        title: '',
        ico: '',
        data: {
          inscription: false,
          organizer_id: ''
        },
        entries: {
          0: [
          {label: 'Titulo', id: 'name', icon: 'edit'},
          {label: 'Detalles', id: 'description', icon: 'edit'},
          {label: 'Resultados', id: 'results', icon: 'edit'},
          {label: 'Ruta al Mapa', id: 'maps', icon: 'edit'},
          ]
        },
        msg: {
          name: 'Nombre de la competición.',
          description: 'Detalles generales.',
          start: 'Fecha a comenzar el evento.',
          end: 'Fecha a terminar el evento.',
          organizador: 'Organizador de la competición.',
          price: 'precio para bailarines.',
          p_category: 'Categorias de baile.',
          entrance_price: 'precios de entradas.',
          results: 'Resultados finales de la competición.',
          maps: 'Enlace a google maps de la competición.',
          link_: 'Link de acceso.',
          inscription: 'Inscripción Abierta o Cerrada.',
          file: 'Seleccione el archivo según el tipo.',
          image: 'Imagen Destacada',
          hours: 'Horario de la competencia',
          info: 'Hoja informativa',
          referee: 'Referees de la competencia',
          type_id: 'Tipo de archivo.',
          name_: 'Nombre para el Hipervinculo.',
          category_open: 'Seleccione las categorias open que participan.',
          subcategory_latino: 'Seleccione las categorias latinos que participan.',
          subcategory_standar: 'Seleccione las categorias standard  que participan.',
          hotel: 'Ingrese el nombre del hotel',
          link: 'Ingrese el link del hotel',
        },
      };
    },
    watch: {
      p_category: function (val) {
        this.hijos = [];
      },
    },
    mounted() {
      this.get();
      if (this.$route.params.id) {
        axios.get('/tournament/' + this.$route.params.id)
        .then(response => {
          this.title = 'Editar Competencia:';
          this.ico = 'edit';
          this.data = response.data;
          let h = response.data.hotels;
          for(let i in h) {
            this.hoteles.push({
              link: h[i].link,
              hotel: h[i].name,
              id: h[i].id,
            });
          }

          this.more_info = response.data.more_info;

          let p = response.data.prices;
          for(let i in p) {
            this.prices.push({
              id: p[i].id,
              price: p[i].price,
              category_id: p[i].category_id,
              level_id: p[i].level_id,
              subcategory_id: p[i].subcategory_id,
              category_text: this.cate(p[i].category_id),
              level_text: p[i].level_text,
              subcategory_text: p[i].subcategory_text,
            });
          }

          if (response.data.image) {this.msg.image = '<a href="/storage/' + response.data.image + '" target="_blank">' + response.data.image + '<a>';}
          if (response.data.hours) {this.msg.hours = '<a href="/storage/hours/' + response.data.hours + '" target="_blank">' + response.data.hours + '<a>';}
          if (response.data.info) {this.msg.info = '<a href="/storage/info/' + response.data.info + '" target="_blank">' + response.data.info + '<a>';}
        })
        .catch(error => {
          this.$router.push({ name: 'tournament.index' });
        });
      } else {
        this.title = 'Registrar Competencia:';
        this.ico = 'plus';
      }
    },
    computed: {
      category_opens_options: function () {
        let options = [];
        for(let i in this.category_opens) {
          options.push(this.category_opens[i].name);
        }
        return options;
      },
      category_latinos_options: function () {
        let options = [];
        for(let i in this.category_latinos) {
          options.push(this.category_latinos[i].name);
        }
        return options;
      },
      category_standars_options: function () {
        let options = [];
        for(let i in this.category_standars) {
          options.push(this.category_standars[i].name);
        }
        return options;
      },
    },
    methods: {
      get: function () {
        axios.post('/get-tournament')
        .then(response => {
          this.organizers = response.data.organizers;
          this.referees = response.data.referees;
          this.referees_options = [];
          for(let i in this.referees) {
            this.referees_options.push(this.referees[i].name);
          }
          this.category_opens = response.data.category_opens;
          this.category_latinos = response.data.category_latinos;
          this.category_standars = response.data.category_standars;
        });
      },
      onSelected(e){
        let files = e.target.files || e.dataTransfer.files;
        let data = new FormData();
        data.append(e.target.id, files[0]);
        axios.post('/upload/' + e.target.id, data)
        .then(response => {
          this.data[e.target.id] = response.data;
          this.msg[e.target.id] = '<a href="/storage/hours/' + response.data + '" target="_blank">' + response.data + '<a>';
        });
      },
      getImage(e) {
        let files = e.target.files || e.dataTransfer.files;
        if (!files.length) return;
        let reader = new FileReader();
        reader.onload = (e) => {
          this.data.image = e.target.result;
        };
        reader.readAsDataURL(files[0]);
      },
      getFile(e) {
        let files = e.target.files || e.dataTransfer.files;
        let data = new FormData();
        data.append(e.target.id, files[0]);
        axios.post('/upload-file/' + this.more_info_.type_id, data)
        .then(response => {
          this.more_info_.link = response.data;
        });
      },
      addmore_info() {
        if (this.more_info_.type_id != '' && this.more_info_.name != '' && this.more_info_.link != '') {
          if (isNaN(this.more_info_.type_id)) {
            return toastr.error('El campo tipo solo admite valore numéricos.');
          }
          if (this.more_info_.type_id == 1 && this.more_info_.link.indexOf('http')) {
            return toastr.error('El link debe ser la direccion completa http://www.dominio.com');
          }
          this.more_info.push({
            name: this.more_info_.name,
            type_id: this.more_info_.type_id,
            link: this.more_info_.link
          });
          this.resetmore_info();
        } else {
          toastr.error('Debe rellenar todos los campos.');
        }
      },
      resetmore_info() {
        this.more_info_.name = '';
        this.more_info_.type_id = '';
        this.more_info_.link = '';
      },
      cate: function (n) {
        if (n === 1) {
          return 'Open';
        } else if (n === 2) {
          return 'Latino';
        } else if (n === 3) {
          return 'Standard';
        }
      },
      searchCat: function (category, subcategory) {
        if (category == 1) {
          for(let i in this.category_opens) {
            if (this.category_opens[i].name == subcategory) {
              return this.category_opens[i];
            }
          }
        } else if (category == 2) {
          for(let i in this.category_latinos) {
            if (this.category_latinos[i].name == subcategory) {
              return this.category_latinos[i];
            }
          }
        } else if (category == 3) {
          for(let i in this.category_standars) {
            if (this.category_standars[i].name == subcategory) {
              return this.category_standars[i];
            }
          }
        }
      },
      addP: function () {
        if (this.price && this.p_category) {
          if (isNaN(this.price)) {
            return toastr.error('El campo precio solo admite valore numéricos.');
          }
          if (this.price > 200) {
            return toastr.error('El campo precio no puede ser tan algo.');
          }
          if (this.p_category == 1 && this.hijos.length == 0) {
            return toastr.error('Debe agregar un valor el campo.');
          }
          let price = [], category;
          for(let i in this.hijos) {
            category = this.searchCat(this.p_category, this.hijos[i]);

            let data = {
              price: this.price,
              category_id: this.p_category,
              level_id: category.category_id,
              subcategory_id: category.id,
              category_text: this.cate(this.p_category),
              level_text: this.hijos[i].split(' - ')[0],
              subcategory_text: this.hijos[i].split(' - ')[1],
            };

            let test = 1;
            for(let o in this.prices) {
              if (data['category_id'] == this.prices[o]['category_id'] &&
                data['subcategory_id'] == this.prices[o]['subcategory_id']) {
                this.prices[o].price = data['price'];
                test = 0;
              }
            }
            if (test) {
              this.prices.push(data);
            }
          }
          this.price = '';
          this.p_category = '';
          this.hijos = [];
        } else {
          return toastr.error('Debe llenar todos los campos.');
        }
      },
      add: function () {
        if (this.link && this.hotel) {
          if (this.link.indexOf('http')) {
            return toastr.error('El link debe ser la direccion completa http://www.dominio.com');
          }
          this.hoteles.push({
            link: this.link,
            hotel: this.hotel,
          });
          this.link = '';
          this.hotel = '';
        }
      },
      remove: function (i, array) {
        this[array].splice(i, 1);
      },
      registrar: function () {
        this.restoreMsg(this.msg);
        let referees = [];
        for(let i in this.referees) {
          for(let r in this.data.referee_tournament) {
            if (this.referees[i].name == this.data.referee_tournament[r]) {
              referees.push(this.referees[i].id);
            }
          }
        }
        this.data.referee = referees;

        this.data.hoteles = this.hoteles;
        this.data.prices = this.prices;
        this.data.more_info = this.more_info;

        if (this.$route.params.id) {
          axios.put('/tournament/' + this.data.id, this.data)
          .then(response => {
            toastr.success('Competencia Actualizada');
            this.$router.push({name: 'tournament.index'});
          });
        } else {
          axios.post('/tournament', this.data)
          .then(response => {
            toastr.success('Competencia Registrada');
            this.$router.push({name: 'tournament.index'});
          });
        }
      }
    }
  }
</script>