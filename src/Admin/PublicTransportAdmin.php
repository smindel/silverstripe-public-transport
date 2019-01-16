<?php

namespace Smindel\PublicTransport\Admin;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\View\ArrayData;
use Smindel\GIS\Forms\GridFieldMap;
use Smindel\GIS\GIS;
use Smindel\PublicTransport\Model;

class PublicTransportAdmin extends ModelAdmin
{
    private static $url_segment = 'ptm';

    private static $menu_title = 'Public Transport';

    /**
     * This is also used by the importer, for which order matters, so be careful
     * before re-ordering.
     */
    private static $managed_models = [
        PublicTransportManager::class,
        Model\FeedInfo::class,
        Model\Agency::class,
        Model\Route::class,
        Model\Calendar::class,
        Model\CalendarDate::class,
        Model\Shape::class,
        Model\ShapePoint::class,
        Model\Block::class,
        Model\Trip::class,
        Model\Frequency::class,
        Model\Zone::class,
        Model\FareAttribute::class,
        Model\FareRule::class,
        Model\Stop::class,
        Model\Transfer::class,
        Model\StopTime::class,
    ];

    private static $allowed_actions = [
        'getEditForm',
        'doExport',
        'doCheck',
    ];

    public function getEditForm($id = NULL, $fields = NULL)
    {
        if ($this->modelClass == PublicTransportManager::class) return PublicTransportManager::create()->getForm();

        $form = parent::{__FUNCTION__}(...func_get_args());

        if (
            ($geometry = GIS::of($this->modelClass))
            && ($field = $form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass)))
            && ($this->modelClass)::get()->count() < 10000
        ) {
            $field->getConfig()->addComponent(new GridFieldMap($geometry));
        }

        return $form;
    }

    public function doExport($data, $form)
    {
        // var_dump(__METHOD__, func_get_args());die;
        $this->redirectBack();
    }

    public function doCheck($data, $form)
    {
        // var_dump(__METHOD__, func_get_args());die;
        $this->redirectBack();
    }
}
