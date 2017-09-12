<?php

namespace Drupal\mfl\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Player entities.
 */
class PlayerViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
