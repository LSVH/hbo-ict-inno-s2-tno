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
        $inputClass = 'wpcf7-form-control wpcf7-submit essif-lab';
        $inputName = $attrs['name'];
        $input = '<input name="' . $inputName . '" type="' . $inputType . '" value="' . $inputValue . '" class="' . $inputClass . '">';

        $style = '<style>
                  body .essif-lab{width:100%;font-size:75%;padding:1%;}
                  input:disabled {background: rgba(239, 239, 239, 0.3);border-color: rgba(118, 118, 118, 0.3);cursor: not-allowed;}
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
