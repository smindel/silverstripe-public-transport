<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;

class Frequency extends DataObject
{
    private static $table_name = 'Frequency';

    private static $file_name = 'frequencies';

    private static $db = [
        'StartTime' => 'Time',
        'EndTime' => 'Time',
        'HeadwaySecs' => 'Int',
        'ExactTimes' => "Enum('0,1,2,3')",
    ];

    private static $has_one = [
        'Trip' => Trip::class,
    ];

    private static $summary_fields = [
        'Trip.TripId' => 'TripId',
        'StartTime' => 'Start Time',
        'EndTime' => 'End Time',
    ];

    private static $field_descriptions = [
        'StartTime' => 'Specifies the time at which the first vehicle departs from the first stop of the trip with the specified frequency. The time is measured from "noon minus 12h" (effectively midnight, except for days on which daylight savings time changes occur) at the beginning of the service day. For times occurring after midnight, enter the time as a value greater than 24:00:00 in HH:MM:SS local time for the day on which the trip schedule begins.',
        'EndTime' => 'Indicates the time at which service changes to a different frequency (or ceases) at the first stop in the trip. The time is measured from "noon minus 12h" (effectively midnight, except for days on which daylight savings time changes occur) at the beginning of the service day. For times occurring after midnight, enter the time as a value greater than 24:00:00 in HH:MM:SS local time for the day on which the trip schedule begins.',
        'HeadwaySecs' => 'Indicates the time between departures from the same stop (headway) for this trip type, during the time interval specified by start_time and end_time. The headway value must be entered in seconds. Periods in which headways are defined (the rows in frequencies.txt) shouldn\'t overlap for the same trip, since it\'s hard to determine what should be inferred from two overlapping headways. However, a headway period may begin at the exact same time that another one ends.',
        'ExactTimes' => 'Determines if frequency-based trips should be exactly scheduled based on the specified headway information. The value of exact_times must be the same for all frequencies.txt rows with the same trip_id. If exact_times is 1 and a frequencies.txt row has a start_time equal to end_time, no trip must be scheduled. When exact_times is 1, care must be taken to choose an end_time value that is greater than the last desired trip start time but less than the last desired trip start time + headway_secs.',
    ];

    private static $required_fields = [
        'StartTime',
        'EndTime',
        'HeadwaySecs',
    ];

    private static $field_enums = [
        'ExactTimes' => ['Frequency-based trips are not exactly scheduled. This is the default behavior.', 'Frequency-based trips are exactly scheduled. For a frequencies.txt row, trips are scheduled starting with trip_start_time = start_time + x headway_secs for all x in (0, 1, 2, ...) where trip_start_time < end_time.'],
    ];
}
