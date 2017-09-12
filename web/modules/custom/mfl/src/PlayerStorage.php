<?php

namespace Drupal\mfl;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\mfl\Entity\PlayerInterface;

/**
 * Defines the storage handler class for Player entities.
 *
 * This extends the base storage class, adding required special handling for
 * Player entities.
 *
 * @ingroup mfl
 */
class PlayerStorage extends SqlContentEntityStorage implements PlayerStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(PlayerInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {player_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {player_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(PlayerInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {player_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('player_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
