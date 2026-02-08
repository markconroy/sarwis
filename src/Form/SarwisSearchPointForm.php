<?php

namespace Drupal\sarwis\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for SARWIS Search Point edit forms.
 */
class SarwisSearchPointForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $result = parent::save($form, $form_state);

    $message_args = ['%label' => $entity->label()];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New search point %label has been created.', $message_args));
    }
    else {
      $this->messenger()->addStatus($this->t('The search point %label has been updated.', $message_args));
    }

    $form_state->setRedirect('entity.sarwis_search_point.canonical', ['sarwis_search_point' => $entity->id()]);

    return $result;
  }

}
