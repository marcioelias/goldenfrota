@if ($data->eh_afericao)
    <button class="btn btn-xs btn-success" disabled>
        <i class="glyphicon glyphicon-wrench" data-toggle="tooltip" data-placement="top" title="{{__('Aferição')}}" data-original-title="{{__('Aferição')}}"></i>
    </button>
@else
    <a class="btn btn-xs btn-success" href="{{ route('afericao.create', ['abastecimento' => $data->id]) }}">
        <i class="glyphicon glyphicon-wrench" data-toggle="tooltip" data-placement="top" title="{{__('Aferição')}}" data-original-title="{{__('Aferição')}}"></i>
    </a>
@endif