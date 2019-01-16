<?php

namespace Smindel\PublicTransport\Admin;

use SilverStripe\Core\Injector\Injectable;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms;

class PublicTransportManager
{
    use Injectable;

    // play nice with ModelAdmin
    public function i18n_plural_name()
    {
        return 'Manager';
    }

    public function getForm()
    {
        $stats = ArrayList::create([]);
        foreach (PublicTransportAdmin::config()->get('managed_models') as $class) {
            if (!is_a($class, DataObject::class, true)) continue;

            $stats->push(ArrayData::create([
                'Class' => singleton($class)->i18n_plural_name(),
                'Count' => $class::get()->count()
            ]));
        }
        $config = new Forms\GridField\GridFieldConfig_Base();
        $config->getComponentByType(Forms\GridField\GridFieldDataColumns::class)
            ->setDisplayFields([
                'Class' => 'Class',
                'Count' => 'Count',
            ]);
        $fields = Forms\FieldList::create();
        $fields->push(Forms\GridField\GridField::create('Stats', 'Stats', $stats, $config));

        $actions = Forms\FieldList::create();
        $actions->push(Forms\FormAction::create('doExport', 'export GTFS'));
        $actions->push(Forms\FormAction::create('doCheck', 'check data'));

        $form = Forms\Form::create(
            Controller::curr(),
            'getEditForm',
            $fields,
            $actions
        );

        return $form;
    }
}
