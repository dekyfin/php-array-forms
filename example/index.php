<?php
 
require_once 'formsList.php';
require_once 'classes/Form.class.php';

$form = new Form($contact_form);
$form_html = $form->build();
?>

<!DOCTYPE html>
<html>
<head>
	<title>The index file</title>
</head>
<body>
<?php echo $form_html; ?>
</body>
</html>

