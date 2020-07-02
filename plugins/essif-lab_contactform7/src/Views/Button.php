<?php

namespace TNO\ContactForm7\Views;

class Button
{
    public static function custom_essif_lab_form_tag_handler($attrs): string
    {
        $inputType = 'Submit';
        $inputValue = 'Gegevens inladen';
        $baseClass = 'wpcf7-form-control essif-lab';
        $inputClassSubmit = $baseClass . ' submit';
        $inputClassCancel = $baseClass . ' reset';
        $inputName = $attrs['name'];
        $input = '<div class="essif-lab-container">
                  <input name="' . $inputName . '" type="' . $inputType . '" value="' . $inputValue . '" class="' . $inputClassSubmit . '">
                  <input name="' . $inputName . '" type="' . $inputType . '" value="X" class="' . $inputClassCancel . '">
                  </div>';

        $style = '<style>
                  body .wpcf7 .essif-lab-container{display:flex;}
                  body .wpcf7 .essif-lab{width:80%;font-size:75%;padding:1%;}
                  body .wpcf7 .essif-lab.reset {width: 20%; border:2px solid #000;}
                  body .wpcf7 input:disabled {background: rgba(239, 239, 239, 0.3);border-color: rgba(118, 118, 118, 0.3);cursor: not-allowed;}
                  </style>';

        return $input . $style;
    }
}
