# PHP ARRAY FORMS
A library that allows you to create HTML forms using PHP Arrays. The project was inspired by Titan Framework and uses the same format for generating elements
## INSTALLATION

### Composer
`composer require dekyfin/php-array-forms`

### Direct Install

##USAGE
-Include the `DF\ArrayForm` class
--Composer: `require_once "vendor/autoload.php"`
--Direct Install: `require_once "path/to/ArrayForm.php"`

### Example
```
#Attributes to be used for the form
$formData = [
	"action" => "/path/to/form/processor.php",
	"method" => "post",
	"class" => "my-special-form",
	"id" => "myForm",
	"display" => "table"
];
$elements = [
	[
		"id" => "email",
		"name" => "Email",
		"type" => "email"
		"required" => true,
	],
	[
		"id" => "pass",
		"name" => "Password",
		"type" => "password",
		"required" => true,
	],
	[
		"id" => "amount",
		"name" => "Amount",
		"type" => "number",
		"step" => "0.01",
		"min" => "3",
	],
	[
		"id" => "payment[method]",
		"name" => "Payment Method",
		"type" => "select",
		"options" => ["true", "false"],
	]
];


$form = DF\ArrayForm( $formData, $elements );
$html = $form->$build();

echo $html
```
## OPTIONS

## formData

## elements

