@section('bodyClass', 'store aromax subnav')
@section('currentNav', 6)
@section('currentSubNav', 3)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')


<div class="hero-block hb-b hb-store hero-store-aromax">
    <div class="container">
        <div class="hero-content">
            <div class="text-block">
                <div class="product-name">
                    <h3>Aromax</h3>
                    <p>
                        <span class="price">{{ $siteConfig['cur_symbol'] }}{{ number_format(collect($product['variations'])->avg('price'), 2, '.', ',') }}</span>
                    </p>
                </div>
                <!-- Tech Info -->
                <div class="box product-image">
                    <div class="box-cell">
                        <div class="box-content">
                            <div id="swatch-images">
                                @foreach ($product['variations'] as $key => $variation)
                                <div class="swatch-image" @if ($key>
                                    0) style="display:none" @endif id="aromax-color-{{ strtolower($variation['colour']['name']) }}">
                                    <img src="/images/store/aromax/aromax-{{ strtolower($variation['colour']['name']) }}.png" alt="Aromax {{ ucwords($variation['colour']['name']) }}" />
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="content-block cb-a">
            <!-- Tech Info -->
        <div class="text-block tb-a product-info">
            <ul class="swatches swatch-picker">
                @foreach ($product['variations'] as $variation)
                <li class="swatch-{{ strtolower($variation['colour']['name']) }}">
                    <input type="radio" name="product-color" id="product-color-{{ strtolower($variation['colour']['name']) }}" data-prvid="{{ $variation['id'] }}" data-prvstock="{{ $variation['stock'] }}" data-tab="aromax-color-{{ strtolower($variation['colour']['name']) }}" />
                    <label for="product-color-{{ strtolower($variation['colour']['name']) }}">
                        {{ $variation['colour']['name'] }}
                        <span class="swatch"></span>
                    </label>
                </li>
                @endforeach
            </ul>
            <div class="product-cart" style="display:none" id="addcartbutton">
                <button class="ui-button">Add to cart</button>
            </div>
            <div class="product-outstock" style="display:none" id="outstockbutton">
                <button class="ui-button">Out of stock</button>
            </div>
            <div class="product-desc">
                <h3>{!! $translate->token('h_aromadiffuser') !!}</h3>
                <p>{!! $translate->token('p_aromadiffuser') !!}</p>
                <p>
                    <a href="/aromax">{!! $translate->token('link_learnmorearomax') !!}</a>
                </p>
            </div>
        </div>

            <!-- Tech Info -->
            

            <!-- Tech Info -->
            
        
    </div>
    <div class="content-block cb-a">

        <div class="grid large tech">

            <!-- Tech Info -->
            <div class="box">
                <div class="box-cell">
                    <div class="box-content">
                        <h3>{!! $translate->token('h_keyfeatures') !!}</h3>
                        <div class="spec-list">
                            <ul>
                                <li>{!! $translate->token('p_keyfeature_1') !!}</li>
                                <li>{!! $translate->token('p_keyfeature_2') !!}</li>
                                <li>{!! $translate->token('p_keyfeature_3') !!}</li>
                                <li>{!! $translate->token('p_keyfeature_4') !!}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tech Info -->
            <div class="box">
                <div class="box-cell">
                    <div class="box-content">
                        <h3>{!! $translate->token('h_included') !!}</h3>
                        <div class="spec-list">
                            <ul>
                                <li>{!! $translate->token('p_included_1') !!}</li>
                                <li>{!! $translate->token('p_included_2') !!}</li>
                                <li>{!! $translate->token('p_included_3') !!}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.store.partials.related-products')

</div>

<script>
$(function() {

    $('#product-color-silver').prop('checked', 'checked');

        var prvStock = $('input[name="product-color"]:checked').data('prvstock');

        if (prvStock == 1)
        {
            $('#addcartbutton').hide();
            $('#outstockbutton').show();
        }

         if (prvStock == 0)
        {
            $('#addcartbutton').show();
            $('#outstockbutton').hide();
        }
        

    $('.swatches').change(function () {
        
        var prvStock = $('input[name="product-color"]:checked').data('prvstock');

        if (prvStock == 1)
        {
            $('#addcartbutton').hide();
            $('#outstockbutton').show();
        }

         if (prvStock == 0)
        {
            $('#addcartbutton').show();
            $('#outstockbutton').hide();
        }
    });

    $('.store').on('click', '.product-cart .ui-button', function() {

        var prvId = $('input[name="product-color"]:checked').data('prvid');

        var data = {
            'prvId': prvId,
            'quantity': 1,
        };

        api('post', '/ajax/store/cart', data).done(function (response) {
            $('.checkout-button').removeClass('button-disabled').prop('disabled', 'false').attr('href', '/store/checkout');
            $('#store-count').text(response.products);
            if(response.products > 0) {
                $('div#cart-button').addClass('has-item');
            }
            //PK ~~ 25Oct2016 -- On successful adding to the cart, move to the Cart.
        	window.location.href = '/store/cart';
        });

        $imgSource = $('.swatch-image:visible img').eq(0);
        // PK ~~ 25Oct2016 -- Remove Animation of Adding item to the cart.
        //cartAdditionAnimation($imgSource);
    });
});
</script>

@stop