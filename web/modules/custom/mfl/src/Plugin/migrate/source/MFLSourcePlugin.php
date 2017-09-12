<?php

namespace Drupal\mfl\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SourcePluginBase;
use Drupal\migrate\Plugin\MigrationInterface;

/**
 * Provides a 'MFLSourcePlugin' migrate source.
 *
 * @MigrateSource(
 *  id = "mflsource_plugin"
 * )
 */
class MFLSourcePlugin extends SourcePluginBase {

  protected $mflOptions;

  protected $data;


  public function __construct(array $configuration, $plugin_id, $plugin_definition, \Drupal\migrate\Plugin\MigrationInterface $migration) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration);



  }

  public function fields() {
    // TODO: Implement fields() method.
  }

  public function __toString() {
    // TODO: Implement __toString() method.
  }

  public function getIds() {
    // TODO: Implement getIds() method.
  }

  protected function initializeIterator() {
    // TODO: Implement initializeIterator() method.
  }


}
