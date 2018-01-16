<?php

namespace Drupal\meter_progress\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\meter_progress\Plugin\Field\FieldType\MeterProgressItem;
use Drupal\Component\Utility\Unicode;


/**
 * Contains field widget "meter_progress_default".
 *
 * @FieldWidget(
 *   id = "meter_progress_default",
 *   label = @Translation("Meter/Progress default"),
 *   field_types = {
 *     "meter_progress",
 *   }
 * )
 */
class MeterProgressDefaultWidget extends WidgetBase {

    /**
     * {@inheritdoc}
     */
    public function settingsSummary() {
        $summary = [];
        $summary[] = t('Field type: @type', array('@type' => $this->fieldDefinition->getSetting('type')));

        return $summary;
    }

    public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
        $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
        $element += [
            '#type' => 'textfield',
            '#default_value' => $value,
            '#size' => 7,
            '#maxlength' => 7,
        ];

        $elements = array();
        $elements['max'] = [
            '#type' => 'textfield',
            '#title' => t('Max'),
            '#default_value' => isset($items[$delta]->max) ? $items[$delta]->max : '',
            '#size' => 7,
            '#maxlength' => 7,
        ];
        if ($this->fieldDefinition->getSetting('type') === 'meter' ||
            $form_state->getBuildInfo()['form_id'] === 'field_config_edit_form') {
            foreach (MeterProgressItem::$meter_attributes as $attr) {
                $elements[$attr] = [
                    '#type' => 'textfield',
                    '#title' => t(Unicode::ucfirst($attr)),
                    '#default_value' => isset($items[$delta]->{$attr}) ? $items[$delta]->{$attr} : '',
                    '#size' => 7,
                    '#maxlength' => 7,
                    '#states' => array(
                        // Hide the settings when the progress type is selected.
                        'visible' => array(
                            ':input[name="settings[type]"]' => array('value' => 'meter'),
                        ),
                    ),
                ];
                if ($attr === 'form') {
                    $elements[$attr]['#size'] = 60;
                    $elements[$attr]['#maxlength'] = 60;
                }
            }
        }

        return ['value' => $element] + $elements;
    }

}