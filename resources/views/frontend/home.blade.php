@extends('frontend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('frontend.welcome') }}</div>

                <div class="card-body">
                    {{ __('frontend.slogan') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
