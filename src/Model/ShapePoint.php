<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;
use Smindel\GIS\GIS;

class ShapePoint extends DataObject
{
    private static $table_name = 'ShapePoint';

    private static $file_name = 'shapes';

    private static $db = [
        'ShapePt' => 'Geometry',
        'ShapePtSequence' => 'Int',
        'ShapeDistTraveled' => 'Float',
    ];

    private static $has_one = [
        'Shape' => Shape::class,
    ];

    private static $summary_fields = [
        'Shape.ShapeId' => 'ShapeId',
        'ShapePtSequence' => 'Sequence',
    ];

    private static $field_descriptions = [
        'ShapePtSequence' => 'Associates the latitude and longitude of a shape point with its sequence order along the shape. The values for shape_pt_sequence must increase along the trip.',
        'ShapeDistTraveled' => 'When used in the shapes.txt file, the shape_dist_traveled field positions a shape point as a distance traveled along a shape from the first shape point. The shape_dist_traveled field represents a real distance traveled along the route in units such as feet or kilometers. This information allows the trip planner to determine how much of the shape to draw when showing part of a trip on the map. The values used for shape_dist_traveled must increase along with shape_pt_sequence: they cannot be used to show reverse travel along a route. The units used for shape_dist_traveled in the shapes.txt file must match the units that are used for this field in the stop_times.txt file.',
    ];

    private static $required_fields = [
        'ShapePt',
        'ShapePtSequence',
    ];

    public function getName()
    {
        $this->Shape()->ShapeId . ':' . $this->ShapePtSequence;
    }

    public function getTitle()
    {
        return $this->Name;
    }
}
