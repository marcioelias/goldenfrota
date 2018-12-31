@extends('layouts.app')

@section('content')
    <div class="card">
        @component('components.form', [
            'title' => 'Novo Inventário', 
            'routeUrl' => route('inventario.store'), 
            'method' => 'POST',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'check'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times']
                ]
            ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'estoque_id',
                            'label' => 'Estoque',
                            'required' => true,
                            'items' => $estoques,
                            'displayField' => 'estoque',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'defaultNone' => true,
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'select',
                            'field' => 'grupo_produto_id',
                            'label' => 'Grupo de Produtos',
                            'items' => null,
                            'displayField' => 'grupo_produto',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'disabled' => true,
                            'inputSize' => 4,
                            'multiple' => true
                        ],
                        [
                            'type' => 'select',
                            'field' => 'produto_id',
                            'label' => 'Produto',
                            'items' => null,
                            'displayField' => 'produto_descricao',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'disabled' => true,
                            'inputSize' => 4
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'textarea',
                            'field' => 'obs_inventario',
                            'label' => 'Observação/Motivo'
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
    <script>
        $(document).ready(function() {
            var clearSelect = function (selectComponentId) {
                $(selectComponentId)
                    .attr('disabled', 'disabled')
                    .find('option')
                    .remove();
                    $(selectComponentId).selectpicker('refresh');
            }

            var buscarGrupoProdutos = function() {
                var estoque = {};

                if(!$('#estoque_id').val()) {
                    clearSelect('#grupo_produto_id');
                    clearSelect('#produto_id');
                } else {     
                    estoque.id = $('#estoque_id').val();
                    estoque._token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route("grupo_produto.json") }}',
                        type: 'POST',
                        data: estoque,
                        dataType: 'JSON',
                        cache: false,
                        success: function (data) {
                            $("#grupo_produto_id")
                                .removeAttr('disabled')
                                .find('option')
                                .remove(); 
                            
                            $('#grupo_produto_id').append($('<option>', {
                                value: '',
                                text: 'Nada Selecionado'
                            }));

                            $.each(data, function (i, item) {
                                $('#grupo_produto_id').append($('<option>', { 
                                    value: item.id,
                                    text : item.grupo_produto
                                }));
                            });
                            
                            @if(old('grupo_produto_id'))
                            $('#grupo_produto_id').selectpicker('val', {{old('grupo_produto_id')}});
                            @endif

                            $('.selectpicker').selectpicker('refresh');
                        },
                        error: function (data) {
                        }
                    });
                }
            }

            var buscarProdutos = function() {
                var grupo_produto = {};

                if(!$('#grupo_produto_id').val()) {
                    clearSelect('#produto_id');
                } else {              
                    grupo_produto.id = $('#grupo_produto_id').val();
                    grupo_produto._token = $('input[name="_token"]').val();

                    $.ajax({
                        url: '{{ route("produtos_pelo_grupo.json") }}',
                        type: 'POST',
                        data: grupo_produto,
                        dataType: 'JSON',
                        cache: false,
                        success: function (data) {
                            $("#produto_id")
                                .removeAttr('disabled')
                                .find('option')
                                .remove(); 

                            $('#produto_id').append($('<option>', {
                                value: '',
                                text: 'Nada Selecionado'
                            }));

                            $.each(data, function (i, item) {
                                $('#produto_id').append($('<option>', { 
                                    value: item.id,
                                    text : item.produto_descricao
                                }));
                            });
                            
                            @if(old('produto_id'))
                            $('#produto_id').selectpicker('val', {{old('produto_id')}});
                            @endif

                            $('.selectpicker').selectpicker('refresh');
                        },
                        error: function (data) {
                        }
                    });
                }
            }
            
            $('#estoque_id').on('changed.bs.select', buscarGrupoProdutos);
            $('#grupo_produto_id').on('changed.bs.select', buscarProdutos);

            if ($('#estoque_id').val()) {
                buscarGrupoProdutos();
            }

            if ($('#grupo_produto_id').val()) {
                buscarProdutos();
            }
        });
    </script>
@endsection