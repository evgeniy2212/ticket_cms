<div class="iframe-container" style="float: {{ $field->boolean ? 'right' : 'left' }}" class="p-3">
        <iframe src="//docs.google.com/viewer?url={{ asset($field->subtitle) }}&amp;hl=uk&amp;embedded=true"\
                class="{{ $filter->getWidthClass() }} responsive-iframe"
                title="{{ $field->title }}">
        </iframe>
</div>
<figure>
    <figcaption>{{ $field->title }}</figcaption>
</figure>
<a href="{{ $field->subtitle }}" download>Завантажити</a>
<br>
