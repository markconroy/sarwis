<?php

namespace Drupal\sarwis;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining SARWIS Search Point entities.
 */
interface SarwisSearchPointInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Gets the search point name.
   *
   * @return string
   *   Name of the search point.
   */
  public function getName();

  /**
   * Sets the search point name.
   *
   * @param string $name
   *   The search point name.
   *
   * @return \Drupal\sarwis\SarwisSearchPointInterface
   *   The called search point entity.
   */
  public function setName($name);

  /**
   * Gets the search point creation timestamp.
   *
   * @return int
   *   Creation timestamp of the search point.
   */
  public function getCreatedTime();

  /**
   * Sets the search point creation timestamp.
   *
   * @param int $timestamp
   *   The search point creation timestamp.
   *
   * @return \Drupal\sarwis\SarwisSearchPointInterface
   *   The called search point entity.
   */
  public function setCreatedTime($timestamp);

}
