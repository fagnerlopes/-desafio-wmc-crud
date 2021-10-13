<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">



    <link rel="stylesheet" href="{{ asset('css/libs.css') }}" />
    <script src="{{ asset('js/libs.js') }}"></script>



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @toastr_css
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'WMC') }}
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">


                @auth
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('Dashboard.home') }}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Cadastros
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('Dashboard.Employees.index')}}">Funcionários</a>

                        </div>
                    </li>
                </ul>



                <!-- Right Side Of Navbar -->

                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                {{ __('Sair') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Criar conta') }}</a>
                        </li>
                    @endguest
                </ul>

            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @jquery
    @toastr_js
    @toastr_render

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        $(document).ready(function($){
            $('.date').mask('00/00/0000');
            $('.time').mask('00:00:00');
            $('.date_time').mask('00/00/0000 00:00:00');
            $('.cep').mask('00000-000');
            $('.phone').mask('0000-0000');
            $('.phone_with_ddd').mask('(00) 0000-0000');
            $('.cell_phone').mask('(00) 00000-0000')
            $('.phone_us').mask('(000) 000-0000');
            $('.mixed').mask('AAA 000-S0S');
            $('.cpf').mask('000.000.000-00', {reverse: true});
            {{--  $('.money').mask('000000.00', {reverse: true});  --}}
        });
    </script>

    <script type="text/javascript">
        $("body").bind("ajaxSend", function(elm, xhr, s){
            if (s.type == "POST") {
               xhr.setRequestHeader('X-CSRF-Token', getCSRFTokenValue());
            }
         });


        $(document).ready(function(){
            $("#state_id").change(function(){
                const stateId = $(this).val();

                console.log("Id:" + stateId);

                const  data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: stateId
                };
                console.log("Id:"+ JSON.stringify(data));

                $.ajax({
                    type: "POST",
                    url: "{{ route('autocomplete') }}",
                    data: data,
                    cache: false,
                    success: function(response) {
                        console.log("Reponse:" + JSON.stringify(response['data']));

                        if(response && response.length > 0){
                            for(let i=0; i < response.length; i++){
                                var option = `<option value='${response[i].id}'>${response[i].name}</option>`;

                                $("#city_id").append(option);
                            }
                        }
                    }
                });
            });
        });
     </script>
</body>
</html>
