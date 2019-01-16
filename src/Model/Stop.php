<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use Smindel\GIS\GIS;

class Stop extends DataObject
{
    private static $table_name = 'Stop';

    private static $file_name = 'stops';

    private static $db = [
        'StopId' => 'Varchar',
        'StopCode' => 'Varchar',
        'StopName' => 'Varchar',
        'StopDesc' => 'Text',
        'Stop' => 'Geometry',
        'StopUrl' => 'Varchar',
        'LocationType' => "Enum('0,1,2','0')",
        'ParentStation' => 'Boolean',
        'StopTimezone' => 'Varchar',
        'WheelchairBoarding' => "Enum('0,1,2','0')",
    ];

    private static $indexes = array(
        'StopId' => true,
    );

    private static $has_one = [
        'Zone' => Zone::class,
    ];

    private static $has_many = [
        'StopTimes' => StopTime::class,
        'TransfersFrom' => Transfer::class . '.FromStop',
        'TransfersTo' => Transfer::class . '.ToStop',
    ];

    private static $summary_fields = [
        'StopId' => 'StopId',
        'StopCode' => 'StopCode',
        'StopName' => 'StopName',
        'Zone.ZoneId' => 'ZoneId',
    ];

    private static $field_descriptions = [
        'StopId' => 'An ID that uniquely identifies a stop, station, or station entrance. Multiple routes may use the same stop.',
        'StopCode' => 'Short text or a number that uniquely identifies the stop for passengers. Stop codes are often used in phone-based transit information systems or printed on stop signage to make it easier for riders to get a stop schedule or real-time arrival information for a particular stop. The stop_code field contains short text or a number that uniquely identifies the stop for passengers. The stop_code can be the same as stop_id if it is passenger-facing. This field should be left blank for stops without a code presented to passengers.',
        'StopName' => 'The name of a stop, station, or station entrance. Please use a name that people will understand in the local and tourist vernacular.',
        'StopDesc' => 'A description of a stop. Please provide useful, quality information. Do not simply duplicate the name of the stop.',
        'Stop' => 'Location of stop, station, or station entrance.',
        'ZoneID' => 'Defines the fare zone for a stop ID. Zone IDs are required if you want to provide fare information using fare_rules.txt. If this stop ID represents a station, the zone ID is ignored.',
        'StopUrl' => 'The URL of a web page about a particular stop. This should be different from the agency_url and the route_url fields.',
        'LocationType' => 'Identifies whether this stop ID represents a stop, station, or station entrance. If no location type is specified, or the location_type is blank, stop IDs are treated as stops. Stations may have different properties from stops when they are represented on a map or used in trip planning.',
        'ParentStation' => 'For stops that are physically located inside stations, the parent_station field identifies the station associated with the stop. To use this field, stops.txt must also contain a row where this stop ID is assigned location type=1.',
        'StopTimezone' => 'The timezone in which this stop, station, or station entrance is located. If omitted, the stop should be assumed to be located in the timezone specified by agency_timezone in agency.txt. When a stop has a parent station, the stop is considered to be in the timezone specified by the parent station\'s stop_timezone value. If the parent has no stop_timezone value, the stops that belong to that station are assumed to be in the timezone specified by agency_timezone, even if the stops have their own stop_timezone values. In other words, if a given stop has a parent_station value, any stop_timezone value specified for that stop must be ignored. Even if stop_timezone values are provided in stops.txt, the times in stop_times.txt should continue to be specified as time since midnight in the timezone specified by agency_timezone in agency.txt. This ensures that the time values in a trip always increase over the course of a trip, regardless of which timezones the trip crosses.',
        'WheelchairBoarding' => 'Identifies whether wheelchair boardings are possible from the specified stop, station, or station entrance.',
    ];

    private static $required_fields = [
        'StopId',
        'StopName',
        'Stop',
    ];

    private static $field_enums = [
        'LocationType' => [
            'Stop. A location where passengers board or disembark from a transit vehicle.',
            'Station. A physical structure or area that contains one or more stop.',
            'Station Entrance/Exit. A location where passengers can enter or exit a station from the street. The stop entry must also specify a parent_station value referencing the stop ID of the parent station for the entrance.',
        ],
        'ParentStation' => ['Yes', 'No'],
        'WheelchairBoarding' => [
            'there is no accessibility information for the stop',
            'at least some vehicles at this stop can be boarded by a rider in a wheelchair',
            'wheelchair boarding is not possible at this stop',
        ],
     ];

    public function getTitle()
    {
        return $this->Name;
    }
}
