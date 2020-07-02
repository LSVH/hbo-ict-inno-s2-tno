<?php

namespace TNO\ContactForm7\Views;

class Button
{
    public static function custom_essif_lab_form_tag_handler($attrs): string
    {
        $inputType = 'Submit';
        $inputValue = 'Gegevens inladen';
        $inputClass = 'wpcf7-form-control wpcf7-submit essif-lab';
        $inputName = $attrs['name'];
        $input = '<input name="' . $inputName . '" type="' . $inputType . '" value="' . $inputValue . '" class="' . $inputClass . '">';

        $style = '<style>
                  body .wpcf7 .essif-lab{width:100%;font-size:75%;padding:1%;}
                  body .wpcf7 input:disabled {background: rgba(239, 239, 239, 0.3);border-color: rgba(118, 118, 118, 0.3);cursor: not-allowed;}
                  </style>';

        return $input . $style;
    }
}
