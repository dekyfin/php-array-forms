<?php

/**
 * ArrayForm Class
 *
 * Responsible for building forms
 * Usage
 *
 * @param array $elements renderable array containing form elements
 *
 * @return void
 */
namespace DF;

class ArrayForm {

	protected $elements;
	protected $formData = [];
	protected $formNo = 0;
	protected $id;

	public function __construct( $formData, $elements ){
		$this->formData = $formData;
		$this->elements = $elements;
		$this->id = rand (9,1000);
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
		var_dump( $this->elements, $this->formData );
	}
	
	/**
	 * Form class method to build a form from an array
	 * 
	 * 
	 * @return string $output contains the form as HTML
	 * 
	 */
	public function build() {

		// For multiple forms, create a counter.
		$this->formNo++;

		$input = $this->renderInputs();
		return $this->printOutput( $input );
	}

	protected function renderInputs(){

		// Loop through each form element and render it.
		foreach ($this->elements as $element ) {

			//Values to be reset for each input
			$opts = $input = $label = $attributes = "";


			//Extract key data from attributes
			$id = htmlspecialchars( $element["id"] );
			$name = htmlspecialchars( $element["name"] );
			$options = $element["options"] ;
			$default = htmlspecialchars( $element["default"] );
			$type = htmlspecialchars( $element["type"] );



			unset( 
				$element["id"],
				$element["name"],
				$element["options"],
				$element["type"],
				$element["default"]
			);

			//Input ID
			$inputID = "DFF$this->id-$this->formNo-$id";

			//Create Attributes
			foreach( $element as $attr=> $val ){

				$val = htmlspecialchars( $val );

				if( gettype( $val )  === true ){
					$attributes .= "$attr='$attr' ";
				}
				if( gettype( $val )  === false ){

				}
				else{
					$attributes .= "$attr='$val' ";
				}
			}

			//Create options
			switch ( $type ) {
				case 'textarea':
					$input = "<textarea id='$inputID' name='$id' value='$default' $attributes></textarea>";
				break;
				case "select":
					foreach( $options as $key => $val ){
						if( is_numeric($key) ){
							$value = "";
						}
						else{
							$key = htmlspecialchars( $key );
							$value = "value='$key'";
						}
						$opts .= "\n		<option $value>$val</option>";
					}
					$input = "<select id='$inputID' name='$id' $attributes value='$default'>$opts\n	</select>";

				break;
				case "radio":
				case "checkbox":
					foreach( $options as $key=>$val ){
						if( is_numeric( $key ) ){
							$val = htmlspecialchars( $val );
							$value = "value='$val'";
						}
						else{
							$key = htmlspecialchars( $key );
							$value = "value='$key'";
						}
						$input .= "\n<label><input type='$type' name='$id' $attributes $value/>$val</label>";
					}

				break;
				case 'submit':
					$input = '<input type="submit" name="' . $id . '" value="' . $name . '">';
					$label = '';
				break;
				default:
					$input = "<input id='$inputID' type='$type' name='$id' $attributes />";
				break;
			}

			switch ( $this->formData["display"] ){

				case "table":
					$output .=<<<INPUT
					<tr>
						<td class="DFForm-input-title"><label for="$inputID">$name</label></td>
						<td class="DFForm-input-content">$input</td>
					</tr>
INPUT;
				break;

				default:
					$output .=<<<INPUT
					<div class="DFForm-input">
						<div><label for="$inputID">$name</label></div>
						<div>$input</div>
					</div>
INPUT;

			}

		}

		return $output;
	}

	protected function printOutput( $output ){
		//HTML wrapper for all inputs
		$wrapper = ( $this->formData["display"] == "table" ) ? ["<table class='DFForm-table'>","</table>"] : ["",""];

		return "
		<form id='DFF$this->id-$this->formNo' class='DFForm'>
			$wrapper[0] $output $wrapper[1]
		</form>";
	}
 }
