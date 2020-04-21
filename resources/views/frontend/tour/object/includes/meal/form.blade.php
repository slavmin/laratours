{{ html()
  ->form($method, $route)
  ->id('form')
  ->class('form-horizontal')
  ->attribute('enctype', 'multipart/form-data')
  ->open() }}

<v-row>
    <v-col md="6" sm="12">
        <h2>Общая информация:</h2>
        {{-- Name --}}
        <v-text-field name="name" label="{{ __('validation.attributes.frontend.general.name') }} *"
            value="{{ $item->name ?? '' }}" maxlength="191" outlined></v-text-field>
        {{-- City --}}
        <cities-autocomplete label="{{ __('labels.frontend.tours.city.name') }} *"
            city-id="{{ $item->city_id??$city_id }}"></cities-autocomplete>
        {{-- Address --}}
        <v-text-field name="address" label="{{ __('validation.attributes.frontend.general.address') }}"
            value="{{ $item->address ?? '' }}" maxlength="191" outlined></v-text-field>
        {{-- Description --}}
        <v-text-field name="description" label="{{ __('validation.attributes.frontend.general.description') }}"
            value="{{ $item->description ?? '' }}" maxlength="191" outlined></v-text-field>
    </v-col>
    <v-col md="6" sm="12">
        <h2>Контакты:</h2>
        {{-- site --}}
        <v-text-field name="site" label="{{ __('validation.attributes.frontend.site') }}"
            value="{{ $item->site ?? '' }}" maxlength="191" outlined></v-text-field>
        {{-- email --}}
        <v-text-field name="email" label="{{ __('validation.attributes.frontend.email') }}"
            value="{{ $item->email ?? '' }}" maxlength="191" outlined></v-text-field>
        {{-- phone --}}
        <v-text-field name="phone" label="{{ __('validation.attributes.frontend.phone') }}"
            value="{{ $item->phone ?? '' }}" maxlength="191" outlined></v-text-field>
    </v-col>
</v-row>
<v-row>
    <v-col md="6" sm="12">
        <h2>Сотрудник:</h2>
        {{-- Staff name --}}
        <v-text-field name="staff_name" label="{{ __('validation.attributes.frontend.name') }}"
            value="{{ $item->staff_name ?? '' }}" maxlength="191" outlined></v-text-field>
        {{-- Staff phone --}}
        <v-text-field name="staff_phone" label="{{ __('validation.attributes.frontend.phone') }}"
            value="{{ $item->staff_phone ?? '' }}" maxlength="191" outlined></v-text-field>
    </v-col>
    <v-col md="6" sm="12">
        <h2>Фото:</h2>
        <v-img class="white--text align-end" height="80px" width="80px" @if ($item)
            src="{{ $item->getMedia('photos')->first() ? $item->getMedia('photos')->first()->getUrl('thumb') : '' }}"
            @endif></v-img>
        <v-file-input name="photo_location" accept="image/png, image/jpeg, image/bmp"
            placeholder="Загрузите фотографию музея" prepend-icon="mdi-camera" label="Фото"></v-file-input>
    </v-col>
</v-row>

{{ html()->form()->close() }}