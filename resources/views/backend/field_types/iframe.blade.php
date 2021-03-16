<div class="iframe-container p-3" style="float: {{ $field->boolean ? 'right' : 'left' }}">
    <iframe  src="{{ $field->subtitle }}"
            class="{{ $filter->getWidthClass() }} responsive-iframe"
            title="{{ $field->title }}">
    </iframe>
    <figure>
        <figcaption>{{ $field->title }}</figcaption>
    </figure>
</div>
