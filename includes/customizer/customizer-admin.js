(function($) {
    wp.customize.bind('ready', function() {
        
        // --- Slider Control ---
        $('.alsalam-slider-range').on('input change', function() {
            var val = $(this).val();
            $(this).siblings('.alsalam-slider-value').text(val);
            var settingId = $(this).attr('data-customize-setting-link');
            if(settingId) {
                wp.customize(settingId, function(setting) {
                    setting.set(val);
                });
            }
        });

        // --- Toggle Control ---
        // (Handled automatically by WP Customize if data-customize-setting-link is on the input checkbox)
        // Wait, the toggle has <?php $this->link(); ?> which outputs data-customize-setting-link. WP handles it.
        // Let's just make sure it changes the hidden value if we didn't use a checkbox. But we used a checkbox.

        // --- Repeater Control ---
        $('.alsalam-repeater-control').each(function() {
            var $control = $(this);
            var $input = $control.find('.alsalam-repeater-value');
            var $itemsContainer = $control.find('.alsalam-repeater-items');
            var fieldsJSON = $itemsContainer.attr('data-fields');
            var fields = fieldsJSON ? JSON.parse(fieldsJSON) : {};

            function updateRepeaterValue() {
                var data = [];
                $itemsContainer.find('.alsalam-repeater-item').each(function() {
                    var itemData = {};
                    $(this).find('[data-field]').each(function() {
                        var fieldId = $(this).attr('data-field');
                        itemData[fieldId] = $(this).val();
                    });
                    data.push(itemData);
                });
                $input.val(JSON.stringify(data)).trigger('change');
            }

            // Accordion toggle
            $itemsContainer.on('click', '.alsalam-repeater-item-header, .alsalam-repeater-item-toggle', function(e) {
                if($(e.target).hasClass('alsalam-repeater-item-remove')) return;
                var $content = $(this).closest('.alsalam-repeater-item').find('.alsalam-repeater-item-content');
                $content.toggleClass('active');
            });

            // Remove item
            $itemsContainer.on('click', '.alsalam-repeater-item-remove', function(e) {
                e.stopPropagation();
                if(confirm('Are you sure you want to remove this item?')) {
                    $(this).closest('.alsalam-repeater-item').remove();
                    updateRepeaterValue();
                }
            });

            // Input changes
            $itemsContainer.on('keyup change', 'input, textarea', function() {
                updateRepeaterValue();
            });

            // Add Item
            $control.find('.alsalam-repeater-add').on('click', function() {
                var itemHtml = '<div class="alsalam-repeater-item">';
                itemHtml += '<div class="alsalam-repeater-item-header"><span class="item-title">New Item</span><button type="button" class="alsalam-repeater-item-toggle">▼</button><button type="button" class="alsalam-repeater-item-remove">×</button></div>';
                itemHtml += '<div class="alsalam-repeater-item-content active">';
                
                $.each(fields, function(fieldId, field) {
                    itemHtml += '<div class="alsalam-repeater-field"><label><span class="customize-control-title">' + field.label + '</span>';
                    if (field.type === 'text' || field.type === 'url') {
                        itemHtml += '<input type="' + field.type + '" data-field="' + fieldId + '" value="" />';
                    } else if (field.type === 'textarea') {
                        itemHtml += '<textarea data-field="' + fieldId + '" rows="4"></textarea>';
                    } else if (field.type === 'image' || field.type === 'svg') {
                        itemHtml += '<div class="image-uploader">';
                        itemHtml += '<input type="hidden" data-field="' + fieldId + '" value="" />';
                        itemHtml += '<img src="" class="image-preview" style="display:none;" />';
                        itemHtml += '<button type="button" class="button alsalam-upload-button">Select Image</button>';
                        itemHtml += '<button type="button" class="button alsalam-remove-button" style="display:none;">Remove</button>';
                        itemHtml += '</div>';
                    }
                    itemHtml += '</label></div>';
                });

                itemHtml += '</div></div>';
                $itemsContainer.append(itemHtml);
                updateRepeaterValue();
            });

            // Media Uploader
            $itemsContainer.on('click', '.alsalam-upload-button', function(e) {
                e.preventDefault();
                var $button = $(this);
                var $wrapper = $button.closest('.image-uploader');
                var $input = $wrapper.find('input[type="hidden"]');
                var $preview = $wrapper.find('.image-preview');
                var $removeBtn = $wrapper.find('.alsalam-remove-button');

                var customUploader = wp.media({
                    title: 'Select Image',
                    button: { text: 'Use this image' },
                    multiple: false
                }).on('select', function() {
                    var attachment = customUploader.state().get('selection').first().toJSON();
                    $input.val(attachment.url).trigger('change');
                    $preview.attr('src', attachment.url).show();
                    $removeBtn.show();
                    updateRepeaterValue();
                }).open();
            });

            // Media Remove
            $itemsContainer.on('click', '.alsalam-remove-button', function(e) {
                e.preventDefault();
                var $wrapper = $(this).closest('.image-uploader');
                $wrapper.find('input[type="hidden"]').val('').trigger('change');
                $wrapper.find('.image-preview').attr('src', '').hide();
                $(this).hide();
                updateRepeaterValue();
            });

            // Sortable (requires jQuery UI Sortable, but keeping it simple. Let's try to enable it if available)
            if (typeof $.fn.sortable !== 'undefined') {
                $itemsContainer.sortable({
                    handle: '.alsalam-repeater-item-header',
                    update: function(event, ui) {
                        updateRepeaterValue();
                    }
                });
            }
        });
    });
})(jQuery);
