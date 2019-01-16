<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;

class FareAttribute extends DataObject
{
    private static $table_name = 'FareAttribute';

    private static $file_name = 'fare_attributes';

    private static $pseudo_key = 'Fare';

    private static $db = [
        'FareId' => 'Varchar',
        'Price' => 'Float',
        'CurrencyType' => 'Varchar',
        'PaymentMethod' => "Enum('0,1')",
        'Transfers' => "Enum(',0,1,2')",
        'TransferDuration' => 'Int',
    ];

    private static $indexes = array(
        'FareId' => true,
    );

    private static $has_one = [
        'Agency' => Agency::class,
    ];

    private static $has_many = [
        'FareRules' => FareRules::class,
    ];

    private static $summary_fields = [
        'FareId',
        'Price',
    ];

    private static $field_descriptions = [
        'FareId' => 'An ID that uniquely identifies a fare class. The fare_id is dataset unique.',
        'AgencyID' => 'Required for feeds with multiple agencies defined in the agency.txt file. Each fare attribute must specify an agency_id value to indicate which agency the fare applies to.',
        'Price' => 'The fare price, in the unit specified by currency_type.',
        'CurrencyType' => 'Defines the currency used to pay the fare.',
        'PaymentMethod' => 'Indicates when the fare must be paid.',
        'Transfers' => 'Specifies the number of transfers permitted on this fare.',
        'TransferDuration' => 'Specifies the length of time in seconds before a transfer expires. When used with a transfers value of 0, the transfer_duration field indicates how long a ticket is valid for a fare where no transfers are allowed. Unless you intend to use this field to indicate ticket validity, transfer_duration should be omitted or empty when transfers is set to 0.'
    ];

    private static $required_fields = [
        'FareId',
        'Price',
        'CurrencyType',
        'PaymentMethod',
        'Transfers',
    ];

    private static $field_enums = [
        'PaymentMethod' => ['Fare is paid on board.', 'Fare must be paid before boarding.'],
        'Transfers' => ['No transfers permitted on this fare.', 'Passenger may transfer once.', 'Passenger may transfer twice.'],
    ];

    public function getTitle()
    {
        return $this->Name;
    }
}
