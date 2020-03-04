<?php

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Context\SnippetAcceptingContext;

/**
 * FeatureContext class defines custom step definitions for Behat.
 */
class MarkupContext extends RawMinkContext implements SnippetAcceptingContext {

  /**
   * Checks if a text is in an element with id|name|title|alt|value in a region.
   *
   * @Then I( should) see the :tag element with the :text value in the :region( region)
   */
  public function assertRegionElementAttribute($tag, $text, $region) {
    $regionObj = $this->getRegion($region);

    $elements = $regionObj->findAll('css', $tag);

    if (empty($elements)) {
      throw new \Exception(sprintf('The element "%s" was not found in the "%s" region on the page %s', $tag, $region, $this->getSession()->getCurrentUrl()));
    }
    else {
      $found = FALSE;
      foreach ($elements as $result) {
        if (strpos($result->getText(), $text) !== FALSE) {
          $found = TRUE;
        }
      }
      if (!$found) {
        throw new \Exception(sprintf('The "%s" is not present on the element "%s" in the "%s" region on the page %s', $text, $tag, $region, $this->getSession()->getCurrentUrl()));
      }
    }
  }

  /**
   * Return a region from the current page.
   *
   * @param string $region
   *   The machine name of the region to return.
   *
   * @throws \Exception
   *   If region cannot be found.
   *
   * @return \Behat\Mink\Element\NodeElement
   *   The layout region for the page.
   */
  public function getRegion($region) {
    $session = $this->getSession();
    $regionObj = $session->getPage()->find('region', $region);
    if (!$regionObj) {
      throw new \Exception(sprintf('No region "%s" found on the page %s.', $region, $session->getCurrentUrl()));
    }

    return $regionObj;
  }

}
