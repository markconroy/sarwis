<?php

namespace Drupal\sarwis\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for SARWIS Search Point routes.
 */
class SarwisSearchPointController extends ControllerBase {

  /**
   * Displays add links for available bundles/types for entity sarwis_search_point.
   *
   * @return array
   *   A render array for a list of the sarwis_search_point bundles that can be added.
   */
  public function settings() {
    return [
      '#markup' => $this->t('Settings form for SARWIS Search Point. Manage field settings here.'),
    ];
  }

}
