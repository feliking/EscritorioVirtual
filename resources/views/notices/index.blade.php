@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/lib/datatable/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
<div class="modal fade" id="addNotice" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Nueva Noticia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="addNotice">
            <div class="modal-body">
                <div class="form-group">
                    <select name="select" id="select" class="form-control" v-model="notice.notice_type_id" required>
                        <option v-for="notice_type in notice_types" :value="notice_type.id" selected>@{{ notice_type.name }}</option>
                    </select>
                    <small>Seleccione el tipo de noticia</small>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Título" class="form-control" v-model="notice.title" required>
                </div>
                <div class="form-group">
                    <textarea rows="7" placeholder="Descripción" class="form-control" v-model="notice.description" required></textarea>
                </div>'api/notice'
                <div class="form-group">
                    <input type="file" placeholder="Documento" class="form-control" ref="document" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
                <strong class="card-title">Últimas noticias </strong>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addNotice" title="Añadir Proveedor"><i class="fa fa-plus"></i></button>
            </div>
            <div class="card-body text-left">
                <table id="bootstrap-data-table-export" class="table table-striped table-bordered dt-responsive small">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th class="text-white bg-dark">Tipo de noticia</th>
                            <th class="text-white bg-dark">Título</th>
                            <th class="text-white bg-dark">Descripción</th>
                            <th class="text-white bg-dark">Adjunto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(notice, index) in notices">
                            <td>
                                <button type="button" class="btn btn-info" title="Documentos guardados" data-toggle="modal" data-target="#docproveedor.id"><i class="fa fa-file-text"></i></button>
                                <button type="button" class="btn btn-info" title="Editar Proveedor" data-toggle="modal" data-target="'#edit'+proveedor.id"><i class="fa fa-pencil"></i></button>
                                <button type="button" class="btn btn-info" title="Socios del proveedor" data-toggle="modal" data-target="'#part'+proveedor.id"><i class="fa fa-users"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar Proveedor" data-toggle="modal" data-target="'#del'+proveedor.id"><i class="fa fa-trash-o"></i></button>
                            </td>
                            <td>@{{ notice.notice_type.name }}</td>
                            <td>@{{ notice.title }}</td>
                            <td>@{{ notice.description }}</td>
                            <td> documento </td>
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
                notices: [],
                notice_types: [],
                notice: {}
            }
        },
        mounted() {
            this.getNotices()
            this.getNoticeTypes()
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
            async getNotices(){
                let res = await axios.get("{{ route('notice.index') }}")
                this.notices = res.data
                console.log(this.notices)
            },
            async getNoticeTypes(){
                let res = await axios.get("{{ route('notice_type.index') }}")
                this.notice_types = res.data
                console.log(this.notice_types)
            },
            async addNotice(){
                let data = new FormData()
                data.append('notice_type_id', this.notice.notice_type_id)
                data.append('title', this.notice.title)
                data.append('description', this.notice.description)
                data.append('document', this.$refs.document)
                try{
                    let res = await axios.post("{{ route('notice_type.index') }}", data)
                }
                catch{
                    console.log('Ocurrio un error en el sistema')
                }
            }
        }
    });
</script>
@endsection