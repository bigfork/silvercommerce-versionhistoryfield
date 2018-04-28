<?php

namespace SilverCommerce\VersionHistoryField\Forms;

use SilverStripe\ORM\ArrayList;
use SilverStripe\Core\ClassInfo;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\FormField;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Versioned\DataDifferencer;

class VersionHistoryField extends FormField
{
    /**
     * The dataobject that we want to se the version of
     * 
     * @var DataObject
     */
    protected $record;

    /**
     * Get record
     *
     * @return  DataObject
     */ 
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * Set record
     *
     * @param  DataObject  $record  The dataobject that we want to se the version of
     *
     * @return  self
     */ 
    public function setRecord(DataObject $record)
    {
        $this->record = $record;

        return $this;
    }

    /**
     * Construct this field
     * 
     * @return void
     */
    public function __construct($name, $title = null, DataObject $record)
    {
        $this->setRecord($record);

        parent::__construct($name, $title);
    }

    public function getVersions()
    {
        $record = $this->getRecord();
        $return = ArrayList::create();

        if ($record->hasExtension(Versioned::class)) {
            $versions = $record->AllVersions();

            foreach ($versions as $version) {
                $i = $version->Version;

                if ($i > 1) {
                    $add = false;
                    $frm = Versioned::get_version($record->ClassName, $record->ID, $i - 1);
                    $to = Versioned::get_version($record->ClassName, $record->ID, $i);
                    $diff = DataDifferencer::create($frm, $to);

                    // Only add if there was acctually a propper change
                    foreach ($diff->ChangedFields() as $change) {
                        if ($change->Name != "LastEdited") {
                            $return->add(ArrayData::create(
                                [
                                    "Version" => $version,
                                    "Diff" => $diff
                                ]
                            ));
                            break;
                        }
                    }
                }
            }
        }

        $this->extend("updateVersions", $versions);

        return $return;
    }
}
