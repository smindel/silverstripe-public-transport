<?php

namespace Smindel\PublicTransport\Model;

use SilverStripe\ORM\DataObject;

class Block extends DataObject
{
    private static $table_name = 'Block';

    private static $file_name = false;

    private static $db = [
        'BlockId' => 'Varchar',
    ];

    private static $indexes = array(
        'BlockId' => true,
    );

    private static $has_many = [
        'Trips' => Trip::class,
    ];

    private static $summary_fields = [
        'BlockId',
    ];

    private static $field_descriptions = [
        'BlockId' => 'The block to which the trip belongs. A block consists of a single trip or many sequential trips made using the same vehicle, defined by shared service day and block_id. A block_id can have trips with different service days, making distinct blocks.',
    ];

    private static $required_fields = [
        'BlockId',
    ];

    public function getTitle()
    {
        return $this->Name;
    }
}
