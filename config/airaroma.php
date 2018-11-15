<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Air Aroma Specific Config Items
    |--------------------------------------------------------------------------
    |
    */

    /*
    | URL to be used to link to the AAOS API, to be used for accessing User and Location information.
    */
    'orders_api' => env('DEV_ORDERSAPI', 'http://api.air-aroma.com/api'),

    /*
    | Protocol and domain name to be used in emails when linking to images.
    */
    'email_image_server' => env('DEV_EMAILIMAGESERVER', 'http://emails.air-aroma.com'),

    /*
    * Admin Email
    */
    'admin_email' => 'administrator@air-aroma.com',

    /*
    *
    */

    'box_sixes' => [
        'small' => [
            'width' => 100,
            'length' => 100,
            'height' => 100,
            'weight' => 5000
        ],
        'medium' => [
            'width' => 200,
            'length' => 500,
            'height' => 200,
            'weight' => 10000
        ],
        'big' => [
            'width' => 200,
            'length' => 1050,
            'height' => 200,
            'weight' => 20000
        ],
    ],
    'banner_status' => [
        'names' => [
            0 => 'Disabled',
            1 => 'Enabled',
        ],
        'colours' => [
            0 => 'danger',
            1 => 'success',
        ],
    ],
    'client_status' => [
        'names' => [
            0 => 'Disabled',
            1 => 'Enabled',
        ],
        'colours' => [
            0 => 'danger',
            1 => 'success',
        ],
    ],
    'blog_status' => [
        'names' => [
            false => 'Private',
            true => 'Public',
        ],
        'colours' => [
            false => 'default',
            true => 'success',
        ],
    ],
    'blog_approval' => [
        'names' => [
            '0' => 'Draft',
            '1' => 'Submitted',
            '2' => 'Approved',
        ],
        'colours' => [
            '0' => 'info',
            '1' => 'danger',
            '2' => 'success',
        ],
    ],
    'website_status' => [
        'names' => [
            0 => 'Translating',
            1 => 'Enabled',
            2 => 'Disabled',
        ],
        'colours' => [
            0 => 'info',
            1 => 'success',
            2 => 'danger',
        ],
    ],
    'order_status' => [
        'names' => [
            1 => 'New',
            2 => 'Processing',
            3 => 'Cancelled',
            4 => 'Shipped',
            5 => 'Draft'
        ],
        'colours' => [
            1 => '#0082f5',
            2 => '#FFB353',
            3 => '#f70000',
            4 => '#2BC88D',
            5 => '#FF0000'
        ],
    ],
    'order_payment_status' => [
        'names' => [
            1 => 'Pending',
            2 => 'Failed',
            3 => 'Succeeded',
        ],
        'colours' => [
            1 => '#307895',
            2 => '#FFB353',
            3 => '#2BC88D',
            4 => '#2BC88D',
        ],
    ],
];