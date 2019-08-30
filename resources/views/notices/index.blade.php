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
            <form @submit.prevent="addNotice" enctype="multipart/form-data">
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
                </div>
                <div class="form-group">
                    <label for="">Documento adjunto(opcional)</label>
                    <input type="file" placeholder="Documento" class="form-control" ref="document_a">
                </div>
                <div class="form-group">
                    <label for="">Imágen de la publicación(opcional)</label>
                    <input type="file" placeholder="Documento" class="form-control" ref="img_a">
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

<div class="modal fade" id="editNotice" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Editar Noticia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="updateNotice(notice.id)" enctype="multipart/form-data">
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
                </div>
                <div class="alert alert-danger" role="alert">
                    - Sí sube un archivo se sustituíra el anterior <br>
                    - Sí no sube ningún archivo se mantendra el anterior
                </div>
                <div class="form-group">
                    <label for="">Documento adjunto(opcional)</label>
                    <input type="file" placeholder="Documento" class="form-control" ref="document_update">
                </div>
                <div class="form-group">
                    <label for="">Imágen de la publicación(opcional)</label>
                    <input type="file" placeholder="Documento" class="form-control" ref="img_update">
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
                <strong class="card-title">Últimas noticias </strong>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addNotice" @click.prevent="resetNotice"><i class="fa fa-plus"></i></button>
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
                            <td class="text-center">
                                <a href="#" class="btn-sm btn-primary" data-toggle="modal" data-target="#editNotice" @click.prevent="getNotice(notice.id)"><i class="fa fa-pencil fa-lg"></i></a>
                                <a href="#" class="btn-sm btn-danger" data-toggle="modal" data-target="#" @click.prevent="deleteNotice(notice.id)"><i class="fa fa-trash-o fa-lg"></i></a>
                            </td>
                            <td>@{{ notice.notice_type.name }}</td>
                            <td>@{{ notice.title }}</td>
                            <td>@{{ notice.description }}</td>
                            <td class="text-center"> <a :href="'../'+notice.document" target="_blank" class="fa fa-file fa-lg"></a> </td>
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
                );}, 400);
        },
        methods:{
            async getNotices(){
                let res = await axios.get("{{ route('notice.index') }}")
                this.notices = res.data
            },
            async getNoticeTypes(){
                let res = await axios.get("{{ route('notice_type.index') }}")
                this.notice_types = res.data
            },
            async addNotice(){
                let data = new FormData()
                data.append('notice_type_id', this.notice.notice_type_id)
                data.append('title', this.notice.title)
                data.append('description', this.notice.description)
                data.append('document_a', this.$refs.document_a.files[0])
                data.append('img_a', this.$refs.img_a.files[0])
                data.append('user_id', {{ Auth::user()->id }})
                try{
                    let res = await axios.post("{{ url('api/notice') }}", data)
                    this.notice = {}
                    this.$refs.document_a.value = null
                    this.$refs.img_a.value = null
                    this.getNotices()
                    // location.reload()
                    toastr.success('Operacion exitosa', 'Registrado correctamente')
                }
                catch{
                    toastr.error('¡Error!', 'Ocurrió un problema')
                }
            },
            async getNotice(id){
                let res = await axios.get("{{ url('api/notice') }}/"+id)
                this.notice = res.data
            },
            async resetNotice(){
                this.notice = {}
            },
            async updateNotice(id){
                let data = new FormData()
                data.append('_method', 'PATCH');
                data.append('notice_type_id', this.notice.notice_type_id)
                data.append('title', this.notice.title)
                data.append('description', this.notice.description)
                data.append('document_update', this.$refs.document_update.files[0])
                data.append('img_update', this.$refs.img_update.files[0])
                data.append('user_id', {{ Auth::user()->id }})
                try{
                    let res = await axios.post("{{ url('api/notice') }}/"+id, data)
                    this.notice = res.data
                    this.$refs.document_update.value = null
                    this.$refs.img_update.value = null
                    this.getNotices()
                    toastr.success('Operación exitosa', 'Registro actualizado')
                }
                catch{
                    toastr.error('Ocurrio un error', 'Vuelva a intentarlo')
                }
            },
            async deleteNotice(id){
                try{
                    let res = await axios.delete("{{ url('api/notice') }}/"+id)
                    this.getNotices()
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