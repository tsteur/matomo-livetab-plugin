<?php
/**
 * Piwik - Open source web analytics
 *
 * @link     http://piwik.org
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @category Piwik_Plugins
 * @package  Piwik_LiveTab
 */
use Piwik\Piwik;

/**
 * @package Piwik_LiveTab
 */
class Piwik_LiveTab_API
{
    /**
     * @var Piwik_LiveTab_API
     */
    static private $instance = null;

    /**
     * @return Piwik_LiveTab_API
     */
    static public function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function setSettings($metric, $lastMinutes, $refreshInterval)
    {
        // TODO add login as parameter
        Piwik::checkUserHasSomeViewAccess();

        if (!$this->isAllowedMetric($metric)) {
            throw new Exception(Piwik_TranslateException('LiveTab_InvalidMetric'));
        }

        $lastMinutes     = (int) $lastMinutes;
        $refreshInterval = (int) $refreshInterval;

        $login = Piwik::getCurrentUserLogin();

        $model = new Piwik_LiveTab_ModelOptions($login);
        $model->setSettings($metric, $lastMinutes, $refreshInterval);
    }

    public function getSettings()
    {
        // TODO add login as parameter

        Piwik::checkUserHasSomeViewAccess();

        $login = Piwik::getCurrentUserLogin();

        $model    = new Piwik_LiveTab_ModelOptions($login);
        $settings = $model->getSettings();

        if (empty($settings)) {
            return $this->getDefaultSettings();
        }

        return array(
            'metric'          => $settings['metric'],
            'lastMinutes'     => $settings['last_minutes'],
            'refreshInterval' => $settings['refresh_interval']
        );
    }

    public function getAvailableMetrics()
    {
        return array(
            'visits'          => Piwik_Translate('General_ColumnNbVisits'),
            'actions'         => Piwik_Translate('General_ColumnNbActions'),
            'visitsConverted' => Piwik_Translate('Goals_GoalConversions'),
            'visitors'        => Piwik_Translate('General_ColumnNbUniqVisitors')
        );
    }

    private function getDefaultSettings()
    {
        return array(
            'metric'          => Piwik_LiveTab::$defaultMetricToDisplay,
            'lastMinutes'     => Piwik_LiveTab::$defaultLastMinutes,
            'refreshInterval' => Piwik_LiveTab::$defaultRefreshInterval
        );
    }

    private function isAllowedMetric($metric)
    {
        return in_array($metric, array_keys($this->getAvailableMetrics()));
    }
}
