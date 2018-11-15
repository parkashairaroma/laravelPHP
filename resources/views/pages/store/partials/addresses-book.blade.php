<!-- Address List -->
<div class="{{$type }}-address-book address-table cart-summary">
	<div class="summary-header">
    	<h3>Address Book </h3>
    </div>
    <div class="container">
        <div class="content-block">
            <table class="address-book-style">
                <tr class="rowborder">
                    <th>Name</th>
                    <th>Address</th>
                    <th>Change</th>
                </tr>
                <?php
                    $count = 0;
                ?>
                @if ($accountAddresses->count())
                @foreach ($accountAddresses as $accountAddress)
                <?php $count++; ?>

                <?php
                    if ($type == 'shipping')
                    {
                        if ($count == $shippingdefault)
                        {
                ?>
                <tr class="rowborder rowselectbkg">
                    <?php
                        }
                        else
                        {
                    ?>
                    <tr class="rowborder">
                        <?php
                        }
                    }
                    else if ($type == 'billing')
                    {
                        if ($count == $billingdefault)
                        {
                        ?>
                        <tr class="rowborder rowselectbkg">
                            <?php
                        }
                        else
                        {
                            ?>
                            <tr class="rowborder">
                                <?php
                        }
                    }
                    else
                    {
                                ?>
                                <tr class="rowborder">
                                    <?php
                    }
                                    ?>
                                        <td>
                                            @if ($type == 'shipping')
                            @if     ($count == $shippingdefault)
                                            <input type="radio" name="addressbookAddress_shipping" id="addressbookAddress_shipping" value="{{ $accountAddress->add_id }}" class="ui-radio addressbookradio" checked />&nbsp; {{ $accountAddress->add_firstname }} {{    $accountAddress->add_lastname }}
                            @else
                                            <input type="radio" name="addressbookAddress_shipping" id="addressbookAddress_shipping" value="{{    $accountAddress->add_id }}" class="ui-radio addressbookradio" />&nbsp; {{ $accountAddress->add_firstname }} {{    $accountAddress->add_lastname }}
                            @endif
                        @elseif ($type == 'billing')
                            @if     ($count == $billingdefault)
                                            <input type="radio" name="addressbookAddress_billing" id="addressbookAddress_shipping" value="{{    $accountAddress->add_id }}" class="ui-radio addressbookradio" checked />&nbsp; {{ $accountAddress->add_firstname }} {{    $accountAddress->add_lastname }}
                            @else
                                            <input type="radio" name="addressbookAddress_billing" id="addressbookAddress_shipping" value="{{    $accountAddress->add_id }}" class="ui-radio addressbookradio" />&nbsp; {{ $accountAddress->add_firstname }} {{    $accountAddress->add_lastname }}
                            @endif
                        @else
                                            <input type="radio" name="addressbookAddress" id="addressbookAddress_shipping" value="{{    $accountAddress->add_id }}" class="ui-radio addressbookradio" />&nbsp; {{ $accountAddress->add_firstname }} {{ $accountAddress->add_lastname }}
                        @endif
                                        </td>
                                        <td>
                                            {{    $accountAddress->add_street }}, {{    $accountAddress->add_city }}
                                        </td>
                                        <td>
                                            <a href="/store/checkout/address/{{$type}}/{{    $accountAddress->add_id}}" class="edit-button" style="text-decoration: none;">Edit</a> | 
                                            <a href="/store/checkout/address/delete/{{    $accountAddress->add_id}}" class="edit-button" style="text-decoration: none;">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                @else
                                    <tr>
                                        <td colspan="4">No Addresses Found.</td>
                                    </tr>
                                    @endif
            </table>
        </div>
    </div>
    <br />
    <div class="container">

        <span class="button-icon button-icon-add" style="font-size: 25px; vertical-align: baseline;">+</span>
        <a href="#" class="add-newadd-button newaddress-edit edit-button" style="text-decoration: none;">
            Add a new address
        </a>
        <br /><br />
        <input type="hidden" value="{{$type}}-address-book" name="addressbookForm" />
        <button href="#" class="ui-button useaddress-{{$type }}-button">Use this address for {{$type }}</button>
        <br /><br />
    </div>
</div>

<script>
    $('.addressbookradio').click(function() {
        $(".rowborder").removeClass('rowselectbkg');
        $(this).closest( "tr" ).addClass('rowselectbkg');
    });
</script>


