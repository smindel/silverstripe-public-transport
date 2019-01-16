<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;

class Calendar extends DataObject
{
    private static $table_name = 'Calendar';

    private static $file_name = 'calendar';

    private static $pseudo_key = 'Service';

    private static $db = [
        'ServiceId' => 'Varchar',
        'Monday' => 'Boolean',
        'Tuesday' => 'Boolean',
        'Wednesday' => 'Boolean',
        'Thursday' => 'Boolean',
        'Friday' => 'Boolean',
        'Saturday' => 'Boolean',
        'Sunday' => 'Boolean',
        'StartDate' => 'Date',
        'EndDate' => 'Date',
    ];

    private static $indexes = array(
        'ServiceId' => true,
    );

    private static $has_many = [
        'Trips' => Trip::class,
        'CalendarDates' => CalendarDate::class,
    ];

    private static $summary_fields = [
        'ServiceId',
    ];

    private static $required_fields = [
        'ServiceId',
        'StartDate',
        'EndDate',
    ];

    private static $field_descriptions = [
        'ServiceId' => 'An ID that uniquely identifies a set of dates when service is available for one or more routes. Each service_id value can appear at most once in a calendar.txt file. This value is dataset unique. It is referenced by the trips.txt file.',
        'Monday' => 'A binary value that indicates whether the service is valid for all Mondays.',
        'Tuesday' => 'A binary value that indicates whether the service is valid for all Tuesdays.',
        'Wednesday' => 'A binary value that indicates whether the service is valid for all Wednesdays.',
        'Thursday' => 'A binary value that indicates whether the service is valid for all Thursdays.',
        'Friday' => 'A binary value that indicates whether the service is valid for all Fridays.',
        'Saturday' => 'A binary value that indicates whether the service is valid for all Saturdays.',
        'Sunday' => 'A binary value that indicates whether the service is valid for all Sundays.',
        'StartDate' => 'The start date for the service.',
        'EndDate' => 'The end date for the service. This date is included in the service interval.',
    ];

    public function getTitle()
    {
        return $this->Name;
    }
}
