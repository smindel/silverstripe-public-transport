<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;
use Smindel\GIS\GIS;
use Smindel\GIS\Forms\MapField;

class Shape extends DataObject
{
    private static $table_name = 'Shape';

    private static $file_name = false;

    private static $db = [
        'ShapeId' => 'Varchar',
    ];

    private static $indexes = array(
        'ShapeId' => true,
    );

    private static $has_many = [
        'Trips' => Trip::class,
        'ShapePoints' => ShapePoint::class,
    ];

    private static $summary_fields = [
        'ShapeId',
    ];

    private static $field_descriptions = [
        'ShapeId' => 'An ID that uniquely identifies a shape.',
    ];

    private static $required_fields = [
        'ShapeId',
    ];

    public function getTitle()
    {
        return $this->Name;
    }

    public function getShape()
    {
        $line = [];
        foreach ($this->ShapePoints() as $point) {
            $line[] = GIS::ewkt_to_array($point->ShapePt)['coordinates'];
        }
        return GIS::array_to_ewkt($line, 4326);
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', MapField::create('Shape')->performReadonlyTransformation());
        return $fields;
    }
}
