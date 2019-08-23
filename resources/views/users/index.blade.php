@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/lib/datatable/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="addUser" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" placeholder="Carnet de identidad" class="form-control" v-model="user.ci" required>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Nombre Completo" class="form-control" v-model="user.name" required>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Nombre de usuario" class="form-control" v-model="user.username" required>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Contraseña" class="form-control" v-model="user.password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar ventana</button>
                <button type="submit" class="btn btn-success">Enviar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="updateUser(user.id)" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" placeholder="Carnet de identidad" class="form-control" v-model="user.ci" required>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Nombre Completo" class="form-control" v-model="user.name" required>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Nombre de usuario" class="form-control" v-model="user.username" required>
                </div>
                <div class="alert alert-warning" role="alert">
                    Sí deja este campo vacío se mantendrá la contraseña anterior
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Contraseña" class="form-control" v-model="user.password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Enviar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Usuarios con acceso al sistema </strong>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUser" @click.prevent="resetUser"><i class="fa fa-plus"></i></button>
            </div>
            <div class="card-body text-left">
                <table id="bootstrap-data-table-export" class="table table-striped table-bordered dt-responsive small">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th class="text-white bg-dark">Carnet de identidad</th>
                            <th class="text-white bg-dark">Nombre Completo</th>
                            <th class="text-white bg-dark">Nombre de usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in users">
                            <td class="text-center">
                                <a href="#" class="btn-sm btn-primary" data-toggle="modal" data-target="#editUser" @click.prevent="getUser(user.id)"><i class="fa fa-pencil fa-lg"></i></a>
                                <a href="#" class="btn-sm btn-danger" data-toggle="modal" data-target="#" @click.prevent="deleteUser(user.id)"><i class="fa fa-trash-o fa-lg"></i></a>
                            </td>
                            <td>@{{ user.ci }}</td>
                            <td>@{{ user.name }}</td>
                            <td>@{{ user.username }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/lib/data-table/datatables.min.js') }}"></script>
<script src="{{ asset('js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/lib/data-table/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/lib/data-table/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/lib/data-table/jszip.min.js') }}"></script>
<script src="{{ asset('js/lib/data-table/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/lib/data-table/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/lib/data-table/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/lib/data-table/buttons.colVis.min.js') }}"></script>
<script>
    const app = new Vue({
        el: '#app',
        data(){
            return{
                users: [],
                user: {}
            }
        },
        mounted() {
            this.getUsers()
            setTimeout(function(){$('#bootstrap-data-table-export').DataTable(
                    {
                        //searching: false,
                        //paging: false,
                        language: {
                            "decimal": "",
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Entradas",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "Sin resultados encontrados",
                            "paginate": {
                                "first": "Primero",
                                "last": "Ultimo",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            }
                        },
                    }
                );}, 400);
        },
        methods:{
            async resetDataTable(){
                setTimeout(function(){
                    $('#bootstrap-data-table-export').DataTable().destroy();
                }, 200);
                setTimeout(function(){
                    $('#bootstrap-data-table-export').DataTable().draw();
                }, 400);
            },
            async drawDataTable(){
                setTimeout(function(){
                    $('#bootstrap-data-table-export').DataTable().draw();
                }, 200);
            },
            async getUsers(){
                let res = await axios.get("{{ route('user.index') }}")
                this.users = res.data
            },
            async addUser(){
                try{
                    let res = await axios.post("{{ url('api/user') }}", this.user)
                    this.user = {}
                    this.getUsers()
                    location.reload()
                    toastr.success('Operacion exitosa', 'Registrado correctamente')
                }
                catch{
                    toastr.error('¡Error!', 'Ocurrió un problema')
                }
            },
            async getUser(id){
                let res = await axios.get("{{ url('api/user') }}/"+id)
                this.user = res.data
            },
            async resetUser(){
                this.user = {}
            },
            async updateUser(id){
                try{
                    let res = await axios.put("{{ url('api/user') }}/"+id, this.user)
                    this.user = res.data
                    this.getUsers()
                    toastr.success('Operación exitosa', 'Registro actualizado')
                }
                catch(e){
                    toastr.error(e)
                }
            },
            async deleteUser(id){
                try{
                    let res = await axios.delete("{{ url('api/user') }}/"+id)
                    this.getUsers()
                    toastr.success('Operación exitosa', 'Registro eliminado')
                }
                catch{
                    toastr.error('Ocurrio un error', 'Vuelva a intentarlo')
                }
            }
        }
    });
</script>
@endsection