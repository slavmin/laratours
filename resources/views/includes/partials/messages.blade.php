@push('after-scripts')
<script>
  let messageWrap = document.querySelector('.tc-alert')
  if (messageWrap) {
    setTimeout(() => {
      messageWrap.classList.add("d-none")
    }, 10000)
  }
</script>
@endpush
@if($errors->any())
<v-alert class="tc-alert tc-alert__red" dark dismissible>
  {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button> --}}

  @foreach($errors->all() as $error)
  {!! $error !!}<br />
  @endforeach
</v-alert>
@elseif(session()->get('flash_success'))
<v-alert class="tc-alert tc-alert__green" dark dismissible>

  @if(is_array(json_decode(session()->get('flash_success'), true)))
  {!! implode('', session()->get('flash_success')->all(':message<br />')) !!}
  @else
  {!! session()->get('flash_success') !!}
  @endif
</v-alert>
@elseif(session()->get('flash_warning'))
<v-alert class="tc-alert tc-alert__yellow" dark dismissible>

  @if(is_array(json_decode(session()->get('flash_warning'), true)))
  {!! implode('', session()->get('flash_warning')->all(':message<br />')) !!}
  @else
  {!! session()->get('flash_warning') !!}
  @endif
</v-alert>
@elseif(session()->get('flash_info'))
<v-alert class="tc-alert tc-alert__green" dark dismissible>

  @if(is_array(json_decode(session()->get('flash_info'), true)))
  {!! implode('', session()->get('flash_info')->all(':message<br />')) !!}
  @else
  {!! session()->get('flash_info') !!}
  @endif
</v-alert>
@elseif(session()->get('flash_danger'))
<v-alert class="tc-alert tc-alert__red" dark dismissible>

  @if(is_array(json_decode(session()->get('flash_danger'), true)))
  {!! implode('', session()->get('flash_danger')->all(':message<br />')) !!}
  @else
  {!! session()->get('flash_danger') !!}
  @endif
</v-alert>
@elseif(session()->get('flash_message'))
<v-alert class="tc-alert tc-alert__green" dark dismissible>
  @if(is_array(json_decode(session()->get('flash_message'), true)))
  {!! implode('', session()->get('flash_message')->all(':message<br />')) !!}
  @else
  {!! session()->get('flash_message') !!}
  @endif
</v-alert>
@endif