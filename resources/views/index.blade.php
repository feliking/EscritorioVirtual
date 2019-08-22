@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-12 text-center pb-3">
        <h2>Escritorio Virtual</h2>
    </div>
</div>
<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">@{{ notice.title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    @{{ notice.description }}
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="items" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">@{{ option.name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Adjuntos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in option.items">
                                <td>@{{ item.name }}</td>
                                <td>@{{ item.description }}</td>
                                <td><a href="#" data-toggle="modal" data-target="#item-document" @click.prevent="getItem(item.id)"><span class="badge badge-primary pull-right"><i class="fa fa-paperclip"></i></span></a></td>
                            </tr>
                        </tbody>
                        </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="content-document" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <a :href="notice.document" target="_blank" class="btn btn-success float-right"><i class="fa fa-expand"></i></a>
                <h5 class="modal-title" id="scrollmodalLabel">Documento adjunto</h5>
            </div>
            <div class="modal-body">
                <div class="row text-center" style="height: 400px">
                    <embed :src="notice.document" type="" width="100%">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="item-document" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <a :href="notice.document" target="_blank" class="btn btn-success float-right"><i class="fa fa-expand"></i></a>
                <h5 class="modal-title" id="scrollmodalLabel">Documento adjunto</h5>
            </div>
            <div class="modal-body">
                <div class="row text-center" style="height: 400px">
                    <embed :src="item.document" type="" width="100%">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
        <div class="col-md-4" v-for="(notice_type, index) in notice_types">
            <aside class="profile-nav alt">
                <section class="card">
                    <div class="card-header user-header alt bg-dark">
                        <div class="media">
                            <div class="media-body">
                                <h4 class="text-light display-6">Últimas Noticias: @{{ notice_type.name }}</h2>
                                {{-- <p>Project Manager</p> --}}
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" v-for="(notice, index) in notice_type.notices">
                            <a href="#" data-toggle="modal" data-target="#scrollmodal" @click.prevent="getNotice(notice.id)"> <i class="fa fa-tasks"></i> @{{ notice.title }} </a><a href="#" data-toggle="modal" data-target="#content-document" @click.prevent="getNotice(notice.id)"><span class="badge badge-primary pull-right"><i class="fa fa-paperclip"></i></span></a>
                        </li>
                    </ul>
                </section>
            </aside>
        </div>
</div>
<div class="row">
    <div class="col-md-12 text-center pb-3">
        <h2>Recursos</h2>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-lg-3" v-for="(option, index) in options">
        <a href="#" data-toggle="modal" data-target="#items" @click.prevent="getItems(option.id)">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="pt-1 float-left">
                        <h5 class="mb-0 fw-r">
                            <span class="count">@{{ option.name }}</span>
                        </h5>
                        <p class="text-light mt-1 m-0">Listar Archivos</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const app = new Vue({
        el: '#app',
        data(){
            return{
                options: [],
                notices: [],
                notice_types: [],
                notice: {},
                count: 0,
                option: {},
                item: {}
            }
        },
        mounted() {
            this.getOptions()
            this.getNoticeTypes()
            this.getNotices()
        },
        methods:{
            async getOptions(){
                let res = await axios.get('api/option')
                this.options = res.data
            },
            async getNotices(){
                let res = await axios.get('api/notice')
                this.notices = res.data
            },
            async getNoticeTypes(){
                let res = await axios.get('api/notice_type')
                this.notice_types = res.data
            },
            async getNotice(id){
                let res = await axios.get('api/notice/'+id)
                this.notice = res.data
            },
            async getItems(id){
                let res = await axios.get('api/option/'+id)
                this.option = res.data
            },
            async getItem(id){
                let res = await axios.get('api/item/'+id)
                this.item = res.data
            }
        }
    });
</script>
@endsection