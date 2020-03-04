@api
Feature: Check the sitemap
  All the pages listed in the sitemap are pages published on frontend and return a 200 http status

  Scenario: User can check the sitemap and see that every link is working
    Given I have URLs from "sitemap.xml"
    When I visit individidual URL in sitemap
    Then I see the page is available
