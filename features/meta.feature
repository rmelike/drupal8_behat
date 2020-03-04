@api
Feature: Change on content created by manager user is reflected in meta and front content.
  In order to manage the content on the website
  As a manager
  I want to see the modifications on view content title and in the meta.

  Scenario: Edit nodes with specific authorship
    Given users:
      | name     | mail            | status | role |
      | Joe User | joe@example.com | 1      | manager |
    And "article" content:
      | title       | author   | path |
      | News by Joe | Joe User | /News-by-Joe |
    When I am logged in as a user with the "manager" role
    And I am at "News-by-Joe"
    Then I should see the text "News by Joe"
    And I should see the "meta" element with the "content" attribute set to "News by Joe" in the "head" region
    And I should see the "title" element with the "News by Joe" value in the "head" region
