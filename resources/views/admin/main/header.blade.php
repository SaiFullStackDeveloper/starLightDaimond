<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="_token" content="{{csrf_token()}}" />
    <title>Starlight Diamonds</title>
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/font-awesome/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <link href="{{ asset('assets/css/jquery-ui.css') }}" rel="stylesheet">

    <!-- FontAwesome 6.2.0 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">


    @include('style')
    <style>
        @font-face {
            font-family: 'Arboria-Medium';
            src:  asset('ttf/Arboria-Medium.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body{
            font-family: 'Arboria-Medium';
        }
        .navbar .dropdown.open>a {
            background: none !important;
        }

        .navbar .dropdown-menu {
            border-radius: 1px;
            border-color: #e5e5e5;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
        }

        .navbar .dropdown-menu li a {
            color: #777;
            padding: 8px 20px;
            line-height: normal;
        }

        .navbar .dropdown-menu li a:hover,
        .navbar .dropdown-menu li a:active {
            color: #333;
        }

        .navbar .dropdown-menu .material-icons {
            font-size: 21px;
            line-height: 16px;
            vertical-align: middle;
            margin-top: -2px;
        }

        .navbar .badge {
            background: #f44336;
            font-size: 11px;
            border-radius: 20px;
            position: absolute;
            min-width: 10px;
            padding: 4px 6px 0;
            min-height: 18px;
            top: 5px;
        }

        .navbar ul.nav li a.notifications,
        .navbar ul.nav li a.messages {
            position: relative;
            margin-right: 10px;
        }

        .navbar ul.nav li a.messages {
            margin-right: 20px;
        }

        .navbar a.notifications .badge {
            margin-left: -8px;
        }

        .navbar a.messages .badge {
            margin-left: -4px;
        }

        .navbar .active a,
        .navbar .active a:hover,
        .navbar .active a:focus {
            background: transparent !important;
        }

        @media (min-width: 1200px) {
            .form-inline .input-group {
                width: 300px;
                margin-left: 30px;
            }
        }

        @media (max-width: 1199px) {
            .form-inline {
                display: block;
                margin-bottom: 10px;
            }

            .input-group {
                width: 100%;
            }
        }
        .add_pro_title {
    font-family: 'Gotham';
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    color: #000000;
    padding-top: 22px;
    display: block;
}
span.add_pro_title img {
    cursor: pointer;
}
input.comment_input_css{
    height: 61px !important;

}
.sub_btn {
    width: 100%;
    text-align: left;
}
.cr_poin{
    cursor: pointer;
}
.mt-30{
    margin-top: 30px;
}
#preloader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: white;
  z-index: 9999;
}

#loader {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-image: url('{{ asset('assets/images/logo1.png')}}');
  background-size: contain;
  background-repeat: no-repeat;
  width: 300px;
  height: 100px;
}
.status_pending span{
    background: #ff000017;
    color: #ff0000;
}
.forward_history th {
    padding: 0px !important;
    text-align: center;
}
.forward_history td {
    padding: 0px !important;
    text-align: center;
}
.forward_history tr {
    background: #c1e8ff;
}
td.incon_css span i {
    font-size: 18px;
    margin: 6px;
}
.status_processing span {
    background: #00d0ff36;
    color: #00d0ff;
}

.add_phone_btn{
    display: flex;
    align-items: center;
}
.phone_add_img {
    height: auto;
    width: 20px;
    margin-right: 5px;
}
.add_phone_btn {
    background: #006cff;
    color: #fff;
    font-weight: 500;
}
.add_cus_ph_div{
    display: flex;
    justify-content: center;
}
.phone_number_view_div div {
    border: 1px solid #e9e9e9;
    background: #fff;
}

.titl {
    font-size: 16px;
    font-weight: 600;
}
.button_css_style {
    padding: 2px 6px;
    font-size: 14px;
}
.green_bage {
    background: #ffeb00;
    display: block;
    padding: 0px 6px;
    border-radius: 7px;
    margin-bottom: 10px;
    font-weight: 600;

}
.btn-dark {
  color: #fff;
  background-color: #343a40;
  border-color: #343a40;
}

.btn-dark:hover {
  color: #fff;
  background-color: #23272b;
  border-color: #1d2124;
}
.user_tab {
    background: #cffff2;
    padding: 9px 1px 9px 23px;
    font-size: 33px;
    font-weight: 600;
    font-family: unset;
    color: #000;
    border-radius: 10px;
    text-transform: capitalize;
}
/* background-image: url('{{ asset('assets/images/logo1.png')}}'); */
    </style>
    <style>
        /* Add your styles for image preview here */
        .preview-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .preview-image {
            margin-right: 10px;
            margin-bottom: 10px;
            max-width: 300px;
            max-height: 300px;
        }
    </style>

</head>

