@extends('layouts.app')

@section('content')
<div id="estoque-produto-component">
  <estoque-produto></estoque-produto>
</div>
@endsection

@push('bottom-scripts')
    <script src="{{ mix('js/estoqueproduto.js') }}"></script>
@endpush
