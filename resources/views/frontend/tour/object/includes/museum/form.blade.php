{{ html()->form($method, $route)->class('form-horizontal')->open() }}
<v-row>
  <v-col md="12" lg="6">
    <h2>Общая информация:</h2>
    {{-- Name --}}
    <v-text-field
      name="name"
      label="{{ __('validation.attributes.frontend.general.name') }}"
      value="{{ $item->name ?? '' }}"
      maxlength="191"
      outlined
    ></v-text-field>
    {{-- City --}}
    <cities-autocomplete 
      label="{{ __('labels.frontend.tours.city.name') }}"
      city-id="{{ $item->city_id??$city_id }}"
    ></cities-autocomplete>
    {{-- Address --}}
    <v-text-field
      name="address"
      label="{{ __('validation.attributes.frontend.general.address') }}"
      value="{{ $item->address ?? '' }}"
      maxlength="191"
      outlined
    ></v-text-field>
    {{-- Type --}}
    <v-text-field
      name="types_list"
      label="{{ __('validation.attributes.frontend.general.types_list') }}"
      value="{{ $item->types_list ?? '' }}"
      maxlength="191"
      outlined
    ></v-text-field>
    {{-- Description --}}
    <v-text-field
      name="description"
      label="{{ __('validation.attributes.frontend.general.description') }}"
      value="{{ $item->description ?? '' }}"
      maxlength="191"
      outlined
    ></v-text-field>
  </v-col>
  <v-col md="12" lg="6">
    <h2>Общая информация:</h2>
    {{-- Museum site --}}
    <v-text-field
      name="museum_site"
      label="{{ __('validation.attributes.frontend.site') }}"
      value="{{ $item->museum_site ?? '' }}"
      maxlength="191"
      outlined
    ></v-text-field>
    {{-- Museum email --}}
    <v-text-field
      name="museum_email"
      label="{{ __('validation.attributes.frontend.email') }}"
      value="{{ $item->museum_email ?? '' }}"
      maxlength="191"
      outlined
    ></v-text-field>
    {{-- Museum phone --}}
    <v-text-field
      name="museum_phone"
      label="{{ __('validation.attributes.frontend.phone') }}"
      value="{{ $item->museum_phone ?? '' }}"
      maxlength="191"
      outlined
    ></v-text-field>
  </v-col>
  <v-col md="12" lg="6">
    <h2>Сотрудник:</h2>
    {{-- Staff name --}}
    <v-text-field
      name="staff_name"
      label="{{ __('validation.attributes.frontend.name') }}"
      value="{{ $item->staff_name ?? '' }}"
      maxlength="191"
      outlined
    ></v-text-field>
    {{-- Staff phone --}}
    <v-text-field
      name="staff_phone"
      label="{{ __('validation.attributes.frontend.phone') }}"
      value="{{ $item->staff_phone ?? '' }}"
      maxlength="191"
      outlined
    ></v-text-field>
  </v-col>
  {{ html()->file('avatar_location')->class('form-control') }}
</v-row>

<hr>

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            <div class="col">
                {{ html()->a($cancel_route, __('buttons.general.cancel'))->class('btn btn-outline-info btn-sm') }}
            </div><!--col-->

            <div class="col text-right">
                {{ html()->submit(__('buttons.general.crud.update'))->class('btn btn-success btn-sm') }}
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

{{-- <div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('validation.attributes.frontend.general.qnt'))
                ->class('col-md-2 form-control-label')
                ->for('qnt') }}

            <div class="col-md-10">
                {{ html()->input('number', 'qnt', $item->qnt??'')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.general.qnt'))
                    ->attribute('maxlength', 191)
                    ->autofocus() }}
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row--> --}}

{{ html()->form()->close() }}