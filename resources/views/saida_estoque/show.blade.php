@extends('layouts.relatorios')

@section('relatorio')
<div class="container-fluid m-b-10"> 
    <div class="row">
        <div class="col col-sm-12 col-md-12 col-lg-12">
            <div class="card nf-panel">
                <div class="card-body">
                    <div class="float-left mr-auto">
                        <label for="#numero" class="nf-label">Número:</label>
                        <div id="numero">{{ $saidaEstoque->id }}</div>
                    </div>
                    <div class="float-right ml-auto">
                        <label for="#data_saida" class="nf-label">Data Saída:</label>
                        <div id="data_saida">{{ date_format(date_create($saidaEstoque->data_saida), 'd/m/Y - H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-3 col-md-3 col-lg-3">
            <div class="card nf-panel">
                <label for="#estoque" class="nf-label">Estoque:</label>
                <div id="estoque">{{ $saidaEstoque->estoque->estoque }}</div>
            </div>
        </div>
        <div class="col col-sm-6 col-md-6 col-lg-6">
            <div class="card nf-panel">
                <label for="#cliente_nome" class="nf-label">Cliente:</label>
                <div id="cliente_nome">{{ $saidaEstoque->cliente->nome_razao }}</div>
            </div>
        </div>
        <div class="col col-sm-3 col-md-3 col-lg-3">
            <div class="card nf-panel">
                <label for="#departamento" class="nf-label">Departamento:</label>
                <div id="departamento">{{ isset($saidaEstoque->departamento) ? $saidaEstoque->departamento->departamento : '&nbsp;' }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-3 col-md-3 col-lg-3">
            <div class="card nf-panel">
                <label for="#cpf_cnpj" class="nf-label">CPF/CNPJ:</label>
                <div id="cpf_cnpj">{{ $saidaEstoque->cliente->cpf_cnpj }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <label for="#rg_ie" class="nf-label">RG/IE:</label>
                <div id="rg_ie">{{ $saidaEstoque->cliente->rg_ie }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <label for="#telefone" class="nf-label">Fone:</label>
                <div id="telefone">{{ $saidaEstoque->cliente->fone1 }}</div>
            </div>
        </div>
        <div class="col col-sm-5 col-md-5 col-lg-5">
            <div class="card nf-panel">
                <label for="#email" class="nf-label">E-mail:</label>
                <div id="email">{{ $saidaEstoque->cliente->email1 }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-10 col-md-10 col-lg-10">
            <div class="card nf-panel">
                <label for="#endereco" class="nf-label">Endereço:</label>
                <div id="endereco">{{ $saidaEstoque->cliente->endereco }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <label for="#numero" class="nf-label">Número:</label>
                <div id="numero">{{ $saidaEstoque->cliente->numero }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-5 col-md-5 col-lg-5">
            <div class="card nf-panel">
                <label for="#bairro" class="nf-label">Bairro:</label>
                <div id="bairro">{{ $saidaEstoque->cliente->bairro }}</div>
            </div>
        </div>
        <div class="col col-sm-4 col-md-4 col-lg-4">
            <div class="card nf-panel">
                <label for="#cidade" class="nf-label">Cidade:</label>
                <div id="cidade">{{ $saidaEstoque->cliente->cidade }}</div>
            </div>
        </div>
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                <label for="#uf" class="nf-label">UF:</label>
                <div id="uf">{{ $saidaEstoque->cliente->uf->uf }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <label for="#cep" class="nf-label">Cep:</label>
                <div id="cep">{{ $saidaEstoque->cliente->cep }}</div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid m-b-10">
    <div class="row" align="center">
        <div class="col col-sm-12 col-md-12 col-lg-12">
            <div class="card nf-panel">
                <strong>PRODUTOS</strong> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                <div>ID</div>
            </div>
        </div>
        <div class="col col-sm-5 col-md-5 col-lg-5">
            <div class="card nf-panel">
                <div>PRODUTO</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <div>QTD</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <div>VLR. UN.</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <div>VRL. TOT.</div>
            </div>
        </div>
    </div>
    @foreach($saidaEstoque->saida_estoque_items as $item)
    <div class="row">
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                <div>{{ $item->produto->id }}</div>
            </div>
        </div>
        <div class="col col-sm-5 col-md-5 col-lg-5">
            <div class="card nf-panel">
                <div>{{ $item->produto->produto_descricao }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <div align="right">{{ number_format($item->quantidade, 3, ',', '.') }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <div align="right">{{ number_format($item->valor_unitario, 3, ',', '.') }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <div align="right">{{ number_format($item->quantidade * $item->valor_unitario, 3, ',', '.') }}</div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="row">
        <div class="col col-sm-10 col-md-10 col-lg-10">
            <div class="card nf-panel">
                TOTAL DOS PRODUTOS:
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <div align="right">{{ number_format($saidaEstoque->valor_total, 3, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid m-b-10">
    <div class="row">
        <div class="col col-sm-12 col-md-12 col-lg-12">
            <div class="card nf-panel">
                <label for="#obs" class="nf-label">Observações:</label>
                <div id="obs">{{ $saidaEstoque->obs }}</div>
            </div>
        </div>
    </div>
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<div class="container-fluid m-b-10">
    <div class="row" align="center">
        <div class="col col-sm-3 col-md-3 col-lg-3">
        </div>
        <div class="col col-sm-6 col-md-6 col-lg-6">
            <div style="border-bottom: 1px solid"> </div>
        </div>
        <div class="col col-sm-3 col-md-3 col-lg-3">
        </div>
        <div class="col col-sm-12 col-md-12 col-lg-12" align="center">
            <strong>{{ $saidaEstoque->user->name ?? 'ASSINATURA RESPONSÁVEL' }} </strong> 
        </div>
    </div>
</div>
@endsection