<?php

namespace Sellsei\EcommerceCoreBundle\Behat;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use WebDriver;

/**
 * Behat context class.
 */
class CoreContext extends RawMinkContext implements Context
{
    public function __construct()
    {
    }

    /**
     * @Given I should see page title :text
     */
    public function iShouldSeePageTitle($text)
    {
        $this->assertSession()->pageTextContains($text);
    }

    /**
     * @Given /^I wait for css element "([^"]+)" to (appear|disappear)$/
     */
    public function iWaitForCssElement($element, $appear)
    {
        $xpath = $this->getSession()->getSelectorsHandler()->selectorToXpath('css', $element);
        $this->waitForXpath($xpath, $appear == 'appear');
    }

    private function waitForXpath($xpath, $appear)
    {
        $this->waitFor(function ($context) use ($xpath, $appear) {
            $visible = $context->getSession()->getDriver()->isVisible($xpath);

            return $appear ? $visible : !$visible;
        });
    }

    private function waitForXpathNode($xpath, $appear)
    {
        $this->waitFor(function ($context) use ($xpath, $appear) {
            try {
                $nodes = $context->getSession()->getDriver()->find($xpath);
                if (count($nodes) > 0) {
                    $visible = $nodes[0]->isVisible();

                    return $appear ? $visible : !$visible;
                } else {
                    return !$appear;
                }
            } catch (WebDriver\Exception $e) {
                if ($e->getCode() == WebDriver\Exception::NO_SUCH_ELEMENT) {
                    return !$appear;
                }
                throw $e;
            }
        });
    }

    /**
     * @Given /^I wait for text "([^"]+)" to (appear|disappear)$/
     */
    public function iWaitForText($text, $appear)
    {
        $this->waitForXpathNode(".//*[contains(normalize-space(string(text())), \"$text\")]", $appear == 'appear');
    }

    private function waitFor($fn, $timeout = 5000)
    {
        $start = microtime(true);
        $end = $start + $timeout / 1000.0;
        while (microtime(true) < $end) {
            if ($fn($this)) {
                return;
            }
        }
        throw new \Exception("waitFor timed out");
    }

}
