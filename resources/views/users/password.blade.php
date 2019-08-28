<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Escritorio Virtual</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('css/lib/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body class="bg-dark">
    <div class="sufee-login d-flex align-content-center flex-wrap" id="app">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="{{ url('/') }}">
                        <img class="align-content" src="{{ asset('images/logo.png') }}" alt="">
                    </a>
                </div>
                <div class="login-form">
                    <form @submit.prevent="changePassword()">
                        @csrf
                        <div class="form-group">
                            <label>Contraseña nueva</label>
                            <input type="password" class="form-control" placeholder="Nueva contraseña" v-model="data.password">
                        </div>
                        <div class="form-group">
                            <label>Repita la contraseña</label>
                            <input type="password" class="form-control" placeholder="Repita la contraseña" v-model="data.password_repeat">
                        </div>
                        <div v-if="message != ''" class="alert alert-danger" role="alert">
                            @{{ message }}
                        </div>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Cambiar contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery.matchHeight.min.js') }}"></script>
    <script src="{{ asset('js/vue.js') }}"></script>
    <script src="{{ asset('js/axios.js') }}"></script>
    <script>
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        
        let token = document.head.querySelector('meta[name="csrf-token"]');
        
        if (token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        } else {
            console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }
    </script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        const app = new Vue({
            el: '#app',
            data(){
                return{
                    data: {},
                    message: ''
                }
            },
            methods:{
                async changePassword(){
                    if(this.data.password == this.data.password_repeat){
                        try{
                            let res = await axios.put("{{ url('api/user') }}"+"/"+{{ Auth::user()->id }}, this.data)
                            window.history.back()
                        }
                        catch(e){
                            console.log(e)
                        }
                    }
                    else{
                        this.message = 'Las contraseñas no coinciden'
                    }
                }
            }
        });
    </script>
</body>
</html>
