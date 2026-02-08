<?php

namespace Drupal\sarwis\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\sarwis\SarwisSearchPointInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the SARWIS Search Point entity.
 *
 * @ContentEntityType(
 *   id = "sarwis_search_point",
 *   label = @Translation("SARWIS Search Point"),
 *   label_collection = @Translation("SARWIS Search Points"),
 *   label_singular = @Translation("search point"),
 *   label_plural = @Translation("search points"),
 *   label_count = @PluralTranslation(
 *     singular = "@count search point",
 *     plural = "@count search points",
 *   ),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\sarwis\SarwisSearchPointListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\Core\Entity\EntityAccessControlHandler",
 *     "form" = {
 *       "default" = "Drupal\sarwis\Form\SarwisSearchPointForm",
 *       "add" = "Drupal\sarwis\Form\SarwisSearchPointForm",
 *       "edit" = "Drupal\sarwis\Form\SarwisSearchPointForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "sarwis_search_point",
 *   data_table = "sarwis_search_point_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer sarwis search point",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "canonical" = "/admin/content/sarwis-search-point/{sarwis_search_point}",
 *     "add-form" = "/admin/content/sarwis-search-point/add",
 *     "edit-form" = "/admin/content/sarwis-search-point/{sarwis_search_point}/edit",
 *     "delete-form" = "/admin/content/sarwis-search-point/{sarwis_search_point}/delete",
 *     "collection" = "/admin/content/sarwis-search-point",
 *   },
 *   field_ui_base_route = "entity.sarwis_search_point.settings"
 * )
 */
class SarwisSearchPoint extends ContentEntityBase implements SarwisSearchPointInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTagsToInvalidate() {
    $tags = parent::getCacheTagsToInvalidate();
    // Invalidate the parent activity node's cache when this search point changes.
    if (!$this->get('sarwis_activity')->isEmpty()) {
      $activity_node = $this->get('sarwis_activity')->entity;
      if ($activity_node) {
        $tags = array_merge($tags, $activity_node->getCacheTags());
      }
    }
    return $tags;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the search point.'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Published'))
      ->setDescription(t('A boolean indicating whether the search point is published.'))
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => 100,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the search point.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDefaultValueCallback(static::class . '::getDefaultEntityOwner')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'))
      ->setTranslatable(TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'))
      ->setTranslatable(TRUE);

    return $fields;
  }

}
