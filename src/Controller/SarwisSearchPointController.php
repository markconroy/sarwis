<?php

namespace Drupal\sarwis\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

/**
 * Returns responses for SARWIS Search Point routes.
 */
class SarwisSearchPointController extends ControllerBase {

  /**
   * Redirects to the field UI manage fields page.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   *   A redirect response to the field management page.
   */
  public function settings() {
    $url = Url::fromRoute('entity.sarwis_search_point.field_ui_fields', [
      'entity_type_id' => 'sarwis_search_point',
    ]);
    return new RedirectResponse($url->toString());
  }

}
