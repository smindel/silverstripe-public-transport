<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;

class FeedInfo extends DataObject
{
    private static $table_name = 'FeedInfo';

    private static $db = [
        'FeedPublisherName' => 'Varchar',
        'FeedPublisherUrl' => 'Varchar',
        'FeedLang' => 'Varchar',
        'FeedStartDate' => 'Date',
        'FeedEndDate' => 'Date',
        'FeedVersion' => 'Varchar',
        'FeedContactEmail' => 'Varchar',
        'FeedContactUrl' => 'Varchar',
    ];

    private static $summary_fields = [
        'FeedPublisherName',
    ];

    private static $field_descriptions = [
        'FeedPublisherName' => 'The full name of the organization that publishes the feed. (This may be the same as one of the agency_name values in agency.txt.) GTFS-consuming applications can display this name when giving attribution for a particular feed\'s data.',
        'FeedPublisherUrl' => 'The URL of the feed publishing organization\'s website. (This may be the same as one of the agency_url values in agency.txt).',
        'FeedLang' => 'A language code specifying the default language used for the text in this feed. This setting helps GTFS consumers choose capitalization rules and other language-specific settings for the feed.',
        'FeedStartDate' => 'The feed provides complete and reliable schedule information for service in the period from the beginning of the feed_start_date day to the end of the feed_end_date day. Both days can be left empty if unavailable. The feed_end_date date must not precede the feed_start_date date if both are given. Feed providers are encouraged to give schedule data outside this period to advise of likely future service, but feed consumers should treat it mindful of its non-authoritative status. If feed_start_date or feed_end_date extend beyond the active calendar dates defined in calendar.txt and calendar_dates.txt, the feed is making an explicit assertion that there is no service for dates within the feed_start_date or feed_end_date range but not included in the active calendar dates.',
        'FeedEndDate' => '(see above)',
        'FeedVersion' => 'The feed publisher can specify a string here that indicates the current version of their GTFS feed. GTFS-consuming applications can display this value to help feed publishers determine whether the latest version of their feed has been incorporated.',
        'FeedContactEmail' => 'An email address for communication regarding the GTFS dataset and data publishing practices. feed_contact_email is for a technical contact for GTFS-consuming applications. Provide customer service contact information through agency.txt.',
        'FeedContactUrl' => 'A URL for contact information, a web-form, support desk, or other tools for communication regarding the GTFS dataset and data publishing practices. feed_contact_url is for a technical contact for GTFS-consuming applications. Provide customer service contact information through agency.txt.',
    ];

    private static $required_fields = [
        'FeedPublisherName',
        'FeedPublisherUrl',
        'FeedLang',
    ];

    public function getTitle()
    {
        return $this->FeedPublisherName;
    }
}
