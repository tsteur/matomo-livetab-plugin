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

namespace Piwik\Plugins\LiveTab;

use Piwik\Piwik;
use Piwik\Plugin\Settings as PluginSettings;

/**
 * Settings
 *
 * @package Login
 */
class Settings extends PluginSettings
{

    protected function init()
    {
        $this->addMetricSetting();
        $this->addLastMinuteSetting();
        $this->addRefreshIntervalSetting();
    }

    public function getAvailableMetrics()
    {
        return array(
            'visits'          => Piwik::translate('General_ColumnNbVisits'),
            'actions'         => Piwik::translate('General_ColumnNbActions'),
            'visitsConverted' => Piwik::translate('Goals_GoalConversions'),
            'visitors'        => Piwik::translate('General_ColumnNbUniqVisitors')
        );
    }

    public function getMetric()
    {
        return $this->getSettingValue('metric_' . Piwik::getCurrentUserLogin());
    }

    public function getRefreshInterval()
    {
        return $this->getSettingValue('last_minutes_' . Piwik::getCurrentUserLogin());
    }

    public function getLastMinutes()
    {
        return $this->getSettingValue('refresh_interval_' . Piwik::getCurrentUserLogin());
    }

    /**
     * @return string
     */
    private function addMetricSetting()
    {
        $title = Piwik::translate('LiveTab_MetricToDisplay');
        $name  = 'metric_' . Piwik::getCurrentUserLogin();
        $availableMetrics = $this->getAvailableMetrics();

        $this->addSetting($name, $title, array(
            'type'         => static::TYPE_STRING,
            'field'        => static::FIELD_SINGLE_SELECT,
            'description'  => 'Choose the metric that should be displayed in the browser tab',
            'options'      => $availableMetrics,
            'defaultValue' => 'visits',
            'displayedForCurrentUser' => !Piwik::isUserIsAnonymous(),
            'validate' => function ($value) use ($availableMetrics) {
                // TODO in case of selects we could automatically validate in core
                if (!array_key_exists($value, $availableMetrics)) {
                    throw new \Exception(Piwik::translate('LiveTab_InvalidMetric'));
                }
            }
        ));
    }

    /**
     * @return string
     */
    private function addLastMinuteSetting()
    {
        $name  = 'last_minutes_' . Piwik::getCurrentUserLogin();
        $title = Piwik::translate('LiveTab_LastMinutes');

        $this->addSetting($name, $title, array(
            'type'            => static::TYPE_INT,
            'fieldAttributes' => array('size' => 3),
            'description'     => 'The counter will display the number of last N minutes',
            'defaultValue'    => 30,
            'displayedForCurrentUser' => !Piwik::isUserIsAnonymous()
        ));
        return $name;
    }

    private function addRefreshIntervalSetting()
    {
        $name  = 'refresh_interval_' . Piwik::getCurrentUserLogin();
        $title = Piwik::translate('LiveTab_RefreshInterval');

        $this->addSetting($name, $title, array(
            'type'            => static::TYPE_INT,
            'fieldAttributes' => array('size' => 3),
            'description'     => 'Defines how often the value should be updated (in seconds).',
            'defaultValue'    => 60,
            'displayedForCurrentUser' => !Piwik::isUserIsAnonymous()
        ));
    }
}
