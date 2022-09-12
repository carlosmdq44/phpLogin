@extends('layouts.app-master')
@section('content')

<h1 class="container">Home</h1>

@auth
    <p class="mt-5 d-flex justify-content-center">Bienvenido {{auth()->user()->name ?? auth()->user()->username }}, estas autenticado a la pagina</p>
@endauth
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
  
   
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

</head>
<body>
  <div id="app"> 
    <v-app>
      <v-main>   
       <!--<h2 class="text-center">CRUD usando APIREST con Node JS</h2>-->
       <!-- Botón CREAR -->  
       <v-flex class="text-center align-center">
       <v-btn class="mx-2 mt-4"  fab dark color="#00B0FF" @click="formNuevo()"><v-icon dark>mdi-plus</v-icon></v-btn>           
       </v-flex>              
         
        <v-card class="mx-auto mt-5" color="transparent" max-width="1280" elevation="8">                    
      
        <!-- Tabla y formulario -->
        <v-simple-table class="mt-5">
            <template v-slot:default>
                <thead>
                    <tr class="indigo darken-4">
                        <th class="white--text">ID</th>
                        <th class="white--text">DESCRIPCIÓN</th>
                        <th class="white--text">PRECIO</th>
                        <th class="white--text">STOCK</th>
                        <th class="white--text text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($articulos as $articulo)
                    <tr>
                    <td class="justify-content-center">{{ $articulo ['id'] }}</td>
                    <td class="justify-content-center">{{ $articulo ['descripcion'] }}</td>
                    <td class="justify-content-center">{{ $articulo ['precio'] }}</td>
                    <td class="justify-content-center">{{ $articulo ['stock'] }}</td> 
                    <td>
                    <div class="form-group row justify-content-center">
                        <v-btn fab dark color="#00BCD4" small @click="formEditar(articulo.id, articulo.descripcion, articulo.precio, articulo.stock)"><v-icon>mdi-pencil</v-icon></v-btn>
                        <v-btn fab dark color="#E53935" small @click="borrar(articulo.id)"><v-icon>mdi-delete</v-icon></v-btn>
                    </td>
                    </tr>
                     @endforeach 
                </tbody>
            </template>
        </v-simple-table>
        </v-card> 
        @auth
            <v-btn class="mt-4 btn btn-primary position-absolute end-0">
            <a href="/logout">Logout</a>
            </v-btn>
        @endauth       
      <!-- Componente de Diálogo para CREAR y EDITAR -->
      <v-dialog v-model="dialog" max-width="500">        
        <v-card>
          <v-card-title class="blue darken-2 white--text">Artículo</v-card-title>    
          <v-card-text>            
            <v-form>             
              <v-container>
                <v-row>
                  <input v-model="articulo.id" hidden></input>
                  <v-col cols="12" md="4">
                    <v-text-field v-model="articulo.descripcion" label="Descripción" solo required></v-text-field>
                  </v-col>
                  <v-col cols="12" md="4">
                    <v-text-field v-model="articulo.precio" label="Precio" type="number" prefix="$" solo required></v-text-field>
                  </v-col>
                  <v-col cols="12" md="4">
                    <v-text-field v-model="articulo.stock" label="Stock" type="number" solo required></v-text-field>
                  </v-col>
                </v-row>
              </v-container>            
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click="dialog=false" color="blue-grey" dark>Cancelar</v-btn>
            <v-btn @click="guardar()" type="submit" color="blue darken-2" dark>Guardar</v-btn>
          </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>
      </v-main>
    </v-app>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vuetify/2.5.7/vuetify.min.js" integrity="sha512-BPXn+V2iK/Zu6fOm3WiAdC1pv9uneSxCCFsJHg8Cs3PEq6BGRpWgXL+EkVylCnl8FpJNNNqvY+yTMQRi4JIfZA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>

    let url = 'http://localhost:8000/api/articulos/';

    new Vue({
      el: '#app',
      vuetify: new Vuetify(),
       data() {
        return {            
            articulos: [],
            dialog: false,
            operacion: '',            
            articulo:{
                id: null,
                descripcion:'',
                precio:'',
                stock:''
            }          
        }
       },
       created(){               
            this.mostrar()
       },  
       methods:{          
            //MÉTODOS PARA EL CRUD
            mostrar:function(){
              axios.get(url)
              .then(response =>{
                this.articulos = response.data;                   
              })
            },
            crear:function(){
                let parametros = {descripcion:this.articulo.descripcion, precio:this.articulo.precio,stock:this.articulo.stock };                
                axios.post(url, parametros)
                .then(response =>{
                  this.mostrar();
                });     
                this.articulo.descripcion="";
                this.articulo.precio="";
                this.articulo.stock="";
            },                        
            editar: function(){
            let parametros = {descripcion:this.articulo.descripcion, precio:this.articulo.precio, stock:this.articulo.stock, id:this.articulo.id};                            
            //console.log(parametros);                   
                 axios.put(url+this.articulo.id, parametros)                            
                  .then(response => {                                
                     this.mostrar();
                  })                
                  .catch(error => {
                      console.log(error);            
                  });
            },
            borrar:function(id){
             Swal.fire({
                title: '¿Confirma eliminar el registro?',   
                confirmButtonText: `Confirmar`,                  
                showCancelButton: true,                          
              }).then((result) => {                
                if (result.isConfirmed) {      
                      //procedimiento borrar
                      axios.delete(url+id)
                      .then(response =>{           
                          this.mostrar();
                       });      
                      Swal.fire('¡Eliminado!', '', 'success')
                } else if (result.isDenied) {                  
                }
              });              
            },

            //Botones y formularios
            guardar:function(){
              if(this.operacion=='crear'){
                this.crear();                
              }
              if(this.operacion=='editar'){ 
                this.editar();                           
              }
              this.dialog=false;                        
            }, 
            formNuevo:function () {
              this.dialog=true;
              this.operacion='crear';
              this.articulo.descripcion='';                           
              this.articulo.precio='';
              this.articulo.stock='';
            },
            formEditar:function(id, descripcion, precio, stock){
              //capturamos los datos del registro seleccionado y los mostramos en el formulario
              this.articulo.id = id;
              this.articulo.descripcion = descripcion;                            
              this.articulo.precio = precio;
              this.articulo.stock = stock;                      
              this.dialog=true;                            
              this.operacion='editar';
            }
       }      
    });
  </script>
</body>
@guest
    <p>Para ver el contenido <a href="/login">Inicia sesion</a></p>
@endguest

@endsection