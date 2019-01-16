<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;

class CalendarDate extends DataObject
{
    private static $table_name = 'CalendarDate';

    private static $file_name = 'calendar_dates';

    private static $db = [
        'Date' => 'Date',
        'ExceptionType' => "Enum('0,1','0')",
    ];

    private static $has_one = [
        'Service' => Calendar::class,
    ];

    private static $summary_fields = [
        'Service.ServiceId' => 'ServiceId',
        'Date.Nice' => 'Date',
    ];

    private static $field_descriptions = [
        'Date' => 'Specifies a particular date when service availability is different than the norm. You can use the exception_type field to indicate whether service is available on the specified date.',
        'ExceptionType' => 'Indicates whether service is available on the date specified in the date field.',
        'ServiceID' => 'An ID that uniquely identifies a set of dates when a service exception is available for one or more routes. Each (service_id, date) pair can only appear once in calendar_dates.txt. If the a service_id value appears in both the calendar.txt and calendar_dates.txt files, the information in calendar_dates.txt modifies the service information specified in calendar.txt.',
    ];

    private static $required_fields = [
        'Date',
        'ExceptionType',
    ];

    private static $field_enums = [
        'ExceptionType' => ['service has been added for the specified date.', 'service has been removed for the specified date.'],
     ];

     public function getName()
     {
         return $this->Service()->Name . ':' . $this->Date;
     }

     public function getTitle()
     {
         return $this->Name;
     }
}
