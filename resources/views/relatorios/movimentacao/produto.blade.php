@extends('layouts.relatorios')

@section('relatorio')

@foreach($estoques as $estoque)
<table class="table table-condensed report-table">
    <thead>
        <tr class="info">
            <td>
                <h4>Estoque: {{ $estoque->estoque }}</h4>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <table class="table table-condensed report-table">
                    <thead>
                        <tr class="info">  
                            <td>
                                Data
                            </td>              
                            <td>
                                Grupo
                            </td>
                            <td>
                                Produto
                            </td>
                            <td>
                                Tipo Movimentacao
                            </td>
                            <td>
                                Documento
                            </td>
                            <td>
                                Quantidade
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimentacoes as $movimentacao) 
                        @if($movimentacao->estoque_id != $estoque->id) 
                            @continue
                        @endif
                        <tr>
                            <td>
                                {{ date('d/m/Y', strtotime($movimentacao->data_movimentacao)) }}
                            </td>
                            <td>
                                {{ $movimentacao->produto->grupo_produto->grupo_produto }}
                            </td>
                            <td>
                                {{ $movimentacao->produto->produto_descricao }}
                            </td>
                            <td>
                                {{ $movimentacao->tipo_movimentacao_produto->tipo_movimentacao_produto }}
                            </td>
                            <td>
                                @if($movimentacao->tipo_movimentacao_produto_id == 1)
                                    Entrada: {{ $movimentacao->entrada_estoque->nr_docto }}/{{ $movimentacao->entrada_estoque->serie }}
                                @elseif($movimentacao->tipo_movimentacao_produto_id == 2)
                                    Saída: {{ $movimentacao->saida_estoque_id }}
                                @elseif($movimentacao->tipo_movimentacao_produto_id == 3)
                                    Inventário (Entrada): {{ $movimentacao->inventario_id }}
                                @elseif($movimentacao->tipo_movimentacao_produto_id == 4)
                                    Inventário (Saída): {{ $movimentacao->inventario_id }}
                                @endif
                            </td>
                            <td>
                                {{ $movimentacao->quantidade_movimentada }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
@endforeach
@endsection