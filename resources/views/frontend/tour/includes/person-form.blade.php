{{ html()
    ->form($method, $route)
    ->id('form')
    ->open() }}
<person-form :item="{{ $item ? $item : 'null' }}"></person-form>

{{ html()->form()->close() }}