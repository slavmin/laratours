<div class="container-lg pt-4">
    <h4 class="card-title text-white text-center">Фильтры</h4>
    {{ html()->form('GET', route('frontend.tour.'.$model_alias.'.index'))->class('form-horizontal')->open() }}
    <div class="row align-items-center">
        <div class="col-md-4 col-xs-12">
            <div class="form-group md-form">
                {{ html()->label('Название')->class('text-white') }}

                {{ html()->text('name')
                    ->value($name)
                    ->class('form-control text-white')
                    ->attribute('maxlength', 191) 
                    }}

            </div><!--form-group-->
            
        </div><!--col-->
        <div class="col-md-4 col-xs-12">
            <div class="form-group mb-0">

                {{ html()->select('city_id')
                ->value($city_id)
                ->options($cities_for_filter)
                ->class('form-control form-control-sm') }}

            </div><!--form-group-->
            
        </div><!--col-->
        <div class="col-auto col-xs-6">
            <div class="form-group mb-0">
                <a href="{{route('frontend.tour.'.$model_alias.'.index')}}" class="btn btn-outline-primary">
                    {{__('buttons.general.reset')}}
                </a>
            </div><!--form-group-->
            
        </div><!--col-->
        <div class="col-auto col-xs-6">
            <div class="form-group mb-0">

                {{ html()->submit(__('buttons.general.crud.update'))
                ->class('btn btn-primary') }}

            </div><!--form-group-->
            
        </div><!--col-->
    </div><!--row-->
    {{ html()->form()->close() }}
</div>