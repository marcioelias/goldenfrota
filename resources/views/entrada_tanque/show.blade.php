@extends('layouts.relatorios')

@section('relatorio')

<div class="container-fluid m-b-10">
    <div class="row"> 
        <div class="col col-sm-12 col-md-12 col-lg-12">
            <div class="panel nf-panel clearfix">
                <div class="pull-left">
                    <label for="#numero" class="nf-label">Número/Série:</label>
                    <div id="numero">{{ $entradaTanque->nr_docto }}/{{ $entradaTanque->serie }}</div>
                </div>
                <div class="pull-right">
                    <label for="#data_saida" class="nf-label">Data Entrada:</label>
                    <div id="data_saida">{{ date_format(date_create($entradaTanque->data_entrada), 'd/m/Y - H:i:s') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-12 col-md-12 col-lg-12">
            <div class="panel nf-panel">
                <label for="#cliente_nome" class="nf-label">Fornecedor:</label>
                <div id="cliente_nome">{{ $entradaTanque->fornecedor->nome_razao }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-3 col-md-3 col-lg-3">
            <div class="panel nf-panel">
                <label for="#cpf_cnpj" class="nf-label">CPF/CNPJ:</label>
                <div id="cpf_cnpj">{{ $entradaTanque->fornecedor->cpf_cnpj }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <label for="#rg_ie" class="nf-label">RG/IE:</label>
                <div id="rg_ie">{{ $entradaTanque->fornecedor->rg_ie }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <label for="#telefone" class="nf-label">Fone:</label>
                <div id="telefone">{{ $entradaTanque->fornecedor->fone }}</div>
            </div>
        </div>
        <div class="col col-sm-5 col-md-5 col-lg-5">
            <div class="panel nf-panel">
                <label for="#email" class="nf-label">E-mail:</label>
                <div id="email">{{ $entradaTanque->fornecedor->email }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-10 col-md-10 col-lg-10">
            <div class="panel nf-panel">
                <label for="#endereco" class="nf-label">Endereço:</label>
                <div id="endereco">{{ $entradaTanque->fornecedor->endereco }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <label for="#numero" class="nf-label">Número:</label>
                <div id="numero">{{ $entradaTanque->fornecedor->numero }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-5 col-md-5 col-lg-5">
            <div class="panel nf-panel">
                <label for="#bairro" class="nf-label">Bairro:</label>
                <div id="bairro">{{ $entradaTanque->fornecedor->bairro }}</div>
            </div>
        </div>
        <div class="col col-sm-4 col-md-4 col-lg-4">
            <div class="panel nf-panel">
                <label for="#cidade" class="nf-label">Cidade:</label>
                <div id="cidade">{{ $entradaTanque->fornecedor->cidade }}</div>
            </div>
        </div>
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="panel nf-panel">
                <label for="#uf" class="nf-label">UF:</label>
                <div id="uf">{{ $entradaTanque->fornecedor->uf->uf }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <label for="#cep" class="nf-label">Cep:</label>
                <div id="cep">{{ $entradaTanque->fornecedor->cep }}</div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid m-b-10">
    <div class="row" align="center">
        <div class="col col-sm-12 col-md-12 col-lg-12">
            <div class="panel nf-panel">
                <strong>COMBUSTÍVEIS</strong> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="panel nf-panel">
                <div>ID</div>
            </div>
        </div>
        <div class="col col-sm-3 col-md-3 col-lg-3">
            <div class="panel nf-panel">
                <div>COMBUSTÍVEL</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <div>TANQUE</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <div>QTD</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <div>VLR. UN.</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <div>VRL. TOT.</div>
            </div>
        </div>
    </div>
    @foreach($entradaTanque->entrada_tanque_items as $item)
    <div class="row">
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="panel nf-panel">
                <div>{{ $item->tanque->combustivel_id }}</div>
            </div>
        </div>
        <div class="col col-sm-3 col-md-3 col-lg-3">
            <div class="panel nf-panel">
                <div>{{ $item->tanque->combustivel->descricao }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <div>{{ $item->tanque->descricao_tanque }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <div align="right">{{ number_format($item->quantidade, 3, ',', '.') }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <div align="right">{{ number_format($item->valor_unitario, 3, ',', '.') }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <div align="right">{{ number_format($item->quantidade * $item->valor_unitario, 3, ',', '.') }}</div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="row">
        <div class="col col-sm-10 col-md-10 col-lg-10">
            <div class="panel nf-panel">
                TOTAL DOS COMBUSTÍVEIS:
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="panel nf-panel">
                <div align="right">{{ number_format($entradaTanque->valor_total, 3, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection