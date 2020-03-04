<?php

use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;

/**
 * Defines application features from the specific context.
 */
class SiteMapContext extends RawDrupalContext implements SnippetAcceptingContext {

  /**
   * Url's.
   *
   * @var array
   */
  private $urls;

  /**
   * Http status code.
   *
   * @var array
   */
  private $statusCode;

  /**
   * Gets sitemap.xml.
   *
   * @Given I have URLs from :link
   */
  public function iHaveUrlsFromSiteMap($link) {
    date_default_timezone_set('Europe/London');
    $this->visitPath($link);
    $xml = $this->getSession()->getPage()->getContent();
    $siteMap = new \SimpleXMLElement($xml);

    if (!isset($siteMap->url)) {
      // When paging is used cause of of to many links.
      foreach ($siteMap->sitemap as $mainUrl) {
        $this->visitPath((string) $mainUrl->loc);
        $xmlSubpage = $this->getSession()->getPage()->getContent();
        $siteMapSub = new \SimpleXMLElement($xmlSubpage);

        $this->pickUrls($siteMapSub);
      }
    }
    else {
      $this->pickUrls($siteMap->url);
    }

    return !empty($this->urls);
  }

  /**
   * Visit an URL in sitemap.xml.
   *
   * @When /^I visit individidual URL in sitemap$/
   */
  public function iVisitIndividualUrlInSitemap() {
    foreach ($this->urls as $url) {
      try {
        $this->getSession()->visit($url);
      }
      catch (\Exception $e) {
        echo "Error while visiting $url. Error message is:" . $e->getMessage();
        continue;
      }
      $this->statusCode[$url] = $this->getSession()->getStatusCode();

    }
  }

  /**
   * Visit an URL in sitemap.xml.
   *
   * @Then /^I see the page is available$/
   */
  public function iSeethePageIsAvailableToUser() {
    $count = 0;
    foreach ($this->statusCode as $url => $code) {
      $status = "SUCCESS";
      if ($code != 200) {
        $status = "FAILED";
        echo $status . '- Error: ' . $code . ' -> ' . $url . "\n";
        $count++;
      }
    }
    echo $count . ' failed';
  }

  /**
   * Get urls to be checked.
   */
  public function pickUrls($sitemapUrls) {
    foreach ($sitemapUrls as $url) {
      $this->urls[] = (string) $url->loc;
    }
  }

}
