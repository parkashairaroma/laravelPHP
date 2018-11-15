<!-- Template -->
<html>
<body>
    <table border="0" cellpadding="5px" cellspacing="0" align="left" width="640px">
        <tr>
            <td colspan="4">Hi {{ $data['orderUserName'] }},</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-bottom:20px;">Thank you for shopping with Air Aroma. Your order has been received and will be processed shortly.</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top:20px;border-top:1px solid lightgrey;">Order Details:</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-left:20px;">Order Number: {{ $data['orderNumber'] }}</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-left:20px;padding-bottom:20px;">Date: {{$data['orderDate'] }}</td>
        </tr>
        <!-- DirectDepositPlaceholder -->
        <tr>
            <td colspan="2" style="padding-left:40px;">Payment Type: <?php
                                                                     switch($data['orderPaymentType'])
                                                                     {
                                                                         case "creditcard":
                                                                             echo "Credit Card";
                                                                             break;
                                                                         case "cod":
                                                                             echo "Cash on Delivery";
                                                                             break;
                                                                         case "directdeposit":
                                                                             echo "Direct Deposit";
                                                                             break;
                                                                         case "paypal":
                                                                             echo "Paypal";
                                                                             break;
                                                                         case "ApplePay":
                                                                             echo "Apple Pay";
                                                                             break;
                                                                        case "GooglePay":
                                                                            echo "Google Pay";
                                                                             break;
                                                                     }
                                                                     ?></td>
            <td colspan="2" style="padding-left:40px;padding-bottom:20px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-left:40px;">{{$data['orderPaymentDetails']}}</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top:20px;border-top:1px solid lightgrey;">Delivery Address:</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-left:20px;">{{ $data['orderFirstName'] }} {{ $data['orderLastName'] }}</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-left:20px;">{{$data['orderStreet'] }} {{$data['orderApt'] }}</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-left:20px;">{{ $data['orderCity'] }} {{ $data['orderPostCode'] }} {{ $data['orderState'] }}</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-left:20px;">{{ $data['orderCountry'] }}</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top:20px;border-top:1px solid lightgrey;">Customer Information:</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-left:20px;">{{ $data['orderFirstName'] }} {{ $data['orderLastName'] }}</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-left:20px;">{{ $data['orderEmail'] }}</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-left:20px;">{{ $data['orderPhone'] }}</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-left:20px;">{{$data['orderFax'] }}</td>
        </tr>
        <!--<td colspan="4" style="padding-top:20px;padding-bottom:40px;border-bottom:1px solid lightgrey;">Shipping via {{ $data['orderShippingMethod'] }}</td>-->
        </tr>
        <tr>
            <th style="width:250px;text-align:left;border-bottom:1px solid lightgrey;">Product</th>
            <th style="width:100px;text-align:left;border-bottom:1px solid lightgrey;">Price</th>
            <th style="width:100px;text-align:left;border-bottom:1px solid lightgrey;">Quantity</th>
            <th style="width:100px;text-align:left;border-bottom:1px solid lightgrey;">Total</th>
        </tr>
        @foreach ($data['orderProducts'] as $product)
        <tr>
            <td class="description">
                {{    $product['name'] }} {{ $product['unit']['name'] }} {{ $product['colour']['name'] }}
            </td>
            <td class="price item-unit">
                {{ $siteConfig['cur_symbol'] }}{{ $product['price'] }}
            </td>
            <td class="quantity">
                {{ $product['quantity'] }}
            </td>
            <td class="price item-total">
                {{ $siteConfig['cur_symbol'] }}{{ number_format($product['price'] * $product['quantity'], 2) }}
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" style="border-top:1px solid lightgrey">&nbsp;</td>
            <td style="border-top:1px solid lightgrey">Product Subtotal</td>
            <td style="border-top:1px solid lightgrey">{{ $siteConfig['cur_symbol'] }}{{$data['orderProductSubtotal']}}</td>
        </tr>
        @if ($data['orderVoucherCode'] != "")
        <tr>
            <td colspan="2">&nbsp;</td>
            <td>Voucher Code</td>
            <td>{{$data['orderVoucherCode']}}</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td>Voucher Discount</td>
            <td>{{ $siteConfig['cur_symbol'] }}{{$data['orderDiscount']}}</td>
        </tr>
        @endif
        @if ($data['orderShippingCost'] != 0)
        <tr>
            <td colspan="2">&nbsp;</td>
            <td>Shipping</td>
            <td>{{ $siteConfig['cur_symbol'] }}{{$data['orderShippingCost']}}</td>
        </tr>
        @endif
        @if ($data['orderSurchargeCost'] != 0)
        <tr>
            <td colspan="2">&nbsp;</td>
            <td>Credit Card Surcharge</td>
            <td>{{ $siteConfig['cur_symbol'] }}{{$data['orderSurchargeCost']}}</td>
        </tr>
        @endif
        @if ($data['orderTaxCost'] != 0)
        <tr>
            <td colspan="2">&nbsp;</td>
            <td>Included Tax</td>
            <td>{{ $siteConfig['cur_symbol'] }}{{$data['orderTaxCost']}}</td>
        </tr>
        @endif
        <tr>
            <td colspan="2" style="border-bottom:1px solid lightgrey">&nbsp;</td>
            <td style="border-bottom:1px solid lightgrey">Order Total</td>
            <td style="border-bottom:1px solid lightgrey">{{ $siteConfig['cur_symbol'] }}{{$data['orderTotalCost']}}</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top:20px;">
                Best Regards,<br />
                Air Aroma<br />
                <a href="<?= websiteUrl(); ?>" style=""><?= websiteUrl(); ?></a>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top:20px;">
                This transmission may be privileged and may contain confidential information intended only for the person(s) named above. Any other distribution, re-transmission, copying or disclosure is strictly prohibited. If you have received this transmission in error, please notify us immediately by telephone or email, and delete this file/message from your system.     
            </td>
        </tr>
    </table>
</body>
</html>
<!-- TemplateEnd -->
