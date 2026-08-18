<?php
/**
 * AL-SALAM Customizer Controls
 *
 * Defines custom WP_Customize_Control classes for Repeaters, Toggles, and Sliders.
 */

if (!class_exists('WP_Customize_Control')) {
    return;
}

/**
 * Toggle Switch Control
 */
class Alsalam_Toggle_Control extends WP_Customize_Control {
    public $type = 'alsalam_toggle';

    public function render_content() {
        $value = $this->value() ? '1' : '0';
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php if (!empty($this->description)) : ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>
            <div class="alsalam-toggle-wrapper">
                <input type="checkbox" id="<?php echo esc_attr($this->id); ?>" class="alsalam-toggle-input" value="1" <?php checked($value, '1'); ?> <?php $this->link(); ?> />
                <label for="<?php echo esc_attr($this->id); ?>" class="alsalam-toggle-label"></label>
            </div>
        </label>
        <?php
    }
}

/**
 * Range Slider Control
 */
class Alsalam_Slider_Control extends WP_Customize_Control {
    public $type = 'alsalam_slider';
    public $choices = array(); // e.g. ['min' => 10, 'max' => 500, 'step' => 1]

    public function render_content() {
        $min = isset($this->choices['min']) ? $this->choices['min'] : 0;
        $max = isset($this->choices['max']) ? $this->choices['max'] : 100;
        $step = isset($this->choices['step']) ? $this->choices['step'] : 1;
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php if (!empty($this->description)) : ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>
            <div class="alsalam-slider-wrapper">
                <input type="range" class="alsalam-slider-range" min="<?php echo esc_attr($min); ?>" max="<?php echo esc_attr($max); ?>" step="<?php echo esc_attr($step); ?>" value="<?php echo esc_attr($this->value()); ?>" <?php $this->link(); ?> />
                <span class="alsalam-slider-value"><?php echo esc_html($this->value()); ?></span>
            </div>
        </label>
        <?php
    }
}

/**
 * Repeater Control
 * Stores data as JSON string.
 */
class Alsalam_Repeater_Control extends WP_Customize_Control {
    public $type = 'alsalam_repeater';
    public $fields = array(); // Array of field configurations

    public function render_content() {
        $values = json_decode($this->value(), true);
        if (!is_array($values)) {
            $values = array();
        }
        ?>
        <div class="alsalam-repeater-control">
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php if (!empty($this->description)) : ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>
            
            <input type="hidden" id="<?php echo esc_attr($this->id); ?>" class="alsalam-repeater-value" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>" />
            
            <div class="alsalam-repeater-items" data-fields="<?php echo esc_attr(json_encode($this->fields)); ?>">
                <?php foreach ($values as $index => $item_values) : ?>
                    <div class="alsalam-repeater-item">
                        <div class="alsalam-repeater-item-header">
                            <span class="item-title"><?php esc_html_e('Item', 'alsalam'); ?></span>
                            <button type="button" class="alsalam-repeater-item-toggle">▼</button>
                            <button type="button" class="alsalam-repeater-item-remove">×</button>
                        </div>
                        <div class="alsalam-repeater-item-content">
                            <?php foreach ($this->fields as $field_id => $field) : 
                                $current_value = isset($item_values[$field_id]) ? $item_values[$field_id] : '';
                            ?>
                                <div class="alsalam-repeater-field">
                                    <label>
                                        <span class="customize-control-title"><?php echo esc_html($field['label']); ?></span>
                                        <?php if ($field['type'] === 'text' || $field['type'] === 'url') : ?>
                                            <input type="<?php echo esc_attr($field['type']); ?>" data-field="<?php echo esc_attr($field_id); ?>" value="<?php echo esc_attr($current_value); ?>" />
                                        <?php elseif ($field['type'] === 'textarea') : ?>
                                            <textarea data-field="<?php echo esc_attr($field_id); ?>" rows="4"><?php echo esc_textarea($current_value); ?></textarea>
                                        <?php elseif ($field['type'] === 'image' || $field['type'] === 'svg') : ?>
                                            <div class="image-uploader">
                                                <img src="<?php echo esc_url($current_value); ?>" class="image-preview" style="<?php echo empty($current_value) ? 'display:none;' : 'max-width:100%; height:auto; margin-bottom:6px; display:block; border-radius:6px; border:1px solid #ccc;'; ?>" />
                                                <div style="display:flex; gap:6px; margin-bottom:6px;">
                                                    <button type="button" class="button alsalam-upload-button"><?php esc_html_e('Select Image', 'alsalam'); ?></button>
                                                    <button type="button" class="button alsalam-remove-button" style="<?php echo empty($current_value) ? 'display:none;' : ''; ?>"><?php esc_html_e('Remove', 'alsalam'); ?></button>
                                                </div>
                                                <input type="text" class="widefat image-url-input" data-field="<?php echo esc_attr($field_id); ?>" value="<?php echo esc_attr($current_value); ?>" placeholder="<?php esc_attr_e('Image URL', 'alsalam'); ?>" style="font-size:11px; font-family:monospace;" />
                                            </div>
                                        <?php endif; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button alsalam-repeater-add"><?php esc_html_e('Add Item', 'alsalam'); ?></button>
        </div>
        <?php
    }
}
