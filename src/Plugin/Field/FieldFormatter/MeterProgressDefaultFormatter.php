<?php

/**
 * @file
 * Contains \Drupal\meter_progress\Plugin\field\formatter\meter_progress_default.
 */

namespace Drupal\meter_progress\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'meter_progress_default' formatter.
 *
 * @FieldFormatter(
 *   id = "meter_progress_default",
 *   label = @Translation("Meter OR progress HTML5 Tag"),
 *   field_types = {
 *     "meter_progress"
 *   }
 * )
 */
class MeterProgressDefaultFormatter extends FormatterBase {

    /**
     * {@inheritdoc}
     */
    public function settingsSummary() {
        $summary = [];
        $summary[] = t('Displays HTML5 meter / progress tag.');

        return $summary;
    }

    /**
     * {@inheritdoc}
     */
    public function viewElements(FieldItemListInterface $items, $langcode) {

        $element = [];
        $max = $this->fieldDefinition->getSetting('max');

        foreach ($items as $delta => $item) {
            // Render each element as markup.
            $element[$delta] = array(
                '#type' => 'markup',
                '#markup' => $this->fieldDefinition->getSetting('type') === 'meter'
                    ? '<meter value="' . $item->value . '" max="' . $max . '"></meter>'
                    : '<progress value="' . $item->value . '" max="' . $max . '"></progress>',
            );
        }

        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public static function defaultSettings() {
        return [
            // Declare a setting with default value.
            'max' => '100',
        ] + parent::defaultSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function settingsForm(array $form, FormStateInterface $form_state) {
        $element['max'] = [
            '#title' => t('Max options value'),
            '#type' => 'string',
            '#default_value' => $this->getSetting('max'),
        ];

        return $element;
    }

}
