@api
  Feature: Manager can log out and is redirected to homepage
  In order to check redirection
  As a manager
  I want to logout and redirected to homepage

  Scenario: Manager is redirected to homepage after logout
    Given I am logged in as a user with the "manager" role
    When I am on homepage
    And I log out
    Then I should be on homepage
