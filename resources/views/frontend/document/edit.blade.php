@extends('frontend.layouts.app')

@section('content')
  <form method="POST" action="{{ route('frontend.document.update', $item->id) }}">
    @method('PATCH')
    @csrf
    <!-- @if($errors->any())
      {{ session()->get('errors') }}
    @endif -->
    <document-edit
        data-app
        :document="{{ $item }}"
    ></document-edit>
  </form>
@endsection
