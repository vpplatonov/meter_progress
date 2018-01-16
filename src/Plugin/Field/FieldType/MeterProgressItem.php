<?php

namespace Drupal\meter_progress\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Form\FormStateInterface;


/**
* Contains field type "meter_progress".
*
* @FieldType(
*   id = "meter_progress",
*   label = @Translation("Meter / Progress HTML5 Tag"),
*   description = @Translation("Custom meter/progress field."),
*   category = @Translation("HTML5 Tags"),
*   default_widget = "meter_progress_default",
*   default_formatter = "meter_progress_default",
* )
*/
class MeterProgressItem extends FieldItemBase implements FieldItemInterface {

    static $meter_attributes = array(
        // Attribute	Value	Description.
        'form',   //	form_id	Specifies one or more forms the <meter> element belongs to.
        'high',   //	number	Specifies the range that is considered to be a high value.
        'low',    //	number	Specifies the range that is considered to be a low value.
        'min',    // 	number	Specifies the minimum value of the range.
        'optimum',//    number	Specifies what value is the optimal value for the gauge.
    );

    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

        $properties = [];
        $properties['value'] = DataDefinition::create('string')->setLabel(t('Tag value'));
        $properties['max'] = DataDefinition::create('string')->setLabel(t('Max value'));
        foreach (MeterProgressItem::$meter_attributes as $attr) {
            $properties[$attr] = DataDefinition::create('string')->setLabel(t('@attr value', array('@attr' => $attr)));
        }

        return $properties;
    }

    public function isEmpty() {
        return FALSE;
    }

    /**
     * {@inheritdoc}
     */
    public static function schema(FieldStorageDefinitionInterface $field_definition) {
        $field_type_text =  array(
            'type' => 'text',
            'size' => 'tiny',
            'not null' => FALSE,
        );

        $columns = array();
        foreach (MeterProgressItem::$meter_attributes as $attr) {
            $columns[$attr] = $field_type_text;
        }

        return array(
            // Columns contains the values that the field will store.
            'columns' => array(
                // List the values that the field will save.
                // This field will only save a single value, 'value'.
                'value' => $field_type_text,
                'max' => $field_type_text,
            ) + $columns,
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function defaultFieldSettings() {
        return array(
                // Declare a single setting, 'type', with a default value of 'meter'.
                'type' => 'meter',
            ) + parent::defaultFieldSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function fieldSettingsForm(array $form, FormStateInterface $form_state) {

        $element = array();
        // The key of the element should be the setting name.
        $element['type'] = array(
            '#title' => $this->t('Type'),
            '#type' => 'select',
            '#options' => array(
                'meter' => $this->t('Meter'),
                'progress' => $this->t('Progress'),
            ),
            '#default_value' => $this->getSetting('type'),
        );

        return $element;
    }

}
