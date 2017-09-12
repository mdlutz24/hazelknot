<?php

namespace Drupal\mfl;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface PlayerStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Player revision IDs for a specific Player.
   *
   * @param \Drupal\mfl\Entity\PlayerInterface $entity
   *   The Player entity.
   *
   * @return int[]
   *   Player revision IDs (in ascending order).
   */
  public function revisionIds(PlayerInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Player author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Player revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\mfl\Entity\PlayerInterface $entity
   *   The Player entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(PlayerInterface $entity);

  /**
   * Unsets the language for all Player with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
