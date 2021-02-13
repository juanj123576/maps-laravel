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
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form User</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form @submit.prevent="agregar_firestore()">

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control" name="name" required="required" placeholder="Enter Name" v-model="usuario.nombre">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" name="email" required="required" placeholder="Enter email" v-model="usuario.email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" name="password" required="required" placeholder="Password" v-model="usuario.password">
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
    </div>
    <!-- /.row -->








    </div>





@endsection





@section('Scripts')

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDKkdaJhiH3lDKHK24-vnTzeG1smZUtlyc"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('js/usuario.js') }}"    ></script>
    <script src="{{ asset('js/finca.js') }}"     ></script>



@endsection
