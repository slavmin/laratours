@extends('frontend.layouts.app')
@section('css')
<link rel="stylesheet" href="css/index.css">
@endsection
@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('fullscreen-bg')
<div class="container-fluid fullscreen-bg">
	<div class="row justify-content-center align-items-center">
		<div class="container">
			<div class="row justify-content-center align-items-center mb-4">
				<h1 class="slogan text-white">TourClick</h1>
			</div>
			<index 
				data-app
			></index>
		</div>	
	</div>
</div>
@endsection
