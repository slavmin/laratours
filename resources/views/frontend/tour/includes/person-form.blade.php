{{ html()
    ->form($method, $route)
    ->id('form')
    ->open() }}
{{-- Name --}}
<v-text-field name="name" label="{{ __('validation.attributes.frontend.general.name') }}"
  value="{{ $item->name ?? '' }}" maxlength="191" outlined></v-text-field>
{{-- Price --}}
<v-text-field name="price" label="{{ __('validation.attributes.frontend.general.price') }}"
  value="{{ $item->price ?? '' }}" maxlength="191" outlined type="number"></v-text-field>
{{-- Description --}}
<v-text-field name="description" label="{{ __('validation.attributes.frontend.general.description') }}"
  value="{{ $item->description ?? '' }}" maxlength="191" outlined></v-text-field>


{{ html()->form()->close() }}