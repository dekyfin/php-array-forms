<?php

/**
 * This files contains the list of forms defined
 * 
 */

// Renderable array with a form elements.
$contact_form = array(
  'name' => array(
    'title' => 'Name',
    'type' => 'text',
    'validations' => array('not_empty'),
  ),
  'email' => array(
    'title' => 'Email',
    'type' => 'email',
    'validations' => array('not_empty', 'is_valid_email'),
  ),
  'comment' => array(
    'title' => 'Comments',
    'type' => 'textarea',
    'validations' => array('not_empty'),
  ),
  'submit' => array(
    'title' => 'Submit me!',
    'type' => 'submit',
  ),
);
