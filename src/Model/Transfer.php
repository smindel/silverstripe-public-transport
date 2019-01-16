<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;

class Transfer extends DataObject
{
    private static $table_name = 'Transfer';

    private static $file_name = 'transfers';

    private static $db = [
        'TransferType' => "Enum('0,1,2,3')",
        'MinTransferTime' => 'Int',
    ];

    private static $has_one = [
        'FromStop' => Stop::class,
        'ToStop' => Stop::class,
    ];

    private static $summary_fields = [
        'FromStop.StopId' => 'FromStopId',
        'ToStop.StopId' => 'ToStopId',
    ];

    private static $field_descriptions = [
        'FromStop' => 'A stop ID that identifies a stop or station where a connection between routes begins. Stop IDs are referenced from the stops.txt file. If the stop ID refers to a station that contains multiple stops, this transfer rule applies to all stops in that station.',
        'ToStop' => 'A stop ID that identifies a stop or station where a connection between routes ends. Stop IDs are referenced from the stops.txt file. If the stop ID refers to a station that contains multiple stops, this transfer rule applies to all stops in that station.',
        'TransferType' => 'Specifies the type of connection for the specified (from_stop_id, to_stop_id) pair.',
        'MinTransferTime' => 'When a connection between routes requires an amount of time between arrival and departure (transfer_type=2), the min_transfer_time field defines the amount of time that must be available in an itinerary to permit a transfer between routes at these stops. The min_transfer_time must be sufficient to permit a typical rider to move between the two stops, including buffer time to allow for schedule variance on each route. The min_transfer_time value must be entered in seconds, and must be a non-negative integer.',
    ];

    private static $required_fields = [
        'FromStop',
        'ToStop',
        'TransferType',
    ];

    private static $field_enums = [
        'TransferType' => [
            'This is a recommended transfer point between routes.',
            'This is a timed transfer point between two routes. The departing vehicle is expected to wait for the arriving one, with sufficient time for a passenger to transfer between routes.',
            'This transfer requires a minimum amount of time between arrival and departure to ensure a connection. The time required to transfer is specified by min_transfer_time.',
            'Transfers are not possible between routes at this location.',
        ],
    ];

    public function getName()
    {
        return $this->FromStop()->Name . ' -> ' . $this->ToStop()->Name;
    }

    public function getTitle()
    {
        return $this->Name;
    }
}
