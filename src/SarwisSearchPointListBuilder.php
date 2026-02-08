<?php

namespace Drupal\sarwis;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Defines a class to build a listing of SARWIS Search Point entities.
 */
class SarwisSearchPointListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\sarwis\SarwisSearchPointInterface $entity */
    $row['id'] = $entity->id();
    $row['name'] = $entity->toLink($entity->label());
    return $row + parent::buildRow($entity);
  }

}
