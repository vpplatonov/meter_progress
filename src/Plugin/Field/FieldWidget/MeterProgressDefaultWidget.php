<?php

namespace Drupal\meter_progress\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;


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
        $summary[] = t('Field max: @max', array('@max' => $this->fieldDefinition->getSetting('max')));

        return $summary;
    }


    public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
        $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
        $element += [
            '#type' => 'textfield',
            '#default_value' => $value,
            '#size' => 7,
            '#maxlength' => 7,
            '#element_validate' => [
                [static::class, 'validate'],
            ],
        ];

        return ['value' => $element];

    }
}