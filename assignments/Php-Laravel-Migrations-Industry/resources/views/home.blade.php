@extends('master')

@section('title', 'home page')

@section('content')

    <h2>this is a home opage</h2>

@endsection

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endpush