<body>
    <div id="preloader">
        <div id="loader"></div>
      </div>

    <header class="header_sec">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light nav_top">
                <a class="navbar-brand" href="@if(mpc(Session::get('id'),1,'view')){{ route('dashboard') }} @endif"><img
                        src="{{ asset('assets/images/logo1.png') }}" alt="logo" /></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <img src="{{ asset('assets/images/menu.png') }}" alt="">
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">

                    <ul class="navbar-nav menu_sec">
                        
                        {{-- Admiin Show navbar  --}}
                        @if (Session::get('role') == 1)
                        <li class="{{ (request()->route()->named('dashboard')) ? 'actv' : '' }}"><a
                            href="{{ route('dashboard') }}" class="das_ccs">Dashboard</a></li>
                        <li
                            class="{{ (request()->route()->named('customers')) ? 'actv' : '' }} {{ (request()->route()->named('customer_form')) ? 'actv' : '' }} {{ (request()->route()->named('edit_customer')) ? 'actv' : '' }}">
                            <a href="{{ route('customers') }}">Customers</a></li>
                        <li
                            class="{{ (request()->route()->named('worker')) ? 'actv' : '' }} {{ (request()->route()->named('edit_worker')) ? 'actv' : '' }} {{ (request()->route()->named('worker_form')) ? 'actv' : '' }}">
                            <a href="{{ route('worker') }}">Worker</a></li>
                        <li class="{{ (request()->route()->named('order_form')) ? 'actv' : '' }}"><a
                                href="{{ route('order_form') }}">Products</a></li>
                        <li class="{{ (request()->route()->named('order_history')) ? 'actv' : '' }}"><a
                                href="{{ route('order_history') }}">History</a></li>
                        <li class="{{ (request()->route()->named('repair_list')) ? 'actv' : '' }}"><a
                                    href="{{ route('repair_list') }}">Repair</a></li>
                        @elseif(Session::get('role') == 3)
                        @if(check_per(Session::get('id'),1,'view'))
                        <li class="{{ (request()->route()->named('dashboard')) ? 'actv' : '' }}"><a
                            href="{{ route('dashboard') }}" class="das_ccs">Dashboard</a></li>
                            @endif
                        @if(check_per(Session::get('id'),2,'view'))
                        <li
                            class="{{ (request()->route()->named('customers')) ? 'actv' : '' }} {{ (request()->route()->named('customer_form')) ? 'actv' : '' }} {{ (request()->route()->named('edit_customer')) ? 'actv' : '' }}">
                            <a href="{{ route('customers') }}">Customers</a></li>
                        @endif
                        @if(check_per(Session::get('id'),3,'view'))
                        <li
                            class="{{ (request()->route()->named('worker')) ? 'actv' : '' }} {{ (request()->route()->named('edit_worker')) ? 'actv' : '' }} {{ (request()->route()->named('worker_form')) ? 'actv' : '' }}">
                            <a href="{{ route('worker') }}">Worker</a></li>
                        @endif
                        @if(check_per(Session::get('id'),4,'add'))
                        <li class="{{ (request()->route()->named('order_form')) ? 'actv' : '' }}"><a
                                href="{{ route('order_form') }}">Products</a></li>
                        @endif
                        @if(check_per(Session::get('id'),4,'view'))
                        <li class="{{ (request()->route()->named('order_history')) ? 'actv' : '' }}"><a
                                href="{{ route('order_history') }}">History</a></li>
                        @endif
                        @if(check_per(Session::get('id'),6,'view'))
                        <li class="{{ (request()->route()->named('repair_list')) ? 'actv' : '' }}"><a
                                    href="{{ route('repair_list') }}">Repair</a></li>
                        @endif
                        
                        @else
                        {{-- Worker Show navbar  --}}

                        <li class="{{ (request()->route()->named('filling_form')) ? 'actv' : '' }}"><a
                                href="{{ route('filling_form')}}">Filing</a></li>
                        <li class="{{ (request()->route()->named('mounting')) ? 'actv' : '' }}"><a
                                href="{{ route('mounting') }}">Mounting</a></li>
                        <li class="{{ (request()->route()->named('setting')) ? 'actv' : '' }}"><a
                                href="{{ route('setting') }}">Setting</a></li>
                        <li class="{{ (request()->route()->named('final_polish')) ? 'actv' : '' }}"><a
                                href="{{ route('final_polish') }}">Final Polish</a></li>
                        {{-- <li class="{{ (request()->route()->named('worker_history')) ? 'actv' : '' }}"><a
                                href="{{ route('worker_history') }}">History</a></li> --}}
                        <li class="{{ (request()->route()->named('repair_filling_form')) ? 'actv' : '' }}"><a
                                    href="{{ route('repair_filling_form') }}">Repair</a></li>


                        @endif

                    </ul>
                </div>
                <ul class="hed_top_img">
                    <li>

                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle user-action"><img
                                src="{{ asset('assets/images/admin.png') }}" style="height:100%;width:30px"
                                alt="Avatar"> @if (Session::get('role') == 1){{ 'Admin' }} @elseif(Session::get('role') == 3) {{ 'Management' }} @else {{ 'Worker' }} @endif
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu mt-3">
                            <li class="divider"></li>
                            @if(mpc(Session::get('id'),7,'add'))
                            <li><a href="{{ url('karatview') }}"><i class="fa-solid fa-circle"></i>
                                Karat</a>
                            </li>
                            @endif
                            @if (Session::get('role') == 1)
                            <li><a href="{{ url('password_change_admin') }}"><i class="fa-solid fa-circle"></i>
                                Password</a>
                            </li>
                            <li><a href="{{ url('manager') }}"><i class="fa-solid fa-circle"></i>
                                Add Employee</a>
                            </li>
                            @endif
                            @if(mpc(Session::get('id'),7,'add') && Session::get('role') == 3)
                            <li><a href="{{ url('manager') }}"><i class="fa-solid fa-circle"></i>
                                Manager</a>
                            </li>
                            @endif
                            <li><a href="{{ route('logout') }}"><i class="fa-sharp fa-solid fa-right-from-bracket"></i>
                                    Logout</a></li>
                        </ul>
                    </li>

                    </li>
        </div>
        </nav>
        </div>
    </header>
