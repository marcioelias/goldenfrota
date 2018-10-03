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
            <td colspan=5>
                @foreach($estoque->produtos as $produto)
                <table class="table table-condensed report-table">
                    <thead>
                        <tr class="info">
                            <td colspan=4>
                                <strong>Produto: {{ $produto->produto_descricao.' ('.$produto->grupo_produto->grupo_produto.')' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Data/Hora 
                            </td>
                            <td>
                                Tipo de Movimentação
                            </td>
                            <td>
                                Documento
                            </td>
                            <td align="right">
                                Quantidade
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalEntrada = 0;
                            $totalSaida = 0;
                        @endphp
                        @foreach($produto->movimentacao_produto as $movimentacao) 
                        @if($movimentacao->tipo_movimentacao_produto->eh_entrada) 
                            @php
                            $totalEntrada += $movimentacao->quantidade_movimentada
                            @endphp
                        @else
                            @php
                            $totalSaida += $movimentacao->quantidade_movimentada
                            @endphp
                        @endif
                        <tr>    
                            <td>
                                {{ date('d/m/Y H:i:s', strtotime($movimentacao->data_movimentacao)) }}
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
                                @elseif($movimentacao->tipo_movimentacao_produto_id == 5) 
                                    Ordem de Serviço: {{ $movimentacao->ordem_servico_id }}
                                @endif
                            </td>
                            <td align="right">
                                {{ number_format($movimentacao->quantidade_movimentada, 3, ',', '.')  }}
                            </td>
                        </tr>
                        @endforeach
                        <tr class="success">
                            <td colspan=2 align="right">
                                Total Entrada: {{ number_format($totalEntrada, 3, ',', '.') }}
                            </td>
                            <td colspan=2 align="right">
                                Total Saída: {{ number_format($totalSaida, 3, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan=4></td>
                        </tr>
                    </tbody>
                    
                </table>
                @endforeach
            </td>
        </tr>
    </tbody>
</table>
@endforeach
@endsection