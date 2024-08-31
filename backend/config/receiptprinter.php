<?php

// return [
//     /*
//     |--------------------------------------------------------------------------
//     | Printer connector type
//     |--------------------------------------------------------------------------
//     |
//     | Connection protocol to communicate with the receipt printer.
//     | Valid values are: cups, network, windows
//     |
//     */
//     'connector_type' => 'windows',
//     /*
//     |--------------------------------------------------------------------------
//     | Printer connector descriptor
//     |--------------------------------------------------------------------------
//     |
//     | Typically printer name or IP address.
//     |
//     */
//     'connector_descriptor' => '',
//     /*
//     |--------------------------------------------------------------------------
//     | Printer port
//     |--------------------------------------------------------------------------
//     |
//     | Typically 9100.
//     |
//     */
//     'connector_port' => 9100,
// ];


return [
    'connector_type' => env('RECEIPTPRINTER_CONNECTOR_TYPE', 'windows'), // or 'network', 'usb', 'windows', etc.
    'connector_descriptor' => env('RECEIPTPRINTER_CONNECTOR_DESCRIPTOR', 'LPT1'), // or 'COM1', 'smb://computer/printer', etc.
];
