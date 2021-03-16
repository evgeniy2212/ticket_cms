@if(count($block->blockItems) === 1)
    <figure style="float: {{ $block->boolean ? 'right' : 'left' }}; padding: 10px">
        <img src="{{ $blockItem->url }}"
             alt="{{ __('frontend.image.alt_without_id', ['name' => $seoService->getH1()]) }}"
             title="{{ __('frontend.image.title_without_id', ['name' => $seoService->getH1()]) }}">
        <figcaption>{{ $block->title }}</figcaption>
    </figure>
@else
    <div class="{{ $filter->getWidthClass() }}" style="float: {{ $block->boolean ? 'right' : 'left' }}; padding: 10px">
        <section class="js-slider-simple">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($block->blockItems as $key => $item)
                        <div class="swiper-slide">
                            <img src="{{ $item->url }}"
                                 alt="{{ __('frontend.image.alt' . ($key ? '' : '_without_id'), ['name' => $seoService->getH1(), 'id' => $key]) }}"
                                 title="{{ __('frontend.image.title' . ($key ? '' : '_without_id'), ['name' => $seoService->getH1(), 'id' => $key]) }}">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <figure>
                <figcaption>{{ $block->title }}</figcaption>
            </figure>
        </section>
    </div>
@endif
@if($filter->isFullWidth())
    <div style="clear: both"></div>
@endif
