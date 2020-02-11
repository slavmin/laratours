@extends('frontend.layouts.app')

@section('content')
  <form method="POST" action="{{ route('frontend.document.store') }}">
    @csrf
    <document-add
        data-app
    ></document-add>
  </form>
@endsection
