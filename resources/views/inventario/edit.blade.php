@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Inventário', 
            'routeUrl' => route('inventario.update', $inventario->id), 
            'method' => 'PUT',
            'formButtons' => [
                //['type' => 'button', 'label' => 'Salvar', 'icon' => 'floppy-save'],
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'check'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times']
                ]
            ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'id',
                            'label' => 'ID',
                            'disabled' => true,
                            'inputValue' => $inventario->id,
                            'inputSize' => 1
                        ],
                        [
                            'type' => 'text',
                            'field' => 'estoque', 
                            'label' => 'Estoque',
                            'disabled' => true,
                            'inputValue' => $inventario->estoque->estoque,
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_abertura',
                            'label' => 'Data Abertura',
                            'disabled' => true,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'inputValue' => \DateTime::createFromFormat('Y-m-d H:i:s', $inventario->data_abertura)->format('d/m/Y H:i:s'),
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_fechamento',
                            'label' => 'Data Fechamento',
                            'disabled' => true,
                            'inputValue' => $inventario->data_fechamento,
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'checkbox',
                            'field' => 'fechado',
                            'label' => 'Fechado',
                            'dataWidth' => 65,
                            'inputSize' => 1,
                            'dataSize' => 'default',
                            'disabled' => false,
                            'inputValue' => $inventario->fechado,
                        ]
                        
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'textarea',
                            'field' => 'obs_inventario',
                            'label' => 'Observação/Motivo',
                            'inputValue' => $inventario->obs_inventario
                        ]
                    ]
                ])
                @endcomponent
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col col-xs-1 col-sm-1 col-md-1">ID</div>
                            <div class="col col-xs-7 col-sm-7 col-md-9">Produto</div>
                            <div class="col col-xs-4 col-sm-4 col-md-2">Qtd Contada</div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 0px 15px !important">
                        @foreach($inventario->inventario_items as $key => $item)
                        <div class="row {{ ($key % 2 == 0) ? 'bg-secondary text-light' : 'bg-light' }}">
                            <div class="col col-xs-1 col-sm-1 col-md-1" style="padding-top: 3px">{{ $item->produto->id }}</div>
                            <div class="col col-xs-7 col-sm-7 col-md-9" style="padding-top: 3px">{{ $item->produto->produto_descricao }}</div>
                            <div class="col col-xs-4 col-sm-4 col-md-2">
                                @php
                                    $contado = (old('items[$item->id][qtd_contada]')) ? old('items[$item->id][qtd_contada]') : $item->qtd_contada;
                                    if ($contado < 0) {
                                        $contado = '';
                                    }
                                @endphp
                                <input type="text" class="form-control form-control-sm" name="items[{{$item->id}}][qtd_contada]" value="{{ $contado }}" >
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endsection
        @endcomponent
    </div>
    <script>
        $('#fechado').on('change', () => {
            if ($('#fechado').is(':checked')) {
                $('#data_fechamento').val(new Date().toLocaleString());
            } else {
                $('#data_fechamento').val('');
            }
        });
    </script>
@endsection