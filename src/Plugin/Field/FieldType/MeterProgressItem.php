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

    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

        $properties = [];
        $output['columns']['max'] = array(
            'type' => 'varchar',
            'length' => 255,
        );

        return $properties;
    }

    public function isEmpty() {
        return FALSE;
    }

    /**
     * {@inheritdoc}
     */
    public static function schema(FieldStorageDefinitionInterface $field_definition) {
        return array(
            // columns contains the values that the field will store
            'columns' => array(
                // List the values that the field will save. This
                // field will only save a single value, 'value'
                'value' => array(
                    'type' => 'text',
                    'size' => 'tiny',
                    'not null' => FALSE,
                ),
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function defaultFieldSettings() {
        return array(
                // Declare a single setting, 'type', with a default
                // value of 'meter'
                'type' => 'meter',
                'max' => '100',
            ) + parent::defaultFieldSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function fieldSettingsForm(array $form, FormStateInterface $form_state) {

        $element = array();
        // The key of the element should be the setting name
        $element['type'] = array(
            '#title' => $this->t('Type'),
            '#type' => 'select',
            '#options' => array(
                'meter' => $this->t('Meter'),
                'progress' => $this->t('Progress'),
            ),
            '#default_value' => $this->getSetting('type'),
            '#weight' => -100,
        );

        $element['max'] = array(
            '#title' => $this->t('Max'),
            '#type' => 'textfield',
            '#default_value' => $this->getSetting('max'),
        );

        return $element;
    }

}
