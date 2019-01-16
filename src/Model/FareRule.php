<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;

class FareRule extends DataObject
{
    private static $table_name = 'FareRule';

    private static $file_name = 'fare_rules';

    private static $has_one = [
        'Fare' => FareAttribute::class,
        'Route' => Route::class,
        'Origin' => Zone::class,
        'Destination' => Zone::class,
        'Contains' => Zone::class,
    ];

    private static $summary_fields = [
        'Fare.FareId' => 'FareId',
        'Route.RouteId' => 'RouteId',
        'Origin.ZoneId' => 'OriginId',
        'Destination.ZoneId' => 'DestinationId',
        'Contains.ZoneId' => 'ContainsId',
    ];

    private static $field_descriptions = [
        'FareId' => 'An ID that uniquely identifies a fare class. This value is referenced from the fare_attributes.txt file.',
        'RouteID' => 'Associates the fare ID with a route. Route IDs are referenced from the routes.txt file. If you have several routes with the same fare attributes, create a row in fare_rules.txt for each route.',
        'OriginID' => 'Associates the fare ID with an origin zone ID. Zone IDs are referenced from the stops.txt file. If you have several origin IDs with the same fare attributes, create a row in fare_rules.txt for each origin ID.',
        'DestinationID' => 'Associates the fare ID with a destination zone ID. Zone IDs are referenced from the stops.txt file. If you have several destination IDs with the same fare attributes, create a row in fare_rules.txt for each destination ID.',
        'ContainsID' => 'Associates the fare ID with a zone ID, referenced from the stops.txt file. The fare ID is then associated with itineraries that pass through every contains_id zone.',
    ];

    private static $required_fields = [
        'FareID',
    ];
}
