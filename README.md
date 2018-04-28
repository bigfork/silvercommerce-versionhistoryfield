# SilverStripe VersionHistoryField

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/silvercommerce/versionhistoryfield/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/silvercommerce/versionhistoryfield/?branch=1.0)

Simple field that lists changes made to an associated "Versioned" DataObject

Designed to be used with SilverCommerce Estimates, Invoices and contacts, but
should work equally well with any other DataObject

## Installing

Install via composer:

    composer require silvercommerce/versionhistoryfield

Then flush

## Usage

You can add this field to any form that represents a `DataObject` that uses
`Versioned`. It will output a simple list of changes. For example, to add to
`YourObject::getCMSFields()` use:

```
class YourDataObject extends DataObject
{
    ...

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab(
            "Root.History",
            VersionHistoryField::create(
                "History",
                _t("SilverCommerce\VersionHistoryField.History", "History"),
                $this
            )->addExtraClass("stacked") // make the field full width
        );

        return $fields;
    }

    ...
}
```