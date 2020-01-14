@extends('frontend.layouts.app')

@section('content')
<tour-add
    data-app
    token="{{ csrf_token() }}"
></tour-add>
@endsection
