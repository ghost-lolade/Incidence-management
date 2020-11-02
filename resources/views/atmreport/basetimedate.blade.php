@extends('layouts.app-templatedatetime')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                ATM Manager
            </h1>
            <ol class="breadcrumb">
                <!-- li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li-->
                <li class="active">ATM Manager </li>
            </ol>
        </section>
         @include('layouts.flash-message')
        @yield('action-content')


        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">

        {{--<style>--}}

            {{--.ui-accordion .ui-accordion-header {--}}
                {{--display: block;--}}
                {{--cursor: pointer;--}}
                {{--position: relative;--}}
                {{--margin: 2px 0 0 0;--}}
                {{--padding: .5em .5em .5em .7em;--}}
                {{--font-size: 100%;--}}
                {{--color: white;--}}
                {{--background-color: #148bba;--}}
            {{--}--}}
            {{--.ui-accordion-content {border: none}--}}
        {{--</style>--}}


        {{--<script>--}}
            {{--$( function() {--}}
                {{--$( "#accordion" ).accordion({--}}
                    {{--collapsible: true--}}
                {{--});--}}
            {{--} );--}}

            {{--$( function() {--}}
                {{--$( "#accordion1" ).accordion({--}}
                    {{--collapsible: true--}}
                {{--});--}}
            {{--} );--}}
            {{--$( function() {--}}
                {{--$( "#accordion2" ).accordion({--}}
                    {{--collapsible: true--}}
                {{--});--}}
            {{--} );--}}
            {{--$( function() {--}}
                {{--$( "#accordion3" ).accordion({--}}
                    {{--collapsible: true--}}
                {{--});--}}
            {{--} );--}}
        {{--</script>--}}
        <!-- /.content -->
    </div>
@endsection
