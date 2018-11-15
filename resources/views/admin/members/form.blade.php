 @extends('admin.layouts.control')

@section('content')

{{Log::info($product)}}

<section class="products page">
    <div class="actionbar">
        <div class="header">
            <h3>Product Details</h3>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Product Information</h4>
                <div class="row">
                    <div class="col-md-6">Category </div>
                    <div class="col-md-6">
                        <?php echo $product[0]->cat_name ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Name </div>
                        <div class="col-md-6">{{ Form::text('tat_name', $product[0]->prt_pro_name, ['placeholder' => $product[0]->prt_pro_name, 'class' => 'form-control'])}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Slug </div>
                        <div class="col-md-6">{{ Form::text('tat_slug', $product[0]->prt_pro_slug, ['placeholder' => $product[0]->prt_pro_slug, 'class' => 'form-control'])}} </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Description </div>
                        <div class="col-md-6">{{ Form::textarea('tat_description', $product[0]->prt_pro_description, ['placeholder' => $product[0]->prt_pro_description, 'class' => 'form-control'])}} </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Variations</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table" id="productvariationTable">
                    <thead>
                        <tr>
                            <th>Unit Size</th>
                            <th>Colour</th>
                            <th>Enabled</th>
                            <th>Out of Stock</th>
                            <th>Sell Price</th>
                        </tr>
                    </thead>
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
                            <input type="checkbox" name="chkAvailable<?=$pro->proweb_id?>" id="chkAvailable<?=$pro->proweb_id?>" <?=($pro->proweb_available == 1)?'checked':''?> />
                        </td>
                        <td class="price item-total">
                            <input type="checkbox" name="outofStock<?=$pro->proweb_id?>" id="outofStock<?=$pro->proweb_id?>" <?=($pro->proweb_outofstock == 1)?'checked':''?> />
                        </td>
                        <td class="price item-total">
                            <input type="textbox" name="txtPrice<?=$pro->proweb_id?>" id="txtPrice<?=$pro->proweb_id?>" value="<?=$pro->proweb_price?>" />
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</section>

@stop
