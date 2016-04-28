<?php
 return array (
  'name' => 'section',
  'label' => 'Sections',
  '_id' => 'section56aa01f55ceea',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'reference',
      'label' => 'Reference',
      'type' => 'text',
      'default' => '',
      'info' => 'Unique Reference',
      'localize' => false,
      'options' => 
      array (
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
      ),
      'width' => '2-3',
      'lst' => true,
      'required' => true,
    ),
    2 => 
    array (
      'name' => 'content',
      'label' => 'Content',
      'type' => 'wysiwyg',
      'default' => '',
      'info' => 'Multi-language text',
      'localize' => true,
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
      ),
      'width' => '1-1',
      'lst' => true,
    ),
  ),
  'sortable' => false,
  'in_menu' => true,
  '_created' => 1458918858,
  '_modified' => 1459875762,
  'description' => 'Page Sections',
);