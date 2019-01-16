<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;

class StopTime extends DataObject
{
    private static $table_name = 'StopTime';

    private static $file_name = 'stop_times';

    private static $db = [
        'ArrivalTime' => 'Time',
        'DepartureTime' => 'Time',
        'StopSequence' => 'Int',
        'StopHeadsign' => 'Varchar',
        'PickupType' => "Enum('0,1,2,3','0')",
        'DropOffType' => "Enum('0,1,2,3','0')",
        'ShapeDistTraveled' => 'Float',
        'Timepoint' => "Enum(',0,1')",
    ];

    private static $has_one = [
        'Trip' => Trip::class,
        'Stop' => Stop::class,
    ];

    private static $summary_fields = [
        'Trip.TripId' => 'TripId',
        'Stop.StopId' => 'StopId',
        'StopHeadsign' => 'StopHeadsign',
        'ArrivalTime' => 'Arrival Time',
        'StopSequence' => 'Stop Sequence',
    ];

    private static $field_descriptions = [
        'TripID' => 'An ID that identifies a trip. This value is referenced from the trips.txt file.',
        'StopID' => 'An ID that uniquely identifies a stop. Multiple routes may use the same stop. The stop_id is referenced from the stops.txt file. If location_type is used in stops.txt, all stops referenced in stop_times.txt must have location_type of 0. Where possible, stop_id values should remain consistent between feed updates. In other words, stop A with stop_id 1 should have stop_id 1 in all subsequent data updates. If a stop is not a time point, enter blank values for arrival_time and departure_time.',
        'ArrivalTime' => 'The arrival_time specifies the arrival time at a specific stop for a specific trip on a route. The time is measured from "noon minus 12h" (effectively midnight, except for days on which daylight savings time changes occur) at the beginning of the service day. For times occurring after midnight on the service day, enter the time as a value greater than 24:00:00 in HH:MM:SS local time for the day on which the trip schedule begins. If you don\'t have separate times for arrival and departure at a stop, enter the same value for arrival_time and departure_time. Scheduled stops where the vehicle strictly adheres to the specified arrival and departure times are timepoints. For example, if a transit vehicle arrives at a stop before the scheduled departure time, it will hold until the departure time. If this stop is not a timepoint, use either an empty string value for the arrival_time field or provide an interpolated time. Further, indicate that interpolated times are provided via the timepoint field with a value of zero. If interpolated times are indicated with timepoint=0, then time points must be indicated with a value of 1 for the timepoint field. Provide arrival times for all stops that are time points. An arrival time must be specified for the first and the last stop in a trip.',
        'DepartureTime' => 'Specifies the departure time from a specific stop for a specific trip on a route. The time is measured from "noon minus 12h" (effectively midnight, except for days on which daylight savings time changes occur) at the beginning of the service day. For times occurring after midnight on the service day, enter the time as a value greater than 24:00:00 in HH:MM:SS local time for the day on which the trip schedule begins. If you don\'t have separate times for arrival and departure at a stop, enter the same value for arrival_time and departure_time. Scheduled stops where the vehicle strictly adheres to the specified arrival and departure times are timepoints. For example, if a transit vehicle arrives at a stop before the scheduled departure time, it will hold until the departure time. If this stop is not a timepoint, use either an empty string value for the departure_time field or provide an interpolated time (further, indicate that interpolated times are provided via the timepoint field with a value of zero). If interpolated times are indicated with timepoint=0, then time points must be indicated with a value of 1 for the timepoint field. Provide departure times for all stops that are time points. A departure time must be specified for the first and the last stop in a trip even if the vehicle does not allow boarding at the last stop.',
        'StopSequence' => 'Identifies the order of the stops for a particular trip. The values must increase along the trip. For example, the first stop on the trip could have a stop_sequence of 1, the second stop on the trip could have a stop_sequence of 23, the third stop could have a stop_sequence of 40, and so on.',
        'StopHeadsign' => 'The text that appears on a sign that identifies the trip\'s destination to passengers. Use this field to override the default trip_headsign when the headsign changes between stops. If this headsign is associated with an entire trip, use trip_headsign instead.',
        'PickupType' => 'Indicates whether passengers are picked up at a stop as part of the normal schedule or whether a pickup at the stop is not available. This field also allows the transit agency to indicate that passengers must call the agency or notify the driver to arrange a pickup at a particular stop.',
        'DropOffType' => 'Indicates whether passengers are dropped off at a stop as part of the normal schedule or whether a drop off at the stop is not available. This field also allows the transit agency to indicate that passengers must call the agency or notify the driver to arrange a drop off at a particular stop.',
        'ShapeDistTraveled' => 'When used in the stop_times.txt file, the shape_dist_traveled field positions a stop as a distance from the first shape point. The shape_dist_traveled field represents a real distance traveled along the route in units such as feet or kilometers. For example, if a bus travels a distance of 5.25 kilometers from the start of the shape to the stop, the shape_dist_traveled for the stop ID would be entered as "5.25". This information allows the trip planner to determine how much of the shape to draw when showing part of a trip on the map. The values used for shape_dist_traveled must increase along with stop_sequence: they cannot be used to show reverse travel along a route. The units used for shape_dist_traveled in the stop_times.txt file must match the units that are used for this field in the shapes.txt file.',
        'Timepoint' => 'Can be used to indicate if the specified arrival and departure times for a stop are strictly adhered to by the transit vehicle or if they are instead approximate and/or interpolated times. The field allows a GTFS producer to provide interpolated stop times that potentially incorporate local knowledge, but still indicate if the times are approximate.',
    ];

    private static $required_fields = [
        'TripID',
        'StopID',
        'ArrivalTime',
        'DepartureTime',
        'StopSequence',
    ];

    private static $field_enums = [
        'PickupType' => ['Regularly scheduled pickup', 'No pickup available', 'Must phone agency to arrange pickup', 'Must coordinate with driver to arrange pickup'],
        'DropOffType' => ['Regularly scheduled drop off', 'No drop off available', 'Must phone agency to arrange drop off', 'Must coordinate with driver to arrange drop off'],
        'Timepoint' => ['Times are considered approximate.', 'Times are considered exact.'],
    ];

     public function getName()
     {
         return $this->Trip()->Name . ':' . $this->StopSequence;
     }

     public function getTitle()
     {
         return $this->Name;
     }
}
