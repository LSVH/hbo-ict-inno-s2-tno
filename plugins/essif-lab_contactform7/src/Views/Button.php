<?php

namespace TNO\ContactForm7\Views;

class Button
{
<<<<<<< HEAD
<<<<<<< HEAD
	public static function custom_essif_lab_form_tag_handler(): string
	{
		$inputType = "Submit";
		$inputValue = "Gegevens inladen";
		$inputClass = "wpcf7-form-control wpcf7-submit essif-lab";

		return "<br /><input type=\"".$inputType."\" value=\"".$inputValue."\" class=\"".$inputClass."\">";
	}
=======
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
>>>>>>> 44a9692... Applying patch StyleCI
}
=======
    public static function custom_essif_lab_form_tag_handler($attrs) : string {
        $inputType = "Submit";
        $inputValue = "Gegevens inladen";
        $inputClass = "wpcf7-form-control wpcf7-submit essif-lab";
        $inputName = $attrs["name"];

        return "<br /><input name=\"" . $inputName . "\" type=\"" . $inputType . "\" value=\"" . $inputValue . "\" class=\"" . $inputClass . "\">";
    }
}
>>>>>>> 521d457... Changed hook to target, adjusted View for name/id
