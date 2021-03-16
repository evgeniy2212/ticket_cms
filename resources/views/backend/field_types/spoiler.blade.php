<div class="accordion js-accordion">
    <div class="accordion__item js-accordion-item">
        <div class="accordion-header js-accordion-header">
            {{ $field->title }}
        </div>
        <div class="accordion-body js-accordion-body" style="display: none;">
            <div class="accordion-body__contents">
                <span class="subttl">{{ $field->subtitle }}</span>
                <p>
                    {{ $field->body }}
                </p>
            </div>
        </div>
    </div><!-- end of accordion body -->
</div>
<div style="clear: both"></div>
