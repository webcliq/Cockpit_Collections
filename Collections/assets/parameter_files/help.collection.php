<?php
 return array (
  'name' => 'help',
  'label' => 'Help',
  '_id' => 'help571e3d864c4f7',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'reference',
      'label' => 'Reference',
      'type' => 'text',
      'default' => '',
      'info' => 'Cross reference to Help page',
      'localize' => false,
      'options' => 
      array (
        'placeholder' => 'Table name',
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
      'type' => 'wysiwyg',
      'default' => '',
      'info' => 'Multi-language text',
      'localize' => false,
      'options' => 
      array (
      ),
      'width' => '1-1',
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
        'placeholder' => 'Notes about Help entry',
        'orderable' => false,
      ),
      'width' => '1-1',
      'lst' => true,
    ),
  ),
  'sortable' => true,
  'in_menu' => true,
  '_created' => 1461599622,
  '_modified' => 1461608352,
  'description' => 'Help for the admin system',
  'options' => 
  array (
    'fields' => 
    array (
      0 => '_id',
      1 => 'reference',
      2 => 'common',
      3 => 'notes',
    ),
    'menu' => 
    array (
      'edit' => 'Edit',
      'delete' => 'Delete',
    ),
    'topbuttons' => 
    array (
      0 => 'add',
      1 => 'copy',
      2 => 'csv',
      3 => 'excel',
      4 => 'pdf',
      5 => 'print',
      6 => 'help',
      7 => 'reset',
    ),
    'buttons' => 'treetable,datatable,pageable',
  ),
);