<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;

class Agency extends DataObject
{
    private static $table_name = 'Agency';

    private static $db = [
        'AgencyId' => 'Varchar',
        'AgencyName' => 'Varchar',
        'AgencyUrl' => 'Varchar',
        'AgencyTimezone' => 'Varchar',
        'AgencyLang' => 'Varchar',
        'AgencyPhone' => 'Varchar',
        'AgencyFareUrl' => 'Varchar',
        'AgencyEmail' => 'Varchar',
    ];

    private static $indexes = array(
        'AgencyId' => true,
    );

    private static $has_many = [
        'Routes' => Route::class,
    ];

    private static $summary_fields = [
        'AgencyId',
        'AgencyName',
    ];

    private static $field_descriptions = [
        'AgencyId' => 'An ID that uniquely identifies a transit agency. A transit feed may represent data from more than one agency. This field is optional for transit feeds that only contain data for a single agency.',
        'AgencyName' => 'The full name of the transit agency. Google Maps will display this name.',
        'AgencyUrl' => 'The URL of the transit agency',
        'AgencyTimezone' => 'The timezone where the transit agency is located. If multiple agencies are specified in the feed, each must have the same agency_timezone.',
        'AgencyLang' => 'A language code specifying the primary language used by this transit agency. This setting helps GTFS consumers choose capitalization rules and other language-specific settings for the feed.',
        'AgencyPhone' => 'A single voice telephone number for the specified agency. This field is a string value that presents the telephone number as typical for the agency\'s service area. It can and should contain punctuation marks to group the digits of the number. Dialable text (for example, TriMet\'s "503-238-RIDE") is permitted, but the field must not contain any other descriptive text.',
        'AgencyFareUrl' => 'Specifies the URL of a web page that allows a rider to purchase tickets or other fare instruments for that agency online.',
        'AgencyEmail' => 'A single valid email address actively monitored by the agency’s customer service department. This email address will be considered a direct contact point where transit riders can reach a customer service representative at the agency.',
    ];

    private static $required_fields = [
        'AgencyName',
        'AgencyUrl',
        'AgencyTimezone',
    ];

    public function getTitle()
    {
        return $this->Name;
    }
}
