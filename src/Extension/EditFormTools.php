<?php

namespace Smindel\PublicTransport\Extension;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\OptionsetField;

class EditFormTools extends DataExtension
{
    public function getCMSValidator()
    {
        return RequiredFields::create(...$this->owner->config()->get('required_fields'));
    }

    public function updateCMSFields(FieldList $fields)
    {
        $enums = $this->owner->config()->get('field_enums');
        $required = $this->owner->config()->get('required_fields');
        $descriptions = $this->owner->config()->get('field_descriptions');
        $requireNote = false;
        foreach ($fields->dataFields() as $field) {
            if ($enums && array_key_exists($field->getName(), $enums)) {
                $fields->replaceField(
                    $field->getName(),
                    OptionsetField::create($field->getName(), $field->Title(), $enums[$field->getName()])
                );
            }
        }
        foreach ($fields->dataFields() as $field) {
            if ($required && array_search($field->getName(), $required) !== false) {
                $field->setTitle($field->Title() . '*');
                $requireNote = true;
            }
            if ($descriptions && array_key_exists($field->getName(), $descriptions)) {
                $field->setDescription($descriptions[$field->getName()]);
            }
        }
        foreach ($this->owner->config()->has_one as $name => $class) {
            if ($field = $fields->dataFieldByName($name . 'ID')) {
                $description = $field->getDescription();
                $classSlug = str_replace('\\', '-', $class);
                $description .= sprintf(
                    '<br><a onclick="document.location.href=\'admin/ptm/%1$s/EditForm/field/%1$s/item/\' + Form_ItemEditForm_%2$sID.value;">View %2$s</a>',
                    $classSlug,
                    $name
                );
                $field->setDescription($description);
            }
        }
        if ($requireNote) {
            $fields->unshift(LiteralField::create('RequiredNote', '<strong>* = required</strong><hr>'));
        }
    }

    public function getName()
    {
        $field = $this->owner->config()->pseudo_key ? $this->owner->config()->pseudo_key . 'Id' : $this->owner->config()->table_name . 'Id';
        return $this->owner->hasField($field) ? $this->owner->$field : $this->owner->ID;
    }
}
