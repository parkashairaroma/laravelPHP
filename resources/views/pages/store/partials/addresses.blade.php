<p class="'.$type.'-address">
    @if (session()->get('checkout.address.'.$type.'.businessname') == "")
    @else
    <span id="ord_business">{{session()->get('checkout.address.'.$type.'.businessname') }}</span>
    <br />
    @endif

    @if (session()->get('checkout.address.'.$type.'.firstname') == "" && session()->get('checkout.address.'.$type.'.lastname') == "")
    <span id="ord_firstname" style="opacity: 0.3;">First Name </span>
    <span id="ord_lastname" style="opacity: 0.3;">Last Name</span><br />
    @else
    <span id="ord_firstname">{{ session()->get('checkout.address.'.$type.'.firstname') }}</span> <span id="ord_lastname">{{ session()->get('checkout.address.'.$type.'.lastname') }}</span><br />
    @endif

    @if (session()->get('checkout.address.'.$type.'.street') == "")
    <span id="ord_street" style="opacity: 0.3;">Street </span>
    @else
    <span id="ord_street">{{session()->get('checkout.address.'.$type.'.street') }}</span>
    @endif

    @if (session()->get('checkout.address.'.$type.'.suite') == "")
    &nbsp;
    <br />
    @else
    <span id="ord_suite">{{ session()->get('checkout.address.'.$type.'.suite') }}</span>
    <br />
    @endif

    @if (session()->get('checkout.address.'.$type.'.city') == "" && session()->get('checkout.address.'.$type.'.postcode') == "")
    <span id="ord_city" style="opacity: 0.3;">City, </span>
    <span id="ord_postcode" style="opacity: 0.3;">Post Code</span>
    <br />
    @else
    <span id="ord_city">{{ session()->get('checkout.address.'.$type.'.city') }}</span>
    <span id="ord_postcode">{{ session()->get('checkout.address.'.$type.'.postcode') }}</span>
    <br />
    @endif

    @if (session()->get('checkout.address.'.$type.'.state_id') == "")
    <!--<span id="ord_state" style="opacity: 0.3;">State </span>-->
    
    @else
    <span id="ord_state">{{ isset($states[session()->get('checkout.address.'.$type.'.country_id')]) ? $states[session()->get('checkout.address.'.$type.'.country_id')][session()->get('checkout.address.'.$type.'.state_id')]['name'] : session()->get('checkout.address.'.$type.'.state_id') }}</span>
    <br />
    @endif

    @if (session()->get('checkout.address.'.$type.'.country_id') == "")
    <span id="ord_country_id" style="opacity: 0.3;">Country </span>
    <br />
    @else
    <span id="ord_country_id">{{ isset($countries[session()->get('checkout.address.'.$type.'.country_id')]) ? $countries[session()->get('checkout.address.'.$type.'.country_id')] : session()->get('checkout.address.'.$type.'.country_id') }}</span>
    <br />
    @endif


</p>