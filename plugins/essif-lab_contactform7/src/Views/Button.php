<?php

namespace TNO\ContactForm7\Views;

class Button
{
	public static function custom_essif_lab_form_tag_handler($attrs): string
	{
		$inputType = "Submit";
		$inputValue = "Gegevens inladen";
		$inputClass = "wpcf7-form-control wpcf7-submit essif-lab";
		$inputName = $attrs["name"];

		return "<br /><input name=\"" . $inputName . "\" type=\"".$inputType."\" value=\"".$inputValue."\" class=\"".$inputClass."\">";
	}
}
