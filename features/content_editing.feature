@api
Feature: Manager user has access to add content.
  In order to manage the content on the website
  As a manager
  I want to be able to create and edit actions.., and use allowed HTML

  Scenario Outline: Managers can access certain administration pages
    Given I am logged in as a user with the 'manager' role
    When I am at "<path>"
    Then I should not see the heading "Access denied"

    Examples:
      | path                      |
      | node/add/article          |
      | node/add/page             |