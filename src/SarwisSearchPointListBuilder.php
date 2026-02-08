<?php

namespace Drupal\sarwis;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a class to build a listing of SARWIS Search Point entities.
 */
class SarwisSearchPointListBuilder extends EntityListBuilder {

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Constructs a new SarwisSearchPointListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, DateFormatterInterface $date_formatter) {
    parent::__construct($entity_type, $storage);
    $this->dateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity_type.manager')->getStorage($entity_type->id()),
      $container->get('date.formatter')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['name'] = $this->t('Name');
    $header['activity'] = $this->t('Activity');
    $header['status'] = $this->t('Status');
    $header['owner'] = $this->t('Owner');
    $header['created'] = $this->t('Created');
    $header['changed'] = $this->t('Updated');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\sarwis\SarwisSearchPointInterface $entity */
    $row['name'] = $entity->toLink($entity->label());

    // Activity reference.
    if ($entity->hasField('sarwis_activity') && !$entity->get('sarwis_activity')->isEmpty()) {
      $activity = $entity->get('sarwis_activity')->entity;
      $row['activity'] = $activity ? $activity->toLink() : $this->t('N/A');
    }
    else {
      $row['activity'] = $this->t('N/A');
    }

    // Status.
    $row['status'] = $entity->isPublished() ? $this->t('Published') : $this->t('Unpublished');

    // Owner.
    $owner = $entity->getOwner();
    $row['owner'] = $owner ? $owner->toLink() : $this->t('Anonymous');

    // Timestamps.
    $row['created'] = $this->dateFormatter->format($entity->getCreatedTime(), 'short');
    $row['changed'] = $this->dateFormatter->format($entity->getChangedTime(), 'short');

    return $row + parent::buildRow($entity);
  }

}
