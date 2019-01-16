<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;

class Route extends DataObject
{
    private static $table_name = 'Route';

    private static $file_name = 'routes';

    private static $db = [
        'RouteId' => 'Varchar',
        'RouteShortName' => 'Varchar',
        'RouteLongName' => 'Varchar',
        'RouteDesc' => 'Text',
        'RouteType' => "Enum('0,1,2,3,4,5,6,7','0')",
        'RouteUrl' => 'Varchar',
        'RouteColor' => 'Varchar',
        'RouteTextColor' => 'Varchar',
        'RouteSortOrder' => 'Int',
    ];

    private static $indexes = array(
        'RouteId' => true,
    );

    private static $has_one = [
        'Agency' => Agency::class,
    ];

    private static $has_many = [
        'Trips' => Trip::class,
    ];

    private static $summary_fields = [
        'RouteId',
        'RouteShortName',
        'RouteLongName',
    ];

    private static $field_descriptions = [
        'RouteId' => 'An ID that uniquely identifies a route.',
        'AgencyID' => 'Defines an agency for the specified route. This value is referenced from the agency.txt file. Use this field when you are providing data for routes from more than one agency.',
        'RouteShortName' => 'The short name of a route. This will often be a short, abstract identifier like "32", "100X", or "Green" that riders use to identify a route, but which doesn\'t give any indication of what places the route serves. At least one of route_short_name or route_long_name must be specified, or potentially both if appropriate. If the route does not have a short name, please specify a route_long_name and use an empty string as the value for this field.',
        'RouteLongName' => 'The full name of a route. This name is generally more descriptive than the route_short_name and will often include the route\'s destination or stop. At least one of route_short_name or route_long_name must be specified, or potentially both if appropriate. If the route does not have a long name, please specify a route_short_name and use an empty string as the value for this field.',
        'RouteDesc' => 'A description of a route. Please provide useful, quality information. Do not simply duplicate the name of the route. For example, "A trains operate between Inwood-207 St, Manhattan and Far Rockaway-Mott Avenue, Queens at all times. Also from about 6AM until about midnight, additional A trains operate between Inwood-207 St and Lefferts Boulevard (trains typically alternate between Lefferts Blvd and Far Rockaway)."',
        'RouteType' => 'Describes the type of transportation used on a route.',
        'RouteUrl' => 'The URL of a web page about that particular route. This should be different from the agency_url.',
        'RouteColor' => 'In systems that have colors assigned to routes, the route_color field defines a color that corresponds to a route. If no color is specified, the default route color is white (FFFFFF). The color difference between route_color and route_text_color should provide sufficient contrast when viewed on a black and white screen.',
        'RouteTextColor' => 'The route_text_color field can be used to specify a legible color to use for text drawn against a background of route_color. If no color is specified, the default text color is black (000000). The color difference between route_color and route_text_color should provide sufficient contrast when viewed on a black and white screen.',
        'RouteSortOrder' => 'The route_sort_order field can be used to order the routes in a way which is ideal for presentation to customers. It must be a non-negative integer. Routes with smaller route_sort_order values should be displayed before routes with larger route_sort_order values.',
    ];

    private static $required_fields = [
        'RouteId',
        'RouteType',
    ];

    private static $field_enums = [
        'RouteType' => [
            'Tram, Streetcar, Light rail. Any light rail or street level system within a metropolitan area.',
            'Subway, Metro. Any underground rail system within a metropolitan area.',
            'Rail. Used for intercity or long-distance travel.',
            'Bus. Used for short- and long-distance bus routes.',
            'Ferry. Used for short- and long-distance boat service.',
            'Cable car. Used for street-level cable cars where the cable runs beneath the car.',
            'Gondola, Suspended cable car. Typically used for aerial cable cars where the car is suspended from the cable.',
            'Funicular. Any rail system designed for steep inclines.',
        ],
     ];

    public function getTitle()
    {
        return $this->Name;
    }
}
