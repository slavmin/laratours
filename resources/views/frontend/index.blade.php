@extends('frontend.layouts.noheaders')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
<div class="container-fluid fullscreen-bg">
	<div class="row justify-content-center align-items-center">
		<div class="container">
			<div class="row justify-content-center align-items-center mb-4">
				<h1 class="slogan text-white">Laratours</h1>
			</div>
			<div class="col-sm-6 offset-md-3">
				@include('includes.partials.messages')
			</div>
			<login-component token="{{ csrf_token() }}"></login-component>
		</div>	
	</div>
</div>
@endsection
