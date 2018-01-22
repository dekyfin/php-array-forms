<?php

/**
 * ArrayForm Class
 *
 * Responsible for building forms
 *
 * @param array $elements renderable array containing form elements
 *
 * @return void
 */
namespace DF;

class ArrayForm {

	public $elements;
	public $form_number = 1;

	public function __construct( $elements ){
	  $this->elements = $elements;
	}

	/**
	 * Form class method to dump object elements
	 * 
	 * The method just dumps the elements of the form passed to the instantiation.
	 * 
	 * @return void
	 * 
	 */
	public function dumpData() {
	  var_dump($this->elements);
	}
	
	/**
	 * Form class method to build a form from an array
	 * 
	 * 
	 * @return string $output contains the form as HTML
	 * 
	 */
	function build() {
		$output = '';

		// For multiple forms, create a counter.
		$this->form_number++;

		// Loop through each form element and render it.
		foreach ($this->elements as $name => $elements) {
		$label = '<label>' . $elements['title'] . '</label>';
		switch ($elements['type']) {
		  case 'textarea':
			 $input = '<textarea name="' . $name . '" ></textarea>';
			 break;
		  case 'submit':
			 $input = '<input type="submit" name="' . $name . '" value="' . $elements['title'] . '">';
			 $label = '';
			 break;
		  default:
			 $input = '<input type="' . $elements['type'] . '" name="' . $name . '" />';
			 break;
		}
		$output .= $label . '<p>' . $input . '</p>';
		}

		// Wrap a form around the inputs.
		$output = '
		<form action="' . $_SERVER['PHP_SELF'] . '" method="post">
		  <input type="hidden" name="action" value="submit_' . $this->form_number . '" />
		  ' . $output . '
		</form>';

		// Return the form.
		return $output;
	}
 }
