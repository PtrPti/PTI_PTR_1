@extends('layouts.app_docente')

@section('content')

<div class="nav_icons">
    <div class="@if($active_tab == 1) active @endif" id="tab1" onclick="ShowHome()"><img src="{{ asset('images/home_icon.png') }}"> Home </div>
    <div class="@if($active_tab == 2) active @endif" id="tab2" onclick="ShowProjetos()"><img src="{{ asset('images/projetos_icon.png') }}"> Projetos </div>
</div>

<script>
$(document).ready(function() {
    $("#" + "<?php echo $active_tab ?>").trigger("click");
});
</script>

@include('docente.disciplinasDocente')
@include('docente.projetosDocente')

@endsection