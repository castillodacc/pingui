<template>
  <div class="box">
    <div class="box-header">
      <h3 class="box-title"><span :class="'glyphicon glyphicon-'+ico"></span> {{ title }}</h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <form id="tournament" enctype="multipart/form-data" @submit.prevent="registrar">
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
                <div class="col-md-3" v-if="p_category">
                  <div class="form-group">
                    <label for="p_category1" class="control-label">
                      <span class="edit"></span> Categoría 2:
                    </label>
                    <select id="p_category1" class="form-control" v-model="p_category1">
                      <option value="">Seleccione</option>
                      <option v-for="c in categories" :value="c.id">{{ c.name }}</option>
                    </select>
                    <small id="p_category1Help" class="form-text text-muted" v-text="msg.p_category1"></small>
                  </div>
                </div>
                <div class="col-md-3" v-if="p_category1 && p_category != 1">
                  <div class="form-group">
                    <label for="p_subcategory" class="control-label">
                      <span class="edit"></span> Subcategoría:
                    </label>
                    <select id="p_subcategory" class="form-control" v-model="p_subcategory">
                      <option value="">Seleccione</option>
                      <option v-for="c in subcategories" :value="c.id">{{ c.name }}</option>
                    </select>
                    <small id="p_subcategoryHelp" class="form-text text-muted" v-text="msg.p_subcategory"></small>
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
                <div class="col-md-12">
                  <ul>
                    <li v-for="(p, i) in prices">
                      <span><b>{{ cate(p.category_id) }}</b> {{ p.p_category1_text }} <span v-if="p.p_subcategory_text">({{ p.p_subcategory_text }})</span> - {{ p.name }} <small><b>{{ p.price }} €</b></small></span>
                      <button type="button" class="btn btn-danger btn-xs" @click="remove(i, 'prices')"><span class="fa fa-remove"></span></button>
                    </li>
                  </ul>
                </div>
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
                <input id="hours" type="file" accept="application/pdf" @change="onSelected">
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

            <div class="col-md-6">
              <div class="form-group">
                <label for="category_open" class="control-label">
                  <span class="edit"></span> Categorias Open:
                </label>
                <rs-multiselect v-model="data.category_open_tournament" :options="category_opens_options" :multiple="true" :hide-selected="true" :close-on-select="false"></rs-multiselect>
                <small id="category_openHelp" class="form-text text-muted" v-text="msg.category_open"></small>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="subcategory_latino" class="control-label">
                  <span class="edit"></span> Categorias Latino:
                </label>
                <rs-multiselect v-model="data.subcategory_latino_tournament" :options="category_latinos_options" :multiple="true" :hide-selected="true" :close-on-select="false"></rs-multiselect>
                <small id="subcategory_latinoHelp" class="form-text text-muted" v-text="msg.subcategory_latino"></small>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="subcategory_standar" class="control-label">
                  <span class="edit"></span> Categorias Standards:
                </label>
                <rs-multiselect v-model="data.subcategory_standar_tournament" :options="category_standars_options" :multiple="true" :hide-selected="true" :close-on-select="false"></rs-multiselect>
                <small id="subcategory_standarHelp" class="form-text text-muted" v-text="msg.subcategory_standar"></small>
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
                      <a :href="h.link" v-text="h.hotel" target="_blank"></a> 
                      <button type="button" class="btn btn-danger btn-xs" @click="remove(i, 'hoteles')"><span class="fa fa-remove"></span></button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-md-12 text-right">
              <button type="submit" class="btn btn-primary btn-lg"><span class="fa fa-ok"></span> Guardar</button>
            </div>

          </form>
        </div>
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
        organizers: [],
        p_name: '',
        p_category: '',
        p_subcategory: '',
        p_category1: '',
        price: '',
        categories: [],
        subcategories: [],
        prices: [],
        link: '',
        hotel: '',
        hoteles: [],
        referees: [],
        file: null,
        referees_options: [],
        category_opens: [],
        category_opens_options: [],
        category_latinos: [],
        category_latinos_options: [],
        category_standars: [],
        category_standars_options: [],
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
          inscription: 'Inscripción Abierta o Cerrada.',
          image: 'Imagen Destacada',
          p_name: 'Motivo del cobro.',
          hours: 'Horario de la competencia',
          info: 'Hoja informativa',
          referee: 'Referees de la competencia',
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
        axios.post('/get-categories', { id: val })
        .then(response => {
          this.p_category1 = '';
          this.p_subcategory = '';
          this.categories = response.data.categories;
        });
      },
      p_category1: function (val) {
        if (val == 1) return;
        axios.post('/get-subcategories', { id: this.p_category, cat: val })
        .then(response => {
          this.p_subcategory = '';
          this.subcategories = response.data.subcategories;
        });
      }
    },
    mounted() {
      this.get();
      if (this.$route.params.id) {
        axios.get('/tournament/' + this.$route.params.id)
        .then(response => {
          this.title = 'Editar Competencia:';
          this.ico = 'edit';
          let sub_standar = response.data.subcategory_standar_tournament;
          let sub_latino = response.data.subcategory_latino_tournament;
          this.data = response.data;
          let h = response.data.hotels;
          for(let i in h) {
            this.hoteles.push({
              link: h[i].link,
              hotel: h[i].name,
              id: h[i].id,
            });
          }

          let p = response.data.prices;
          for(let i in p) {
            this.prices.push({
              category_id: p[i].category_id,
              price: p[i].price,
              category1_id: p[i].category1_id,
              subcategory_id: p[i].subcategory_id,
              p_category1_text: p[i].category1_text,
              p_subcategory_text: p[i].subcategory_text,
              p_category_text: p[i].category_text,
              name: p[i].name,
              id: p[i].id,
            });
          }

          this.data.subcategory_latino_tournament = [];
          for(let i in sub_latino) {
            this.data.subcategory_latino_tournament.push(sub_latino[i].name);
          }
          this.data.subcategory_standar_tournament = [];
          for(let i in sub_standar) {
            this.data.subcategory_standar_tournament.push(sub_standar[i].name);
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
    methods: {
      cate: function (n) {
        if (n === 1) {
          return 'Open';
        } else if (n === 2) {
          return 'Latino';
        } else if (n === 3) {
          return 'Standard';
        }
      },
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
          this.category_opens_options = [];
          for(let i in this.category_opens) {
            this.category_opens_options.push(this.category_opens[i].name);
          }
          this.category_latinos = response.data.category_latinos;
          this.category_latinos_options = [];
          for(let i in this.category_latinos) {
            this.category_latinos_options.push(this.category_latinos[i].name);
          }
          this.category_standars = response.data.category_standars;
          this.category_standars_options = [];
          for(let i in this.category_standars) {
            this.category_standars_options.push(this.category_standars[i].name);
          }
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
      addP: function () {
        if (this.price && this.p_category && this.p_category1) {
          if (isNaN(this.price)) {
            return toastr.info('El campo precio solo admite valore numéricos.');
          }
          if (this.price > 200) {
            return toastr.info('El campo precio no puede ser tan algo.');
          }
          if (this.p_subcategory == '' && this.p_category != 1) {
            return toastr.info('El campo subcategoría es requerido.');
          }
          let price = {
            price: this.price,
            category_id: this.p_category,
            category1_id: this.p_category1,
            subcategory_id: this.p_subcategory,
          };
          for(let i in this.categories) {
            if (this.categories[i].id == this.p_category1) {
              price.p_category1_text = this.categories[i].name;
              continue;
            }
          }
          for(let s in this.subcategories) {
            if (this.subcategories[s].id == this.p_subcategory) {
              price.p_subcategory_text = this.subcategories[s].name;
              continue;
            }
          }
          price.p_category_text = this.cate(this.p_category);
          this.prices.push(price);
          this.p_subcategory = '';
          this.price = '';
          this.p_category = '';
          this.p_category1 = '';
        } else {
          return toastr.info('Debe llenar todos los campos.');
        }
      },
      add: function () {
        if (this.link && this.hotel) {
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

        let category_opens = [];
        for(let i in this.category_opens) {
          for(let r in this.data.category_open_tournament) {
            if (this.category_opens[i].name == this.data.category_open_tournament[r]) {
              category_opens.push(this.category_opens[i].id);
            }
          }
        }
        this.data.category_open = category_opens;

        let category_latinos = [];
        for(let i in this.category_latinos) {
          for(let r in this.data.subcategory_latino_tournament) {
            if (this.category_latinos[i].name == this.data.subcategory_latino_tournament[r]) {
              category_latinos.push(this.category_latinos[i].id);
            }
          }
        }
        this.data.subcategory_latino = category_latinos;

        let category_standars = [];
        for(let r in this.data.subcategory_standar_tournament) {
          for(let i in this.category_standars) {
            if (this.category_standars[i].name == this.data.subcategory_standar_tournament[r]) {
              category_standars.push(this.category_standars[i].id);
            }
          }
        }
        this.data.subcategory_standar = category_standars;

        this.data.hoteles = this.hoteles;
        this.data.prices = this.prices;

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