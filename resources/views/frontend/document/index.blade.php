@extends('frontend.layouts.app')

@section('content')

<documents-index data-app token="{{ csrf_token() }}" create-link="{{ route('frontend.tour.document.create') }}">
</documents-index>
@endsection