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

    /**
     * Get a list of versions of the current record.
     *
     * @return ArrayList
     */
    public function getVersions()
    {
        $record = $this->getRecord();
        $return = ArrayList::create();

        if ($record->hasExtension(Versioned::class)) {
            $versions = $record->Versions();

            foreach ($versions as $version) {
                $i = $version->Version;
                $diff = null;

                if ($i > 1) {
                    $frm = Versioned::get_version(
                        $record->ClassName,
                        $record->ID,
                        $i - 1
                    );
                    $to = Versioned::get_version(
                        $record->ClassName,
                        $record->ID,
                        $i
                    );
                    if ($frm && $to) {
                        $diff = DataDifferencer::create($frm, $to);
                        $diff->ignoreFields(["LastEdited"]);
                    }
                }

                $return->add(ArrayData::create(
                    [
                        "Version" => $version,
                        "Diff" => $diff
                    ]
                ));
            }
        }

        $this->extend("updateVersions", $versions);

        return $return;
    }
}
