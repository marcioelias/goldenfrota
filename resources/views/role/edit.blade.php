@extends('layouts.app')

@section('content')
    <div class="card">
        @component('components.form', [
            'title' => 'Alterar Perfil de Acesso', 
            'routeUrl' => route('role.update', $role->id), 
            'method' => 'PUT',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Save', 'icon' => 'check'],
                ['type' => 'button', 'label' => 'Cancel', 'icon' => 'times']
                ]
            ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'name',
                            'label' => 'Identificação',
                            'required' => true,
                            'inputSize' => 6,
                            'inputValue' => $role->name
                        ],
                        [
                            'type' => 'text',
                            'field' => 'display_name',
                            'label' => 'Perfil',
                            'required' => true,
                            'inputSize' => 6,
                            'inputValue' => $role->display_name
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'textarea',
                            'field' => 'description',
                            'label' => 'Descrição',
                            'inputValue' => $role->description
                        ]
                    ]
                ])
                @endcomponent
                <div class="card">
                    <div class="card-header">
                        Permissões Associadas <button type="button" id="btnCheckAll" class="btn btn-default btn-sm btn-link">Marcar todos</button><button type="button" id="btnUnCheckAll" class="btn btn-default btn-sm btn-link hidden">Desmarcar todos</button>
                    </div>
                    <div class="card-body">
                        @foreach($permissions as $permission)
                            <div class="col-sm-1 col-md-3 col-lg-3">
                                <input type="checkbox" class="permission_checkbox" name="permissions[]" value="{{$permission->id}}" {{in_array($permission->id, $assigned_permissions) ? 'checked' : ''}} >
                                {{$permission->display_name}}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endsection
        @endcomponent
    </div>
    <script>
        $('document').ready(function() {
            var doCheckAll = function checkPermissions() {
                $('.permission_checkbox').prop('checked', true);
                $('#btnCheckAll').toggleClass('hidden');
                $('#btnUnCheckAll').toggleClass('hidden');
            }

            var doUnCheckAll = function unCheckPermissions() {
                $('.permission_checkbox').prop('checked', false);
                $('#btnCheckAll').toggleClass('hidden');
                $('#btnUnCheckAll').toggleClass('hidden');
            }

            $('#btnCheckAll').click(doCheckAll);
            $('#btnUnCheckAll').click(doUnCheckAll);
        })
    </script>
@endsection