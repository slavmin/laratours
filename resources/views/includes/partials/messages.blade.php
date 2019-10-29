 @if($errors->any())
    <messages
        messages="{{ $errors }}"
        message-type="error"
    ></messages>
@elseif(session()->get('flash_success'))
    <messages
        messages="{{ session()->get('flash_success') }}"
        message-type="success"
    ></messages>
@elseif(session()->get('flash_warning'))
    <messages
        messages="{{ session()->get('flash_warning') }}"
        message-type="warning"
    ></messages>
@elseif(session()->get('flash_info'))
    <messages
        messages="{{ session()->get('flash_info') }}"
        message-type="info"
    ></messages>
@elseif(session()->get('flash_danger'))
    <messages
        messages="{{ session()->get('flash_danger') }}"
        message-type="error"
    ></messages>
@elseif(session()->get('flash_message'))
    <messages
        messages="{{ session()->get('flash_message') }}"
        message-type="info"
    ></messages>
@endif
