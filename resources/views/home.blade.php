@extends('layouts.app')
@section('styles')
    <style>



        #exampleModal2{
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
						&nbsp;</th>
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
       @if(Auth::check())
       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" @click="verPerfil()">
       Perfil
       </button>
       @endif


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
                           <mapa :hols="finca.direccion" ref="mapa" :estado="true" ></mapa>
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


    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDKkdaJhiH3lDKHK24-vnTzeG1smZUtlyc"></script>
<script src="{{ asset('js/usuario.js') }}"    ></script>
<script src="{{ asset('js/finca.js') }}"     ></script>



@endsection
