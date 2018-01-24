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

	public function __construct( Array $formData, Array $elements ){
		$this->formData = array_merge(
			[
				"method" => "post",
				"display" => "table",
				"action" => ""
			 ],
			$formData
		);
		$this->elements = $elements;
		$this->id = isset( $formData["id"] ) ? $formData["id"] :  rand (9,1000);
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
			$opts = $input = $hidden = $label = $attributes = "";


			//Extract key data from attributes
			$id = htmlspecialchars( $element["id"] );
			$name = htmlspecialchars( $element["name"] );
			$options = $element["options"] ;
			$wrapper = isset( $element["wrapper"] ) ? $element["wrapper"] : [] ;
			$default = htmlspecialchars( $element["default"] );
			$type = isset($element["type"]) ? htmlspecialchars( $element["type"] ) : "text";



			unset( 
				$element["id"],
				$element["name"],
				$element["options"],
				$element["type"],
				$element["wrapper"],
				$element["default"]
			);

			//Input ID
			$inputID = "DFF$this->id-$this->formNo-$id";

			//Create Attributes
			foreach( $element as $attr=> $val ){

				$val = htmlspecialchars( $val );

				if( gettype( $val )  === true ){
					$attributes .= "$attr=\"$attr\" ";
				}
				if( gettype( $val )  === false ){

				}
				else{
					$attributes .= "$attr=\"$val\" ";
				}
			}

			//Create Attributes
			$wrapper_attr = "";
			foreach( $wrapper as $attr=> $val ){

				$val = htmlspecialchars( $val );
				$wrapper_attr .= "$attr=\"$val\" ";
			}

			//Create options
			$label = "<label for=\"$inputID\">$name</label>";

			switch ( $type ) {
				case "textarea":
					$input = "<textarea id=\"$inputID\" name=\"$id\" value=\"$default\" $attributes></textarea>";
				break;
				case "select":
					foreach( $options as $key => $val ){
						if( is_numeric($key) ){
							$value = "";
						}
						else{
							$key = htmlspecialchars( $key );
							$value = "value=\"$key\"";
						}
						$opts .= "\n		<option $value>$val</option>";
					}
					$input = "<select id=\"$inputID\" name=\"$id\" $attributes value=\"$default\">$opts\n	</select>";

				break;
				case "radio":
				case "checkbox":
					foreach( $options as $key=>$val ){
						if( is_numeric( $key ) ){
							$val = htmlspecialchars( $val );
							$value = "value=\"$val\"";
						}
						else{
							$key = htmlspecialchars( $key );
							$value = "value=\"$key\"";
						}
						$input .= "\n<label><input type=\"$type\" name=\"$id\" $attributes $value/>$val</label>";
					}

				break;
				case "submit":
					$input = "<input type=\"submit\" name=\"$id\" value=\"$name\">";
					$label = "";
				break;
				case "custom":
					$input = $element["custom"];
					$label = "";
				break;
				default:
					$input = "<input id=\"$inputID\" type=\"$type\" name=\"$id\" $attributes value=\"$default\" />";

			}

			//Do not display hidden forms
			if( $type == "hidden" ){
				$hidden .= $input;
				continue;
			}

			switch ( $this->formData["display"] ){

				case "table":
					$output .=<<<INPUT
					<tr $wrapper_attr>
						<td class="DFForm-input-title">$label</td>
						<td class="DFForm-input-content">$input</td>
					</tr>
INPUT;
				break;

				default:
					$output .=<<<INPUT
					<div $wrapper_attr class="DFForm-input-wrap">
						$label
						<div>$input</div>
					</div>
INPUT;

			}

		}

		return [$output, $hidden ];
	}

	protected function printOutput( $inputs ){

		$output = $inputs[0];
		$hidden = $inputs[1];

		$formData = $this->formData;
		$class = $formData["class"];
		
		unset( 
			$formData["id"],
			$formData["class"],
			$formData["class"]
		);

		foreach( $formData as $attr=>$val ){

			$val = htmlspecialchars( $val );
			$attributes .= "$attr='$val' ";
		}

		//HTML wrapper for all inputs
		$wrapper = ( $this->formData["display"] == "table" ) ? ["<table class='DFForm-table'>","</table>"] : ["",""];

		return "
		<form id='DFF$this->id-$this->formNo' class='DFForm $class' $attributes>
			$wrapper[0] $output $wrapper[1]
			$hidden
		</form>";
	}
 }
