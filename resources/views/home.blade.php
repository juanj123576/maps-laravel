@extends('layouts.app')
@section('styles')
    <style>


        #exampleModal{
            width: 1200px;
        }
        #exampleModal2{
            width: 1200px;
        }
        #exampleModal3{
            width: 1200px;
        }




    </style>
@endsection

@section('content')

   <div id="finca">
       <table class="table table-hover table-striped">
			<thead>
				<tr>

					<th>nombre</th>
					<th colspan="2">
						&nbsp;
					</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="finca in fincas2">

				<td id="nombre" v-text="finca.nombre" ></td>

					<td width="10px">
                        @if(Auth::check())

                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModal2"
                                @click="colocarfinca(finca)" >ver distancia</button>
                        @else
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModal2"
                                    @click="colocarfinca2(finca)" >ver distancia</button>
                        @endif

					</td>

				</tr>
			</tbody>
		</table>
       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" @click="cambiarAgregar()">
           Agregar finca
       </button>



       <!-- Modal -->
       <div class="modal fade "  id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>

                   <div class="row">
                       <div class="modal-body">

                           <div class="col-sm-6">
                               <template v-if="modoEditar===true">
                                   <form @submit.prevent="editarFinca(finca)">
                                       <h3>Editar Finca</h3>
                                       <div class="mb-3">
                                           <label for="" class="form-label">nombre</label>
                                           <input  type="text" class="form-control" tabindex="1" v-text="finca.nombre" v-model="finca.nombre">
                                       </div>
                                       <div class="mb-3">
                                           <label for="" class="form-label">Municipio</label>
                                           <input type="text" class="form-control" tabindex="2" v-model="finca.municipio">
                                       </div>
                                       <div class="mb-3">
                                           <label for="" class="form-label">Departamento</label>

                                           <input type="text" class="form-control" tabindex="3" v-model="finca.departamento">
                                       </div>
                                       <div class="mb-3">
                                           <label>Por favor, ingrese la dirección del corregimiento
                                               o municipio más cercano a su finca, para el transporte de mercancia
                                           </label>
                                           <input placeholder="Search for a Place or an Address." type="text" name="search" id="search" value="Berlin, Germany" autocomplete="off" onkeyup="autosuggest(this)" v-model="finca.direccion" autofocus/>

                                           <i class="fa fa-search fa-search-custom" aria-hidden="true"></i>
                                           <div class="dropdown">
                                               <ul id="list"></ul>
                                           </div>

                                       </div>
                                       <button type="submit" class="btn btn-primary" tabindex="4">Editar</button>

                                   </form>
                               </template>
                               <template v-else >
                                   <form  @submit.prevent="agregarFinca()" >
                                       <h3>Agregar Finca</h3>
                                       <div class="mb-3">
                                           <label for="" class="form-label">nombre</label>
                                           <input  type="text" class="form-control" tabindex="1" v-model="finca.nombre">
                                       </div>
                                       <div class="mb-3">
                                           <label for="" class="form-label">Municipio</label>
                                           <input type="text" class="form-control" tabindex="2" v-model="finca.municipio">
                                       </div>
                                       <div class="mb-3">
                                           <label for="" class="form-label">Departamento</label>

                                           <input type="text" class="form-control" tabindex="3" v-model="finca.departamento">


                                       </div>
                                       <div class="mb-3">
                                           <label>Por favor, ingrese la dirección del corregimiento
                                               o municipio más cercano a su finca, para el transporte de mercancia
                                           </label>
                                           <input placeholder="Search for a Place or an Address." type="text" name="search" id="search" value="Berlin, Germany" autocomplete="off" onkeyup="autosuggest(this)" v-model="finca.direccion" autofocus/>

                                           <i class="fa fa-search fa-search-custom" aria-hidden="true"></i>
                                           <div class="dropdown">
                                               <ul id="list"></ul>
                                           </div>

                                       </div>




                                       <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>

                                   </form>
                               </template>


                           </div>

<mapa2></mapa2>


                           </div>


                       </div>

                   </div>
               </div>
           </div>







   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">
      Ver ofertas
   </button>

   <!-- Modal -->
   <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="row">
               <div class="modal-body">
                   <div class="col-sm-6">
            @if(Auth::check())
                            <mapa :hols="finca.direccion" ref="mapa"></mapa>
                       @else
                           <mapa :hols="finca.direccion" ref="mapa" ></mapa>
                       @endif

                   </div>
s

                 </div>
               </div>




           </div>
       </div>
   </div>

   </div>





@endsection





@section('Scripts')

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKkdaJhiH3lDKHK24-vnTzeG1smZUtlyc&libraries=&v=weekly"

    ></script>

<script src="{{ asset('js/usuario.js') }}"    ></script>
<script src="{{ asset('js/finca.js') }}"     ></script>



@endsection
