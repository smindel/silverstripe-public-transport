<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;

class Zone extends DataObject
{
    private static $table_name = 'Zone';

    private static $file_name = false;

    private static $db = [
        'ZoneId' => 'Varchar',
    ];

    private static $indexes = array(
        'ZoneId' => true,
    );

    private static $has_many = [
        'Stops' => Stop::class,
        'OriginFareRules' => FareRule::class . '.Origin',
        'DestinationFareRules' => FareRule::class . '.Destination',
        'ContainsFareRules' => FareRule::class . '.Contains',
    ];

    private static $summary_fields = [
        'ZoneId',
    ];

    private static $field_descriptions = [
        'ZoneId' => 'efines the fare zone for a stop ID. Zone IDs are required if you want to provide fare information using fare_rules.txt. If this stop ID represents a station, the zone ID is ignored.',
    ];

    private static $required_fields = [
        'ZoneId',
    ];

    public function getTitle()
    {
        return $this->Name;
    }
}
