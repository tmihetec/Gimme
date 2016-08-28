<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>H18.Gimme!</title>

    <!-- Fonts -->
    {{--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <link href='https://fonts.googleapis.com/css?family=Jaldi:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    --}}

    <link rel="stylesheet" href="{{asset("libs/font-awesome-4.6.3/css/font-awesome.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/fonts.css")}}">


    <!-- bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{asset("libs/bootstrap-3.3.6/css/bootstrap.min.css")}}"/>

    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <!-- datatables -->
    <link rel="stylesheet" type="text/css" href="{{asset("libs/DataTables/DataTables-1.10.12/css/dataTables.bootstrap.min.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("libs/DataTables/Buttons-1.2.1/css/buttons.bootstrap.min.css")}}""/>
    <link rel="stylesheet" type="text/css" href="{{asset("libs/DataTables/FixedHeader-3.1.2/css/fixedHeader.bootstrap.min.css")}}""/>
    <link rel="stylesheet" type="text/css" href="{{asset("libs/DataTables/Responsive-2.1.0/css/responsive.bootstrap.min.css")}}""/>

    <!-- select2
        
     -->
    <link rel="stylesheet" href="{{asset("libs/select2/css/select2.min.css")}}">
    <link rel="stylesheet" href="{{asset("libs/select2bootstrap/select2-bootstrap.css")}}">

    <link rel="stylesheet" href="{{asset("css/custom.css")}}">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    H18.Gimme! &nbsp;[<span style="font-weight: normal;">{{\Auth::user()->display_name}}</span>]
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    @can('haveRealisationMenuItem')
                        <li><a href="{{ url('/realisation') }}">Realisation</a></li>
                    @endcan
                    @can('CRUDusers') 
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Subjects <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/users') }}">List users</a></li>
                            <li><a href="{{ url('/users/create') }}">Add user</a></li>
                            <li><a href="{{ url('/partners') }}">List partners & POS</a></li>
                            <li><a href="{{ url('/partners/create') }}">Add partner or POS</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Messages <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/messages') }}" disabled>Sent messages</a></li>
                            <li><a href="{{ url('/messages/create') }}">Compose message</a></li>
                        </ul>
                    </li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Messages <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/users') }}" disabled>Inbox</a></li>
                        </ul>
                    </li>
                    @endcan
                    @can('CRUDitems') 
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Objects <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/items') }}">List items</a></li>
                                <li><a href="{{ url('/items/create') }}">Add item</a></li>
                                <li><a href="{{ url('/categories') }}">List categories</a></li>
                                <li><a href="{{ url('/categories/create') }}">Add category</a></li>
                                <li><a href="{{ url('/brands') }}">List brands</a></li>
                                <li><a href="{{ url('/brands/create') }}">Add brand</a></li>
                        </ul>
                    </li>
                    @else
                        <li><a href="{{ url('/activeItems') }}">Items</a></li>
                    @endcan
                    @can('seeStats') 
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Statistics <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                                <li><a href="{{ url('/stats') }}" class="disabled" >Statistics home</a></li>
                                <li><a href="{{ url('/recalculateAllResults') }}">Recalculate results</a></li>
                        </ul>
                    </li>
                    @endcan
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        {{-- <li><a href="{{ url('/register') }}">Register</a></li> --}}
                    @else
                        {{-- 
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                        --}}
                        <li><a href="{{url('/affiliate/'.Auth::user()->id)}}"><i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->name }}</a></li>
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>











    @yield('content')



    {{--

        v1.0.0 - inicijalna
        v1.1.0 - dodana realizacija za affiliate
        v1.2.0 - novi dash za affiliate, affiliate active items overview
        v1.2.1 - sređen dash za realizaciju
        v1.2.2 - admin: pos/partner list - vrijednosti u tablici

    --}}

    <footer class="footer">
      <div class="container">
        <small class="text-muted">H18.Gimme v1.2.2</small>
      </div>
    </footer>
    
    <!-- JavaScripts -->

    <!-- jquery 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    -->    
    <script type="text/javascript" src="{{asset("libs/jquery/jquery-2.2.4.min.js")}}"></script>

    <!-- hotkeys -->
    <script type="text/javascript" src="{{asset("libs/mousetrap.min.js")}}"></script>

    <!-- modal -->
    <script type="text/javascript" src="{{asset("libs/bootbox.min.js")}}"></script>
    
    <!-- bootstrap -->
    <script type="text/javascript" src="{{asset("libs/bootstrap-3.3.6/js/bootstrap.min.js")}}"></script>

    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    <!-- select2 -->
    <script type="text/javascript" src="{{asset("libs/select2/js/select2.full.min.js")}}"></script>

    <!-- bootstrap3-typeahead -->
    <script type="text/javascript" src="{{asset("libs/bootstrap3-typeahead.min.js")}}"></script>

    <!-- datatables -->
    <script type="text/javascript" src="{{asset("libs/DataTables/JSZip-2.5.0/jszip.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/pdfmake-0.1.18/build/pdfmake.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/pdfmake-0.1.18/build/vfs_fonts.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/DataTables-1.10.12/js/jquery.dataTables.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/DataTables-1.10.12/js/dataTables.bootstrap.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/Buttons-1.2.1/js/dataTables.buttons.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/Buttons-1.2.1/js/buttons.bootstrap.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/Buttons-1.2.1/js/buttons.colVis.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/Buttons-1.2.1/js/buttons.flash.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/Buttons-1.2.1/js/buttons.html5.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/Buttons-1.2.1/js/buttons.print.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/FixedHeader-3.1.2/js/dataTables.fixedHeader.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/Responsive-2.1.0/js/dataTables.responsive.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/Responsive-2.1.0/js/responsive.bootstrap.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/DataTables/Responsive-2.1.0/js/dataTables.responsive.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/moment.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("libs/datetime-moment.js")}}"></script>


    <!-- custom -->
    <script type="text/javascript" src="{{asset("js/scripts.js")}}"></script>

    <!-- page related -->
    @stack('pageRelatedJavascript')

</body>
</html>
