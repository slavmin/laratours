@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">

            @if(count($profiles) > 0)
                @foreach($profiles as $type => $profile)

                    @include('frontend.user.team.includes.profile-form')

                @endforeach
            @endif

        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection
