@extends('frontend.layouts.app')

@section('content')
    {{-- <h1>Hello from document!</h1>
    <table>
        @foreach ($items as $item)
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ $item->published }}</td>
        @endforeach
    </table> --}}
    <documents-index
        data-app
        token="{{ csrf_token() }}"
        create-link="{{ route('frontend.document.create') }}"
    ></documents-index>
@endsection
