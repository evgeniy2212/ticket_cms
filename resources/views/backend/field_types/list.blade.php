@if($field->boolean)
    <ol>
@else
    <ul>
@endif

@foreach($fieldItems as $fieldItem)
      <li>{{ $fieldItem->body }}</li>
@endforeach

@if($field->boolean)
    </ol>
@else
    </ul>
@endif
<div style="clear: both"></div>

