@foreach($field->blockItems as $item)
    <cite class="cite-image">
        <img src="{{ $item->url }}"
             alt="{{ __('frontend.image.alt', ['name' => $seoService->getH1(), 'id' => $item->id]) }}"
             title="{{ __('frontend.image.title', ['name' => $seoService->getH1(), 'id' => $item->id]) }}">
        <span>{{ $field->body }}</span>
    </cite>
@endforeach
<div style="clear: both"></div>
