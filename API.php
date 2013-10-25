<?php
/**
 * Piwik - Open source web analytics
 *
 * @link     http://piwik.org
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @category Piwik_Plugins
 * @package  Piwik_LiveTab
 */

namespace Piwik\Plugins\LiveTab;

use Piwik\Piwik;

/**
 * @package Piwik_LiveTab
 */
class API extends \Piwik\Plugin\API
{

    public function getSettings()
    {
        Piwik::checkUserHasSomeViewAccess();

        $settings = new Settings('LiveTab');

        return array(
            'metric'          => $settings->metric->getValue(),
            'lastMinutes'     => $settings->lastMinutes->getValue(),
            'refreshInterval' => $settings->refreshInterval->getValue()
        );
    }

}