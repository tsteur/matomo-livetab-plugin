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
use Piwik\Settings\UserSetting;

/**
 * Settings
 *
 * @package Login
 */
class Settings extends PluginSettings
{

    protected function init()
    {
        $this->setIntroduction(Piwik::translate('LiveTab_SettingsIntroduction'));
        $this->addSetting($this->getMetricSetting());
        $this->addSetting($this->getLastMinuteSetting());
        $this->addSetting($this->getRefreshIntervalSetting());
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
        return $this->getSettingValue($this->getMetricSetting());
    }

    public function getRefreshInterval()
    {
        return $this->getSettingValue($this->getLastMinuteSetting());
    }

    public function getLastMinutes()
    {
        return $this->getSettingValue($this->getRefreshIntervalSetting());
    }

    private function getMetricSetting()
    {
        $metric = new UserSetting('metric', Piwik::translate('LiveTab_MetricToDisplay'));
        $metric->type  = static::TYPE_STRING;
        $metric->field = static::FIELD_SINGLE_SELECT;
        $metric->fieldOptions = $this->getAvailableMetrics();
        $metric->description  = Piwik::translate('LiveTab_MetricDescription');
        $metric->defaultValue = 'visits';

        return $metric;
    }

    private function getLastMinuteSetting()
    {
        $lastMinutes = new UserSetting('lastMinutes', Piwik::translate('LiveTab_LastMinutes'));
        $lastMinutes->type = static::TYPE_INT;
        $lastMinutes->fieldAttributes = array('size' => 3);
        $lastMinutes->description     = Piwik::translate('LiveTab_LastMinutesDescription');
        $lastMinutes->defaultValue    = 30;

        return $lastMinutes;
    }

    private function getRefreshIntervalSetting()
    {
        $refreshInterval = new UserSetting('refreshInterval', Piwik::translate('LiveTab_RefreshInterval'));
        $refreshInterval->type = static::TYPE_INT;
        $refreshInterval->fieldAttributes = array('size' => 3);
        $refreshInterval->description     = Piwik::translate('LiveTab_RefreshIntervalDescription');
        $refreshInterval->defaultValue    = 60;

        return $refreshInterval;
    }
}
