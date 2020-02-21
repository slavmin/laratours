@extends('frontend.layouts.app')

@section('content')
<partner-tour token="{{ csrf_token() }}"></partner-tour>
@endsection