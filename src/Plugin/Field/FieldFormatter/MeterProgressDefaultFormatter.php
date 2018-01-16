<?php

/**
 * @file
 * Contains \Drupal\meter_progress\Plugin\field\formatter\meter_progress_default.
 */

namespace Drupal\meter_progress\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Unicode;

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
        $settings = $this->fieldDefinition->getSettings();
        $max = $settings['max'];
        unset($settings['type'], $settings['max']);

        foreach ($items as $delta => $item) {
            // Render each element as markup.
            $type = $this->fieldDefinition->getSetting('type');
            $tag_props = 'value="' . $item->value . '" max="' . $max . '"';
            if ($type === 'meter') {
                foreach (array_values($settings) as $attr => $val) {
                    $tag_props .= ' ' . $attr . '="' . $val . '"';
                }
            }
            $element[$delta] = array(
                '#type' => 'markup',
                '#markup' => "<{$type} " . $tag_props . "></{$type}>",
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

}
