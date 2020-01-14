@extends('frontend.layouts.app')

@section('content')

<tour-edit
    data-app
    token="{{ csrf_token() }}"
    :tour="{{ $item }}"
></tour-edit>
@endsection
