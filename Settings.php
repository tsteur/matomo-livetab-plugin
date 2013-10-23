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
        return $this->getPerUserSettingValue('metric');
    }

    public function getRefreshInterval()
    {
        return $this->getPerUserSettingValue('lastMinutes');
    }

    public function getLastMinutes()
    {
        return $this->getPerUserSettingValue('refreshInterval');
    }

    /**
     * @return string
     */
    private function addMetricSetting()
    {
        $title = Piwik::translate('LiveTab_MetricToDisplay');

        $this->addPerUserSetting('metric', $title, array(
            'type'         => static::TYPE_STRING,
            'field'        => static::FIELD_SINGLE_SELECT,
            'fieldOptions' => $this->getAvailableMetrics(),
            'description'  => 'Choose the metric that should be displayed in the browser tab',
            'defaultValue' => 'visits'
        ));
    }

    /**
     * @return string
     */
    private function addLastMinuteSetting()
    {
        $title = Piwik::translate('LiveTab_LastMinutes');

        $this->addPerUserSetting('lastMinutes', $title, array(
            'type'            => static::TYPE_INT,
            'fieldAttributes' => array('size' => 3),
            'description'     => 'The counter will display the number of last N minutes',
            'defaultValue'    => 30
        ));
    }

    private function addRefreshIntervalSetting()
    {
        $title = Piwik::translate('LiveTab_RefreshInterval');

        $this->addPerUserSetting('refreshInterval', $title, array(
            'type'            => static::TYPE_INT,
            'fieldAttributes' => array('size' => 3),
            'description'     => 'Defines how often the value should be updated (in seconds).',
            'defaultValue'    => 60
        ));
    }
}
