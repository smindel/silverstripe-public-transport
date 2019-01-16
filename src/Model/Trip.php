<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;

class Trip extends DataObject
{
    private static $table_name = 'Trip';

    private static $file_name = 'trips';

    private static $db = [
        'TripId' => 'Varchar',
        'TripHeadsign' => 'Varchar',
        'TripShortName'	=> 'Varchar',
        'DirectionId' => 'Boolean',
        'WheelchairAccessible' => "Enum('0,1,2','0')",
        'BikesAllowed' => "Enum('0,1,2','0')",
    ];

    private static $indexes = array(
        'TripId' => true,
    );

    private static $has_one = [
        'Route' => Route::class,
        'Service' => Calendar::class,
        'Block' => Block::class,
        'Shape' => Shape::class,
    ];

    private static $has_many = [
        'StopTimes' => StopTime::class,
        'Frequencies' => Frequency::class,
    ];

    private static $summary_fields = [
        'TripId' => 'TripId',
        'TripHeadsign' => 'TripHeadsign',
        'TripShortName'	=> 'TripShortName',
        'Route.RouteId' => 'RouteId',
        'Service.ServiceId' => 'ServiceId',
        'Block.BlockId' => 'BlockId',
    ];

    private static $field_descriptions = [
        'TripId' => 'An ID that uniquely identifies a trip.',
        'RouteID' => 'An ID that uniquely identifies a route. This value is referenced from the routes.txt file.',
        'ServiceID' => 'An ID that uniquely identifies a set of dates when service is available for one or more routes. This value is referenced from the calendar.txt or calendar_dates.txt file.',
        'ShapeID' => 'An ID that defines a shape for the trip. This value is referenced from the shapes.txt file. The shapes.txt file allows you to define how a line should be drawn on the map to represent a trip.',
        'TripHeadsign' => 'The text that appears on a sign that identifies the trip\'s destination to passengers. Use this field to distinguish between different patterns of service in the same route. If the headsign changes during a trip, you can override the trip_headsign by specifying values for the stop_headsign field in stop_times.txt.',
        'TripShortName'	=> 'The text that appears in schedules and sign boards to identify the trip to passengers, for example, to identify train numbers for commuter rail trips. If riders do not commonly rely on trip names, please leave this field blank. A trip_short_name value, if provided, should uniquely identify a trip within a service day; it should not be used for destination names or limited/express designations.',
        'DirectionId' => 'A binary value that indicates the direction of travel for a trip. Use this field to distinguish between bi-directional trips with the same route_id. This field is not used in routing; it provides a way to separate trips by direction when publishing time tables. You can specify names for each direction with the trip_headsign field.',
        'BlockID' => 'Identifies the block to which the trip belongs. A block consists of a single trip or many sequential trips made using the same vehicle, defined by shared service day and block_id. A block_id can have trips with different service days, making distinct blocks.',
    ];

    private static $required_fields = [
        'RouteID',
        'ServiceID',
        'ShapeID',
    ];

    private static $field_enums = [
        'DirectionId' => ['Outbound travel', 'Inbound travel'],
        'WheelchairAccessible' => ['There is no accessibility information for the trip', 'The vehicle being used on this particular trip can accommodate at least one rider in a wheelchair', 'No riders in wheelchairs can be accommodated on this trip'],
        'BikesAllowed' => ['There is no bike information for the trip', 'The vehicle being used on this particular trip can accommodate at least one bicycle', 'No bicycles are allowed on this trip'],
     ];

    public function getTitle()
    {
        return $this->Name;
    }
}
