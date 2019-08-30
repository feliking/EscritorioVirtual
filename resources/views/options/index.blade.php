@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/lib/datatable/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
<div class="modal fade" id="addOption" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Nueva Opción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="addOption" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" placeholder="Nombre de la opción" class="form-control" v-model="option.name" required>
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

<div class="modal fade" id="editOption" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Editar Opción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="updateOption(option.id)" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" placeholder="Título" class="form-control" v-model="option.name" required>
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
                <strong class="card-title">Opciones </strong>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addOption" @click.prevent="resetOption"><i class="fa fa-plus"></i></button>
            </div>
            <div class="card-body text-left">
                <table id="bootstrap-data-table-export" class="table table-striped table-bordered dt-responsive small">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th class="text-white bg-dark">Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(option, index) in options">
                            <td class="text-center">
                                <a href="#" class="btn-sm btn-primary" data-toggle="modal" data-target="#editOption" @click.prevent="getOption(option.id)"><i class="fa fa-pencil fa-lg"></i></a>
                                <a href="#" class="btn-sm btn-danger" data-toggle="modal" data-target="#" @click.prevent="deleteOption(option.id)"><i class="fa fa-trash-o fa-lg"></i></a>
                            </td>
                            <td>@{{ option.name }}</td>
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
                options: [],
                option: {}
            }
        },
        mounted() {
            this.getOptions()
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
            async getOptions(){
                let res = await axios.get("{{ route('option.index') }}")
                this.options = res.data
            },
            async addOption(){
                try{
                    this.option.user_id = {{ Auth::user()->id }}
                    let res = await axios.post("{{ url('api/option') }}", this.option)
                    this.option = {}
                    this.getOptions()
                    // location.reload();
                    toastr.success('Operacion exitosa', 'Registrado correctamente')
                }
                catch{
                    toastr.error('¡Error!', 'Ocurrió un problema')
                }
            },
            async getOption(id){
                let res = await axios.get("{{ url('api/option') }}/"+id)
                this.option = res.data
            },
            async resetOption(){
                this.option = {}
            },
            async updateOption(id){
                this.option.user_id = "{{ Auth::user()->id }}"
                try{
                    let res = await axios.put("{{ url('api/option') }}/"+id, this.option)
                    this.option = res.data
                    this.getOptions()
                    // location.reload();
                    toastr.success('Operación exitosa', 'Registro actualizado')
                }
                catch(e){
                    toastr.error(e)
                }
            },
            async deleteOption(id){
                try{
                    let res = await axios.delete("{{ url('api/option') }}/"+id)
                    this.getOptions()
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