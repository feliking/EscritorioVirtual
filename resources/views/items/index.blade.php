@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/lib/datatable/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
<div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Nuevo Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="addItem" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <select name="select" id="select" class="form-control" v-model="item.option_id" required>
                        <option v-for="option in options" :value="option.id" selected>@{{ option.name }}</option>
                    </select>
                    <small>Seleccione el tipo de opción</small>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Nombre del Item" class="form-control" v-model="item.name" required>
                </div>
                <div class="form-group">
                    <textarea rows="7" placeholder="Descripción" class="form-control" v-model="item.description" required></textarea>
                </div>
                <div class="form-group">
                    <input type="file" placeholder="Documento" class="form-control" ref="document" required>
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

<div class="modal fade" id="editItem" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Editar Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="updateItem(item.id)" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <select name="select" id="select" class="form-control" v-model="item.option_id" required>
                        <option v-for="option in options" :value="option.id" selected>@{{ option.name }}</option>
                    </select>
                    <small>Seleccione el tipo de opción</small>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Nombre del Item" class="form-control" v-model="item.name" required>
                </div>
                <div class="form-group">
                    <textarea rows="7" placeholder="Descripción" class="form-control" v-model="item.description" required></textarea>
                </div>
                <div class="alert alert-danger" role="alert">
                    - Sí sube un archivo se sustituíra el anterior <br>
                    - Sí no sube ningún archivo se mantendra el anterior
                </div>
                <div class="form-group">
                    <input type="file" placeholder="Documento" class="form-control" ref="document_update">
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
                <strong class="card-title">Items </strong>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addItem" @click.prevent="resetItem"><i class="fa fa-plus"></i></button>
            </div>
            <div class="card-body text-left">
                <table id="bootstrap-data-table-export" class="table table-striped table-bordered dt-responsive small">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th class="text-white bg-dark">Tipo de Opción</th>
                            <th class="text-white bg-dark">Nombre</th>
                            <th class="text-white bg-dark">Descripción</th>
                            <th class="text-white bg-dark">Adjunto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in items">
                            <td class="text-center">
                                <a href="#" class="btn-sm btn-primary" data-toggle="modal" data-target="#editItem" @click.prevent="getItem(item.id)"><i class="fa fa-pencil fa-lg"></i></a>
                                <a href="#" class="btn-sm btn-danger" data-toggle="modal" data-target="#" @click.prevent="deleteItem(item.id)"><i class="fa fa-trash-o fa-lg"></i></a>
                            </td>
                            <td>@{{ item.option.name }}</td>
                            <td>@{{ item.name }}</td>
                            <td>@{{ item.description }}</td>
                            <td class="text-center"> <a :href="'../'+item.document" target="_blank" class="fa fa-file fa-lg"></a> </td>
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
                items: [],
                options: [],
                item: {}
            }
        },
        mounted() {
            this.getItems()
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
                );}, 0);
        },
        methods:{
            async getItems(){
                let res = await axios.get("{{ route('item.index') }}")
                this.items = res.data
                console.log(this.items)
            },
            async getOptions(){
                let res = await axios.get("{{ route('option.index') }}")
                this.options = res.data
            },
            async addItem(){
                let data = new FormData()
                data.append('option_id', this.item.option_id)
                data.append('name', this.item.name)
                data.append('description', this.item.description)
                data.append('file', this.$refs.document.files[0])
                data.append('user_id', {{ Auth::user()->id }})
                try{
                    let res = await axios.post("{{ url('api/item') }}", data)
                    this.item = {}
                    this.$refs.document.value = null
                    this.getItems()
                    toastr.success('Operacion exitosa', 'Registrado correctamente')
                }
                catch{
                    toastr.error('¡Error!', 'Ocurrió un problema')
                }
            },
            async getItem(id){
                let res = await axios.get("{{ url('api/item') }}/"+id)
                this.item = res.data
            },
            async resetItem(){
                this.item = {}
            },
            async updateItem(id){
                let data = new FormData()
                data.append('_method', 'PATCH');
                data.append('option_id', this.item.option_id)
                data.append('name', this.item.name)
                data.append('description', this.item.description)
                if(this.$refs.document_update.files[0]){
                    data.append('file', this.$refs.document_update.files[0])
                }
                data.append('user_id', {{ Auth::user()->id }})
                try{
                    let res = await axios.post("{{ url('api/item') }}/"+id, data)
                    this.item = res.data
                    this.$refs.document_update.value = null
                    this.getItems()
                    toastr.success('Operación exitosa', 'Registro actualizado')
                }
                catch{
                    toastr.error('Ocurrio un error', 'Vuelva a intentarlo')
                }
            },
            async deleteItem(id){
                try{
                    let res = await axios.delete("{{ url('api/item') }}/"+id)
                    this.getItems()
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