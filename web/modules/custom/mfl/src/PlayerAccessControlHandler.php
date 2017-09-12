<?php

namespace Drupal\mfl;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Player entity.
 *
 * @see \Drupal\mfl\Entity\Player.
 */
class PlayerAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\mfl\Entity\PlayerInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished player entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published player entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit player entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete player entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add player entities');
  }

}
