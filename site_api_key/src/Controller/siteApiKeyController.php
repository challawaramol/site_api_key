<?php

namespace Drupal\site_api_key\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class siteApiKeyController.
 *
 * @package Drupal\site_api_key\Controller
 */
class siteApiKeyController extends ControllerBase {

 
/* get json information of the page type node only
 * @param  string $api_key API key passed through url
 * @param  object $node    node object of nid passed through url
 * @return Contditional json output
 */
  public function display($api_key, NodeInterface $node) {
    $stored_api_key = \Drupal::config('system.site')->get('siteapikey');
    if ((!empty($stored_api_key)) && ($api_key == $stored_api_key) && $node->getType() == "page") {
        return new JsonResponse($node->toArray());
    }
    else {
        return new JsonResponse(array('access denied'));
    };
  }

}
