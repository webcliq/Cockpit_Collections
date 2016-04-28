<?php
 return array (
  'name' => 'string',
  'label' => 'Strings',
  '_id' => 'string56aa7fc5400be',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'reference',
      'label' => 'Reference',
      'type' => 'text',
      'info' => 'Unique Reference',
      'localize' => false,
      'options' => array (
        'className' => 'unique nextref',
        'default' => 'str(0)',
        'required' => true,
      ),
      'width' => '1-3',
      'lst' => true,
      'required' => true,
    ),
    1 => 
    array (
      'name' => 'common',
      'label' => 'Common',
      'type' => 'text',
      'default' => '',
      'info' => 'Common text or meaning',
      'localize' => false,
      'options' => 
      array (
        'placeholder' => 'Common',
        'required' => true,
      ),
      'width' => '2-3',
      'lst' => true,
      'required' => true,
    ),
    2 => 
    array (
      'name' => 'text',
      'label' => 'String Text',
      'type' => 'textarea',
      'default' => '',
      'info' => 'Multi-language text',
      'localize' => true,
      'options' => 
      array (
      ),
      'width' => '1-2',
      'lst' => false,
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'notes',
      'label' => 'Notes',
      'type' => 'textarea',
      'default' => '',
      'info' => 'Additional notes',
      'localize' => false,
      'options' => 
      array (
        'placeholder' => 'Language string',
        'orderable' => false
      ),
      'width' => '1-2',
      'lst' => true,
    ),
  ),
  'sortable' => true,
  'in_menu' => true,
  '_created' => 1458918858,
  '_modified' => 1460562731,
  'description' => 'Language Strings',
  'options' => array (
    "fields" => array("_id", "reference","common","notes"),
    "menu" => array(
        "edit" => "Edit",
        "view" => "View",
        "delete" => "Delete"
    ),
    "topbuttons" => array(
      "add", "copy", "csv", "excel", "pdf", "print", "help", "reset"
    ),
    "buttons" => "treetable,datatable,pageable"
  )
);
  