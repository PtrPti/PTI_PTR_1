@extends('layouts.app_aluno')

<div class=pagDisciplina>
    @foreach ($cadeira as $cadeir)
        <h1> {{$cadeir->nome}} </h1>
    @endforeach
</div>