@extends('layouts.relatorios')

@section('relatorio')
<table class="table table-condensed report-table">
    <thead>
        <tr class="info">
            <td>
                Id
            </td>
            <td>
                Produto
            </td>
            <td>
                Grupo de Produto
            </td>
            <td>
                Estoque
            </td>
            <td>
                Estoque Mínimo
            </td>
            <td>
                Qtd em Estoque
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach($produtos as $produto) 
        <tr>
            <td>
                {{$produto->id}}
            </td>
            <td>
                {{$produto->produto_descricao}}
            </td>
            <td>
                {{$produto->grupo_produto}}
            </td>
            <td>
                {{$produto->estoque}}
            </td>
            <td>
                {{$produto->estoque_minimo}}
            </td>
            <td>
                {{$produto->posicao}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection