@extends('frontend.layouts.app')
@section('css')
<link rel="stylesheet" href="css/index.css">
@endsection
@section('title', app_name() . ' | ' . __('navs.general.home'))

<<<<<<< HEAD
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
=======
@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-home"></i> @lang('navs.general.home')
                </div>
                <div class="card-body">
                    @lang('strings.frontend.welcome_to', ['place' => app_name()])
                </div>
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->

    <div class="row mb-4">
        <div class="col">
            df
        </div><!--col-->
    </div><!--row-->

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fab fa-font-awesome-flag"></i> Font Awesome @lang('strings.frontend.test')
                </div>
                <div class="card-body">
                    <i class="fas fa-home"></i>
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-pinterest"></i>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
>>>>>>> dropjs
@endsection
