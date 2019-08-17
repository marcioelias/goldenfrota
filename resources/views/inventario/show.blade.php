@extends('layouts.relatorios')

@section('relatorio')
<table class="table table-sm table-bordered table-striped table-hover">
    <thead class="thead-light">
        <tr>
            <th>
                Id
            </th>
            <th>
                Produto
            </th>
            <th>
                Qtd Em Estoque
            </th>
            <th>
                Qtd Contada
            </th>
            @if($inventario->fechado)
            <th>
                Ajuste
            </th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($inventario->inventario_items as $inventario_item) 
        <tr>
            <td>
                {{$inventario_item->produto->id}}
            </td>
            <td>
                {{$inventario_item->produto->produto_descricao}}
            </td>
            <td>
                {{$inventario_item->qtd_estoque}}
            </td>
            <td>
                {{($inventario_item->qtd_contada > 0) ? $inventario_item->qtd_contada : ''}}
            </td>
            @if($inventario->fechado)
            <td>
                @if($inventario_item->qtd_contada < 0)
                    {{''}}
                @else
                    {{($inventario_item->qtd_ajuste > 0) ? '+'.$inventario_item->qtd_ajuste : $inventario_item->qtd_ajuste}}
                @endif
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
@endsection