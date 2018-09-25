@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        @component('components.form', [
            'title' => 'Configurações do Sistema', 
            'routeUrl' => route('setting.update'), 
            'method' => 'PUT',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'ok'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'remove']
                ]
            ])
            @section('formFields')
                @foreach ($groups as $group) 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>{{ $group->group_name }}</strong>
                        </div>
                        <div class="panel-body">
                        @foreach ($group->settings()->get() as $setting)
                            @if ($setting->data_type == 'string') 
                                @component('components.form-group', [
                                    'inputs' => [
                                        [
                                            'type' => 'text',
                                            'field' => 'groups['.$group->id.']['.$setting->key.']',
                                            'label' => $setting->description,
                                            'inputValue' => $setting->value
                                        ]
                                    ]
                                ])
                                @endcomponent
                            @endif                
                            @if ($setting->data_type == 'integer') 
                                @component('components.form-group', [
                                    'inputs' => [
                                        [
                                            'type' => 'number',
                                            'field' => 'groups['.$group->id.']['.$setting->key.']',
                                            'label' => $setting->description,
                                            'inputValue' => $setting->value
                                        ]
                                    ]
                                ])
                                @endcomponent
                            @endif
                            @if ($setting->data_type == 'boolean') 
                                @component('components.form-group', [
                                    'inputs' => [
                                        [
                                            'type' => 'select',
                                            'field' => 'groups['.$group->id.']['.$setting->key.']',
                                            'label' => $setting->description,
                                            'items' => array('Não', 'Sim'),
                                            'indexSelected' => $setting->value
                                        ]
                                    ]
                                ])
                                @endcomponent
                            @endif
                        @endforeach
                        </div>
                    </div>
                @endforeach
            @endsection
        @endcomponent
    </div>
@endsection