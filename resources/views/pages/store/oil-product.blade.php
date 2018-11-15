
@section('bodyClass', 'store aromax subnav')
@section('currentNav', 6)
@section('currentSubNav', $currentSubNav)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="hero-block hb-store carousel-overlay">
    <div class="container">
        <div class="hero-content">
            <div class="text-block">
                <div class="product-name">
                    <h3>{{ $product['name'] }}</h3>
                    <p>
                        @foreach ($product['variations'] as $key => $variation)
                        <span class="price" id="product-price-id{{ $variation['id'] }}" @if ($key> 0) style="display: none" @endif>{{ $siteConfig['cur_symbol'] }}{{ $variation['price'] }}</span>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="carousel">
    <?php 
     $styleCount = 1;
    ?>
    @foreach ($productimages as $productimage)
    <!-- Slide -->
    
    <div class="slide">
        <style>
            <?php
            if ($productimage->pri_fullscreen == 1)
            {
                ?>
         .hero-store-lemongrass-<?php echo $styleCount; ?> {
                background-image: url(<?php echo $productimage->pri_image ?>);
            }
         <?php
            }
            else
            {
             ?>
         .hero-store-lemongrass-<?php echo $styleCount; ?> .hero-content {
                background-image: url(<?php echo $productimage->pri_image ?>);
            }
         <?php
            }
            ?>

        </style>
        <a href="#" class="hero-block hb-b hb-store hero-store-lemongrass-<?php echo $styleCount; ?>">
            <div class="container">
                <div class="hero-content"></div>
            </div>
        </a>
    </div>
    <?php 
     $styleCount++;
    ?>
    @endforeach
</div>
						
<div class="container">
    <div class="content-block cb-a">
        <div class="text-block product-info">
            <?php $stockflag = 0; ?>
            <?php $totvars = 0; ?>

                        @foreach ($product['variations'] as $variation)
                            @if ($variation['stock'] == 0)
                                <?php $stockflag = 1; $totvars++; ?>
                            @endif
                        @endforeach
             @if ($stockflag == 1)
            <div class="product-cart" style="text-align: center;">
                @if ($totvars == 1)
                @foreach ($product['variations'] as $variation)
                @if ($variation['stock'] == 0)
                <p>{{ $variation['unit']['name'] }}</p>
                <input type="hidden" name="product-sizeid" id="product-sizeid" value="{{ $variation['id'] }}">
                @endif
                @endforeach
                
                @else
                <select id="productsize-select" class="compact">
                    @foreach ($product['variations'] as $variation)
                    @if ($variation['stock'] == 0)
                    <option value="{{ $variation['id'] }}">{{ $variation['unit']['name'] }}</option>
                    @endif
                    @endforeach
                </select>
                @endif
                
                <input type="hidden" name="product-slug" value="{{ $product['slug'] }}">
                <button  href="#" class="ui-button">Add to cart</button>
            </div>
            @else
            <div class="product-outstock">
                <br />
                <button href="#" class="ui-button">Out of stock</button>
            </div>
            @endif
            <div class="product-desc">
                <h3>{{ $product['name'] }}</h3>
                <p>{!! $product['description'] !!}</p>
            </div>
        </div>
    </div>

    <div class="content-block cb-a">

        <div class="grid large tech">

            <!-- Tech Info -->
            <div class="box">
                <div class="box-cell">
                    <div class="box-content">
                        <h3>Characteristics</h3>
                        <div class="spec-list">
                            <?php echo $product['characteristics']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tech Info -->
            <div class="box">
                <div class="box-cell">
                    <div class="box-content">
                        <h3>Quality</h3>
                        <div class="spec-list">
                            <?php echo $product['quality']; ?>
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
	var id = $('#productsize-select').val();
	updatePricing(id);

	$('.store').on('change', '#productsize-select', function() {
		var id = $(this).val();
		updatePricing(id);
	})
	.on('click', '.product-cart .ui-button', function() {
    var prvId = 0;
  if ($(this).parents('.product-info').find('#productsize-select').length)
  {
    prvId = $(this).parents('.product-info').find('#productsize-select option:selected').val();
  }
  else
  {
    prvId = $('#product-sizeid').val();
  }


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

	    $imgSource = $('div.slick-current div.store-image img').eq(0);
	    // PK ~~ 25Oct2016 -- Remove Animation of Adding item to the cart.
        //cartAdditionAnimation($imgSource);
	});
});


function updatePricing(id) {
	$('.product-info .price').hide();
	$('#product-price-id' + id).show();
}
</script>
@stop