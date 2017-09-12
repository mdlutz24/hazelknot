<?php

namespace Drupal\mfl\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Player entities.
 *
 * @ingroup mfl
 */
interface PlayerInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Player name.
   *
   * @return string
   *   Name of the Player.
   */
  public function getName();

  /**
   * Sets the Player name.
   *
   * @param string $name
   *   The Player name.
   *
   * @return \Drupal\mfl\Entity\PlayerInterface
   *   The called Player entity.
   */
  public function setName($name);

  /**
   * Gets the Player creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Player.
   */
  public function getCreatedTime();

  /**
   * Sets the Player creation timestamp.
   *
   * @param int $timestamp
   *   The Player creation timestamp.
   *
   * @return \Drupal\mfl\Entity\PlayerInterface
   *   The called Player entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Player published status indicator.
   *
   * Unpublished Player are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Player is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Player.
   *
   * @param bool $published
   *   TRUE to set this Player to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\mfl\Entity\PlayerInterface
   *   The called Player entity.
   */
  public function setPublished($published);

  /**
   * Gets the Player revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Player revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\mfl\Entity\PlayerInterface
   *   The called Player entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Player revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Player revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\mfl\Entity\PlayerInterface
   *   The called Player entity.
   */
  public function setRevisionUserId($uid);

}
