<?php

namespace Smindel\PublicTransport\Control;

use SilverStripe\Control\Controller;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use Smindel\GIS\GIS;
use Smindel\PublicTransport\Admin\PublicTransportAdmin;

class PublicTransportController extends Controller
{
    private static $allowed_actions = [
        'import',
    ];

    public function import()
    {
        // ini_set('max_execution_time', 0);
        // ignore_user_abort(false);

        $zip = 'google-transit.zip';
        // $zip = 'sample-feed-1.zip';

        $models = PublicTransportAdmin::config()->managed_models;

        foreach ($models as $class) {

            if (!is_a($class, DataObject::class, true)) continue;

            DB::query(sprintf('TRUNCATE "%s"', $table = $class::config()->table_name));
            echo $table . " table truncated\n";

            // not a schema file
            if (!($name = $this->fileFromClass($class))) continue;

            $counter = $header = $useOrm = 0;
            $file = sprintf('zip://%s/%s#%s.txt', realpath(__DIR__ . '/../..'), $zip, $this->fileFromClass($class));
            if (!($handle = @fopen($file, 'r'))) {
                echo $table . " omitted from the import\n";
                continue;
            }

            while (($row = fgetcsv($handle))) {
                if (!$header) {
                    $headers = $this->snake_to_camel($row);
                    $header = '"' . implode('", "', $headers) . '"';
                    continue;
                }

                if (!count(array_filter($row))) {
                    echo 'Invalid ' . $table . ' record (' . implode(',', $row) . ")\n";
                    continue;
                }

                $inst = $class::create(array_combine(
                    array_slice($headers, 0, min(count($headers), count($row))),
                    array_slice($row, 0, min(count($headers), count($row)))
                ));
                if (!method_exists($inst, 'afterImport') || !$inst->afterImport()) {
                    foreach ($class::config()->db as $fieldName => $fieldType) {
                        if ($fieldType == 'Date' && $inst->$fieldName) {
                            $inst->$fieldName = substr($inst->$fieldName, 0, 4) . '-' . substr($inst->$fieldName, 4, 2) . '-' . substr($inst->$fieldName, 6, 2);
                        }
                    }
                    foreach ($class::config()->has_one as $relationName => $relationClass) {
                        $remoteName = $relationClass::config()->pseudo_key ? $relationClass::config()->pseudo_key . 'Id' : $relationClass::config()->table_name . 'Id';
                        $localReference = $relationName . 'Id';
                        $foreignKey = $relationClass::config()->pseudo_key ? $relationClass::config()->pseudo_key . 'ID' : $relationClass::config()->table_name . 'ID';
                        if (!$inst->$localReference) continue;
                        $relation = $relationClass::get()->filter($remoteName, $inst->$localReference)->first()
                            ?: $relationClass::create([$remoteName => $inst->$localReference]);
                        // if ($class == \Smindel\PublicTransport\Model\Trip::class && $relationClass == \Smindel\PublicTransport\Model\Calendar::class) {
                            // var_dump($relationClass, $remoteName, $localReference, $inst->$localReference, $relation->ID, $foreignKey);
                            // var_dump(sprintf(
                            //     '%s->%s = %s::get()->filter("%s", "%s")->first()->ID',
                            //     $class, $foreignKey,
                            //     $relationClass, $remoteName,
                            //     $inst->$localReference
                            // ));
                            // die;
                        // }
                        $inst->$foreignKey = $relation->ID ?: $relation->write();
                    }
                    if ($property = GIS::of($class)) {
                        $inst->$property = GIS::array_to_ewkt([$inst->{$property . 'Lon'}, $inst->{$property . 'Lat'}]);
                    }
                }
                $inst->write();

                if ($counter && !($counter % 100)) echo "\033[s" . $counter . ' ' . $table . " imported" . "\033[u";
                $counter++;
            }
            echo $counter . ' ' . $table . " imported\n";
        }
    }

    protected function fileFromClass($class)
    {
        return ($file = $class::config()->file_name) === null
            ? $this->camel_to_snake($class::config()->table_name)
            : $file;
    }

    protected function snake_to_camel($snake)
    {
        if (is_string($snake)) return implode(array_map('ucfirst', explode('_', $snake)));

        if (is_array($snake)) array_walk($snake, function (&$snake) { $snake = self::snake_to_camel($snake); });

        return $snake;
    }

    protected function camel_to_snake($camel)
    {
        if (is_string($camel)) return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $camel));

        if (is_array($camel)) array_walk($camel, function (&$camel) { $camel = self::camel_to_snake($camel); });

        return $camel;
    }
}
