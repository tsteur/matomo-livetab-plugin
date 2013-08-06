<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * @category Piwik_Plugins
 * @package Piwik_LiveTab
 */

use Piwik\Controller\Admin;
use Piwik\Piwik;
use Piwik\View;

/**
 *
 * @package Piwik_LiveTab
 */
class Piwik_LiveTab_Controller extends Admin
{
    public function index()
    {
        Piwik::checkUserIsNotAnonymous();

        $view = new View('@LiveTab/index');

        $api = new Piwik_LiveTab_API();
        $settings = $api->getSettings();

        $view->metricToDisplay  = $settings['metric'];
        $view->lastMinutes      = $settings['lastMinutes'];
        $view->refreshInterval  = $settings['refreshInterval'];
        $view->availableMetrics = $api->getAvailableMetrics();

        $this->setBasicVariablesView($view);

        echo $view->render();
    }
}
