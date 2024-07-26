@extends('master')

@section('title', 'profile page')

@section('content')

    <h2>this is a profile page</h2>

@endsection
@push('scripts')
    <script src="{{ asset('js/profile.js') }}"></script>
@endpush
