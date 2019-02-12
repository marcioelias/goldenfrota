@extends('layouts.app')

@section('content-no-app')
    <div id="dashboard">
        <graphs></graphs>
    </div>
@endsection

@push('bottom-scripts')
    <script src="{{ mix('js/dashboard.js') }}"></script>
@endpush