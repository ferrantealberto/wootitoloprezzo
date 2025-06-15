/**
 * Salient WooCommerce Enhancer - Admin JavaScript
 * Version: 2.0.0
 */

(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        SalientAdmin.init();
    });

    // Main Admin Object
    var SalientAdmin = {
        
        // Initialize all functionality
        init: function() {
            this.initTabs();
            this.initColorPickers();
            this.initPreview();
            this.initFormValidation();
            this.initTooltips();
            this.initReset();
            this.bindEvents();
        },

        // Initialize tab functionality
        initTabs: function() {
            // Handle tab button clicks
            $('.salient-tab-button').on('click', function(e) {
                e.preventDefault();
                
                var targetTab = $(this).data('tab');
                
                // Remove active class from all buttons and content
                $('.salient-tab-button').removeClass('active');
                $('.salient-tab-content').removeClass('active');
                
                // Add active class to clicked button and corresponding content
                $(this).addClass('active');
                $('#tab-' + targetTab).addClass('active');
                
                // Save active tab to localStorage
                localStorage.setItem('salient_active_tab', targetTab);
                
                // Update preview if needed
                SalientAdmin.updatePreview();
            });
            
            // Restore active tab from localStorage
            var activeTab = localStorage.getItem('salient_active_tab');
            if (activeTab) {
                $('.salient-tab-button[data-tab="' + activeTab + '"]').click();
            }
        },

        // Initialize color pickers with enhanced functionality
        initColorPickers: function() {
            $('input[type="color"]').each(function() {
                var $colorInput = $(this);
                var $wrapper = $('<div class="salient-color-picker-wrapper"></div>');
                var $valueDisplay = $('<span class="salient-color-value">' + $colorInput.val() + '</span>');
                
                $colorInput.wrap($wrapper);
                $colorInput.after($valueDisplay);
                
                // Update value display when color changes
                $colorInput.on('input change', function() {
                    $valueDisplay.text($(this).val());
                    SalientAdmin.updatePreview();
                });
            });
        },

        // Initialize live preview functionality
        initPreview: function() {
            this.updatePreview();
            
            // Update preview when any form field changes
            $('input, select, textarea').on('input change', function() {
                clearTimeout(SalientAdmin.previewTimeout);
                SalientAdmin.previewTimeout = setTimeout(function() {
                    SalientAdmin.updatePreview();
                }, 300);
            });
        },

        // Update live preview
        updatePreview: function() {
            var $preview = $('.salient-preview-container');
            var $title = $preview.find('.salient-product-title');
            var $price = $preview.find('.salient-product-price');
            var $button = $preview.find('.salient-go-to-product');
            
            // Update title styles
            $title.css({
                'font-size': $('input[name="salient_woo_title_font_size_desktop"]').val() + 'px',
                'font-weight': $('select[name="salient_woo_title_font_weight"]').val(),
                'color': $('input[name="salient_woo_title_color"]').val(),
                'text-align': $('select[name="salient_woo_title_alignment"]').val(),
                'margin-bottom': $('input[name="salient_woo_title_margin_bottom"]').val() + 'px'
            });
            
            // Update price styles
            $price.css({
                'font-size': $('input[name="salient_woo_price_font_size_desktop"]').val() + 'px',
                'font-weight': $('select[name="salient_woo_price_font_weight"]').val(),
                'color': $('input[name="salient_woo_price_color"]').val(),
                'text-align': $('select[name="salient_woo_price_alignment"]').val(),
                'margin-bottom': $('input[name="salient_woo_price_margin_bottom"]').val() + 'px'
            });
            
            // Update button styles and text
            $button.text($('input[name="salient_woo_button_text"]').val()).css({
                'font-size': $('input[name="salient_woo_button_font_size_desktop"]').val() + 'px',
                'background-color': $('input[name="salient_woo_button_bg_color"]').val(),
                'color': $('input[name="salient_woo_button_text_color"]').val(),
                'border-radius': $('input[name="salient_woo_button_border_radius"]').val() + 'px',
                'padding': $('input[name="salient_woo_button_padding_vertical"]').val() + 'px ' + 
                          $('input[name="salient_woo_button_padding_horizontal"]').val() + 'px'
            });
            
            // Update container styles
            $preview.find('.salient-custom-product-info').css({
                'padding': $('input[name="salient_woo_container_padding"]').val() + 'px 0',
                'margin-top': $('input[name="salient_woo_container_margin_top"]').val() + 'px',
                'text-align': $('select[name="salient_woo_title_alignment"]').val()
            });
            
            // Update button container alignment
            $preview.find('.salient-button-container').css({
                'text-align': $('select[name="salient_woo_button_alignment"]').val()
            });
        },

        // Initialize form validation
        initFormValidation: function() {
            // Validate number inputs
            $('input[type="number"]').on('input', function() {
                var $input = $(this);
                var min = parseInt($input.attr('min')) || 0;
                var max = parseInt($input.attr('max')) || 9999;
                var value = parseInt($input.val()) || min;
                
                if (value < min) {
                    $input.val(min);
                } else if (value > max) {
                    $input.val(max);
                }
                
                // Add visual feedback
                $input.removeClass('error');
                if (value < min || value > max) {
                    $input.addClass('error');
                }
            });
            
            // Validate breakpoints
            $('input[name="salient_woo_mobile_breakpoint"], input[name="salient_woo_tablet_breakpoint"]').on('change', function() {
                var mobileBreakpoint = parseInt($('input[name="salient_woo_mobile_breakpoint"]').val());
                var tabletBreakpoint = parseInt($('input[name="salient_woo_tablet_breakpoint"]').val());
                
                if (mobileBreakpoint >= tabletBreakpoint) {
                    alert('Il breakpoint mobile deve essere inferiore al breakpoint tablet.');
                    $('input[name="salient_woo_mobile_breakpoint"]').val(Math.min(768, tabletBreakpoint - 100));
                }
            });
        },

        // Initialize tooltips
        initTooltips: function() {
            // Add tooltips to specific fields
            var tooltips = {
                'salient_woo_mobile_breakpoint': 'Dispositivi con larghezza inferiore a questo valore useranno gli stili mobile',
                'salient_woo_tablet_breakpoint': 'Dispositivi con larghezza inferiore a questo valore useranno gli stili tablet',
                'salient_woo_container_max_width': 'Larghezza massima del container come percentuale del contenitore padre',
                'salient_woo_button_border_radius': 'Raggio del bordo per angoli arrotondati (0 = angoli quadrati)',
                'salient_woo_custom_css': 'CSS personalizzato che verrà aggiunto dopo gli stili predefiniti'
            };
            
            $.each(tooltips, function(fieldName, tooltipText) {
                var $field = $('input[name="' + fieldName + '"], textarea[name="' + fieldName + '"]');
                if ($field.length) {
                    var $tooltip = $('<span class="salient-tooltip" data-tooltip="' + tooltipText + '"></span>');
                    $field.after($tooltip);
                }
            });
        },

        // Initialize reset functionality
        initReset: function() {
            // Add reset buttons to each tab
            $('.salient-tab-content').each(function() {
                var $tab = $(this);
                var tabId = $tab.attr('id').replace('tab-', '');
                
                if (tabId !== 'advanced') { // Don't add reset to advanced tab
                    var $resetSection = $('<div class="salient-reset-section">' +
                        '<p><strong>Reset Sezione:</strong> Ripristina tutte le impostazioni di questa sezione ai valori predefiniti.</p>' +
                        '<button type="button" class="salient-reset-button" data-section="' + tabId + '">Reset ' + 
                        $tab.find('h2').text() + '</button>' +
                        '</div>');
                    
                    $tab.find('.form-table').after($resetSection);
                }
            });
            
            // Handle reset button clicks
            $(document).on('click', '.salient-reset-button', function() {
                var section = $(this).data('section');
                
                if (confirm('Sei sicuro di voler ripristinare tutte le impostazioni di questa sezione?')) {
                    SalientAdmin.resetSection(section);
                }
            });
        },

        // Reset a specific section to defaults
        resetSection: function(section) {
            var defaults = {
                title: {
                    'salient_woo_title_font_size_desktop': '18',
                    'salient_woo_title_font_size_tablet': '16',
                    'salient_woo_title_font_size_mobile': '14',
                    'salient_woo_title_font_weight': '600',
                    'salient_woo_title_color': '#333333',
                    'salient_woo_title_alignment': 'center',
                    'salient_woo_title_margin_bottom': '8'
                },
                price: {
                    'salient_woo_price_font_size_desktop': '16',
                    'salient_woo_price_font_size_tablet': '14',
                    'salient_woo_price_font_size_mobile': '13',
                    'salient_woo_price_font_weight': '500',
                    'salient_woo_price_color': '#e74c3c',
                    'salient_woo_price_alignment': 'center',
                    'salient_woo_price_margin_bottom': '12'
                },
                button: {
                    'salient_woo_button_text': 'Vai al prodotto',
                    'salient_woo_button_font_size_desktop': '14',
                    'salient_woo_button_font_size_tablet': '13',
                    'salient_woo_button_font_size_mobile': '12',
                    'salient_woo_button_bg_color': '#3498db',
                    'salient_woo_button_text_color': '#ffffff',
                    'salient_woo_button_hover_bg_color': '#2980b9',
                    'salient_woo_button_border_radius': '4',
                    'salient_woo_button_padding_horizontal': '16',
                    'salient_woo_button_padding_vertical': '10',
                    'salient_woo_button_margin_left': '8',
                    'salient_woo_button_alignment': 'center'
                },
                container: {
                    'salient_woo_container_padding': '12',
                    'salient_woo_container_margin_top': '10',
                    'salient_woo_container_max_width': '100'
                },
                responsive: {
                    'salient_woo_mobile_breakpoint': '768',
                    'salient_woo_tablet_breakpoint': '1024',
                    'salient_woo_enable_responsive': '1'
                }
            };
            
            if (defaults[section]) {
                $.each(defaults[section], function(fieldName, defaultValue) {
                    var $field = $('input[name="' + fieldName + '"], select[name="' + fieldName + '"]');
                    
                    if ($field.is('input[type="checkbox"]')) {
                        $field.prop('checked', defaultValue === '1');
                    } else {
                        $field.val(defaultValue);
                    }
                    
                    // Trigger change event to update preview and color displays
                    $field.trigger('change');
                });
                
                // Show success message
                SalientAdmin.showNotice('Impostazioni della sezione ripristinate con successo!', 'success');
            }
        },

        // Bind additional events
        bindEvents: function() {
            // Handle form submission
            $('form').on('submit', function() {
                // Add loading state
                $(this).addClass('salient-loading');
                
                // Show processing message
                SalientAdmin.showNotice('Salvataggio in corso...', 'info');
            });
            
            // Handle responsive toggle
            $('input[name="salient_woo_enable_responsive"]').on('change', function() {
                var $responsiveFields = $('#tab-responsive input[type="number"]');
                
                if ($(this).is(':checked')) {
                    $responsiveFields.prop('disabled', false).removeClass('disabled');
                } else {
                    $responsiveFields.prop('disabled', true).addClass('disabled');
                }
            }).trigger('change');
            
            // Handle button hover preview
            $('.salient-preview-container .salient-go-to-product').on('mouseenter', function() {
                var hoverColor = $('input[name="salient_woo_button_hover_bg_color"]').val();
                $(this).css('background-color', hoverColor);
            }).on('mouseleave', function() {
                var normalColor = $('input[name="salient_woo_button_bg_color"]').val();
                $(this).css('background-color', normalColor);
            });
            
            // Auto-save draft functionality
            var autoSaveTimer;
            $('input, select, textarea').on('input change', function() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(function() {
                    SalientAdmin.autoSave();
                }, 5000); // Auto-save after 5 seconds of inactivity
            });
        },

        // Show admin notice
        showNotice: function(message, type) {
            type = type || 'info';
            
            var $notice = $('<div class="notice salient-notice ' + (type === 'error' ? 'error' : '') + '">' +
                '<p>' + message + '</p>' +
                '</div>');
            
            $('.wrap h1').after($notice);
            
            // Auto-remove notice after 3 seconds
            setTimeout(function() {
                $notice.fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        },

        // Auto-save functionality (saves to localStorage as draft)
        autoSave: function() {
            var formData = {};
            
            $('input, select, textarea').each(function() {
                var $field = $(this);
                var name = $field.attr('name');
                
                if (name && name.startsWith('salient_woo_')) {
                    if ($field.is('input[type="checkbox"]')) {
                        formData[name] = $field.is(':checked') ? '1' : '0';
                    } else {
                        formData[name] = $field.val();
                    }
                }
            });
            
            localStorage.setItem('salient_woo_draft', JSON.stringify(formData));
            
            // Show subtle indication of auto-save
            var $indicator = $('.wrap h1');
            $indicator.append(' <span class="salient-autosave-indicator" style="color: #666; font-size: 14px; font-weight: normal;">(salvato automaticamente)</span>');
            
            setTimeout(function() {
                $('.salient-autosave-indicator').fadeOut(function() {
                    $(this).remove();
                });
            }, 2000);
        },

        // Load draft from localStorage
        loadDraft: function() {
            var draft = localStorage.getItem('salient_woo_draft');
            
            if (draft && confirm('È stata trovata una bozza salvata automaticamente. Vuoi caricarla?')) {
                var formData = JSON.parse(draft);
                
                $.each(formData, function(fieldName, value) {
                    var $field = $('input[name="' + fieldName + '"], select[name="' + fieldName + '"], textarea[name="' + fieldName + '"]');
                    
                    if ($field.is('input[type="checkbox"]')) {
                        $field.prop('checked', value === '1');
                    } else {
                        $field.val(value);
                    }
                    
                    $field.trigger('change');
                });
                
                localStorage.removeItem('salient_woo_draft');
                SalientAdmin.showNotice('Bozza caricata con successo!', 'success');
            }
        },

        // Timeout reference for preview updates
        previewTimeout: null
    };

    // Load draft on page load
    $(window).on('load', function() {
        SalientAdmin.loadDraft();
    });

    // Export for potential external use
    window.SalientAdmin = SalientAdmin;

})(jQuery);