 @extends('admin.layouts.control')

@section('content')


<style>
#myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    /*width: 80%;*/
    max-width: 700px;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
.modal-content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>


<section class="products page">

    @if (isset($product))
	    {!!Form::model($product, ['method' => 'post', 'id' => 'form', 'files' => true]) !!}
    @else
	    {!!Form::open(['method' => 'post', 'id' => 'form' , 'files' => true]) !!}
    @endif

    <div class="actionbar">
        <div class="header">
            <h3>Product Details</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>Product Information</h4>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="row {!! $errors->first('pro_name', 'missing-field') !!}">
                        <div class="col-md-6">Name </div>
                        <div class="col-md-6">
                            {{Form::text('pro_name', isset($product) ? $product[0]->pro_name : null, ['placeholder' => isset($product) ? $product[0]->prt_pro_name : null, 'class' => 'form-control'])}}
                            {!! $errors->first('pro_name', '<span class="field-message">:message</span>') !!}
                        </div>
                    </div>
                    <div class="row {!! $errors->first('pro_slug', 'missing-field') !!}">
                        <div class="col-md-6">Slug </div>
                        <div class="col-md-6">
                            {{Form::text('pro_slug', isset($product) ? $product[0]->pro_slug : null, ['placeholder' => isset($product) ? $product[0]->prt_pro_slug : null, 'class' => 'form-control'])}}
                            {!!$errors->first('pro_slug', '<span class="field-message">:message</span>') !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Link Prefix </div>
                        <div class="col-md-6">
                            {{Form::text('pro_linkprefix', isset($product) ? $product[0]->pro_linkprefix : null, ['placeholder' => isset($product) ? $product[0]->pro_linkprefix : null, 'class' => 'form-control'])}}
                            {!! $errors->first('pro_linkprefix', '<span class="field-message">:message</span>') !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Category </div>
                        <div class="col-md-6">
                            <select id="product-category" name="product-category" class="form-control">
                                @if(count($categories))
                                    @foreach ($categories as $category)
                                            @if (isset($product) && $category->cat_id == $product[0]->cat_id)
                                                <option selected="selected" value="{{ $category->cat_id }}">{{ $category->cat_name }}</option>
                                            @else
                                                <option value="{{ $category->cat_id }}">{{ $category->cat_name }}</option>
                                            @endif
                                    @endforeach
                                @endif
                            </select>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Oil Groups </div>
                        <div class="col-md-6">
                            <select id="oil-group" name="oil-group" class="form-control">
                                <option value="0">None</option>
                                @if(count($oilgroups))
                                @foreach ($oilgroups as $oilgroup)
                                @if (isset($product) && $oilgroup->olg_id == $product[0]->olg_id)
                                <option selected="selected" value="{{ $oilgroup->olg_id }}">{{ $oilgroup->olg_name }}</option>
                                @else
                                <option value="{{ $oilgroup->olg_id }}">{{ $oilgroup->olg_name }}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row {!! $errors->first('pro_description', 'missing-field') !!}">
                        <div class="col-md-6">Description </div>
                        <div class="col-md-6">
                            {{Form::textarea('pro_description', isset($product) ? $product[0]->pro_description : null, ['placeholder' => isset($product) ? $product[0]->prt_pro_description : null, 'class' => 'form-control'])}}
                            {!!$errors->first('pro_description', '<span class="field-message">:message</span>') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>

    <div class="row">
            <div class="col-md-12">
                <h4>Variations</h4>
            </div>
        </div>

    @if (isset($product))
        <table class="table" id="productvariationTable" name="productvariationTable">
        <thead>
            <tr>
                <th style="width:10%">Unit Size</th>
                <th style="width:7%">Colour</th>
                <th style="width:7%">Enabled</th>
                <th style="width:7%">Out of Stock</th>
                <th style="width:10%">Sell Price</th>
                <th style="width:10%">Shipping Units</th>
                <th style="width:10%">Shipping Weight</th>
                <th style="width:10%">Shipping Dimensions (.x.x.)</th>
                <th style="width:10%">&nbsp;</th>
                <th style="width:10%">New Tile</th>
                <th style="width:10%">&nbsp;</th>
                <th style="width:10%">New Thumbnails</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($product as $pro)
            {
            ?>
            <tr>
                <td class="description">
                    <?=$pro->uni_name?>
                </td>
                <td class="price item-unit">
                    <?=$pro->col_name?>
                </td>
                <td class="quantity">
                    <input type="checkbox" name="chkAvailable_<?=$pro->proweb_prv_id?>" id="chkAvailable_<?=$pro->proweb_prv_id?>" <?=($pro->proweb_available == 1)?'checked':''?> />
                </td>
                <td class="price item-total">
                    <input type="checkbox" name="outofStock_<?=$pro->proweb_prv_id?>" id="outofStock_<?=$pro->proweb_prv_id?>" <?=($pro->proweb_outofstock == 1)?'checked':''?> />
                </td>
                <td class="price item-total">
                    <input type="textbox" name="txtPrice_<?=$pro->proweb_prv_id?>" id="txtPrice_<?=$pro->proweb_prv_id?>" value="<?=$pro->proweb_price?>" style="width:100%" />
                </td>
                <td class="price item-total">
                    <input type="textbox" name="shipUnit_<?=$pro->proweb_prv_id?>" id="shipUnit_<?=$pro->proweb_prv_id?>" value="<?=$pro->prv_shippingunits?>" style="width:100%" />
                </td>
                <td class="price item-total">
                    <input type="textbox" name="shipWeight_<?=$pro->proweb_prv_id?>" id="shipWeight_<?=$pro->proweb_prv_id?>" value="<?=$pro->prv_shippingweight?>" style="width:100%" />
                </td>
                <td class="price item-total">
                    <input type="textbox" name="shipDimension_<?=$pro->proweb_prv_id?>" id="shipDimension_<?=$pro->proweb_prv_id?>" value="<?=$pro->prv_shippingdimensions?>" style="width:100%" />
                </td>
                <td style="text-align:center;">
                    <img id="myTile_<?=$pro->proweb_prv_id?>" src="<?=$pro->prv_image?>" alt="<?= $product[0]->pro_name ?> <?=$pro->uni_name?>" width="300" height="200" style="display:none" />
                    <a href="javascript:viewTile(<?=$pro->proweb_prv_id?>)">View Tile </a>
                </td>
                <td>
                    <div class="form-group">
                        {!! Form::file('tile'.'_'.$pro->proweb_prv_id) !!}
                    </div>
                </td>
                <td style="text-align:left;">
                    <img id="myThumb_<?=$pro->proweb_prv_id?>" src="<?=$pro->prv_imagetile?>" alt="<?= $product[0]->pro_name ?> <?=$pro->uni_name?>" width="300" height="200" style="display:none" />
                    <a href="javascript:viewThumb(<?=$pro->proweb_prv_id?>)">View Thumbnail </a>
                </td>
                <td>
                    <div class="form-group">
                        {!! Form::file('thumb'.'_'.$pro->proweb_prv_id) !!}
                    </div>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
      </table>
    @else
        <table class="table" id="productvariationTable" name="productvariationTable">
        <thead>
            <tr>
                <th style="width:10%">Unit Size</th>
                <th style="width:10%">Colour</th>
                <th style="width:10%">Enabled</th>
                <th style="width:10%">Out of Stock</th>
                <th style="width:10%">Sell Price</th>
                <th style="width:10%">Shipping Units</th>
                <th style="width:10%">Shipping Weight</th>
                <th style="width:10%">Shipping Dimensions (.x.x.)</th>
                <th style="width:10%">&nbsp;</th>
                <th style="width:10%">New Tile</th>
                <th style="width:10%">&nbsp;</th>
                <th style="width:10%">New Thumbnails</th>
            </tr>
        </thead>
            <tbody>
               <tr id="row0">
                <td class="description">
                    <select class="form-control" name="unitsizes[]">
                        @foreach($unitsizes as $unitsize)
                        <option value="{{$unitsize->uni_id}}">{{$unitsize->uni_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="price item-unit">
                    <select class="form-control" name="colours[]">
                        @foreach($colours as $colour)
                        <option value="{{$colour->col_id}}">{{    $colour->col_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="quantity">
                    <input type="checkbox" name="chkAvailable[]" id="chkAvailable"/>
                </td>
                <td class="price item-total">
                    <input type="checkbox" name="outofStock[]" id="outofStock" />
                </td>
                <td class="price item-total">
                    <input type="textbox" name="txtPrice[]" id="txtPrice" value="" style="width:100%" />
                </td>
                <td class="price item-total">
                    <input type="textbox" name="shippingunits[]" id="txtPrice" value="" style="width:100%" />
                </td>
                <td class="price item-total">
                    <input type="textbox" name="shippingweight[]" id="txtPrice" value="" style="width:100%" />
                </td>
                <td class="price item-total">
                    <input type="textbox" name="shippingdimensions[]" id="txtPrice" value="" style="width:100%" />
                </td>
                <td style="text-align:center;">
                    <img id="myTile>" src="" alt="" width="300" height="200" style="display:none" />
                    <a href="javascript:viewTile()">View Tile </a>
                </td>
                <td>
                    <div class="form-group">
                        {!! Form::file('tile[]') !!}
                    </div>
                </td>
                <td style="text-align:left;">
                    <img id="myThumb" src="" alt="" width="300" height="200" style="display:none" />
                    <a href="javascript:viewThumb()">View Thumbnail </a>
                </td>
                <td>
                    <div class="form-group">
                        {!!Form::file('thumb[]') !!}
                    </div>
                </td>
            </tr>

            <tr id="row1"></tr>
            </tbody>
        </table>

    <a id="add_row" class="pull-left" style="cursor: pointer;">Add Row</a>

    <a id="delete_row" class="pull-right" style="cursor: pointer;">Delete Row</a>

    @endif

    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="text-align:right;">
            @if  (in_array('edit_products', $authRoles))
            <button type="button" class="btn btn-success" id="Edit">Edit</button>
            @endif
            <button type="button" class="btn btn-danger" onclick="window.location.href='/admin/products'">Cancel</button>
        </div>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01" />
        <div id="caption"></div>
    </div>

</section>

<script>
    $(document).ready(function () {
        $('#Edit').click(function () {
            $('#form').submit();
        })
    });
</script>

<script>
function viewTile(id)
{
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById('myTile_'+id);
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    modal.style.display = "block";
    modalImg.src = document.getElementById('myTile_' + id).src;
    captionText.innerHTML = document.getElementById('myTile_' + id).alt;
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }
}

function viewThumb(id) {
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById('myThumb_' + id);
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    modal.style.display = "block";
    modalImg.src = document.getElementById('myThumb_' + id).src;
    captionText.innerHTML = document.getElementById('myThumb_' + id).alt;

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }
}

$(document).ready(function () {
    var i = 1;
    $("#add_row").click(function () {
        $('#row' + i).html($('#row0').html());
        $('#productvariationTable').append('<tr id="row' + (i + 1) + '"></tr>');
        i++;
    });
    $("#delete_row").click(function () {
        if (i > 1) {
            $("#row" + (i - 1)).html('');
            i--;
        }
    });

});

</script>

@stop
