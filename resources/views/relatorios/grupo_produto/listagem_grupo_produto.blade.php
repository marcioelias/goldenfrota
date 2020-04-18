@extends('layouts.relatorios')

@section('relatorio')
<table class="table table-sm report-table">
    <thead>
        <tr class="info">
            <td>
                Id
            </td>
            <td>
                Descrição
            </td>
            
        </tr>
    </thead>
    <tbody>
        @foreach($grupoproduto as $g) 
        <tr>
            <td>
                {{$g->id}}
            </td>
            <td>
                {{$g->grupo_produto}}
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>
@endsection