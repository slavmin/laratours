@if($deleted->count() > 0)
    
    <trash
        data-app
        token="{{ csrf_token() }}"
        :items="{{ $deleted }}"
    /></trash>
    
@endif