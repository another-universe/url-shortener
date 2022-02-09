@extends('layouts.main')

@section('title', config('app.name'))

@section('content')
<div id="app"></div>
@endsection

@push('scripts')
<script src="{{ mix('assets/js/app.js') }}" defer></script>
@endpush
