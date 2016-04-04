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
use Piwik\Settings\Plugin\UserSetting;
use Piwik\Settings\FieldConfig;

/**
 * Settings
 *
 * @package Login
 */
class UserSettings extends \Piwik\Settings\Plugin\UserSettings
{
    /**
     * @var UserSetting
     */
    public $metric;

    /**
     * @var UserSetting
     */
    public $lastMinutes;

    /**
     * @var UserSetting
     */
    public $refreshInterval;

    protected function init()
    {
        $this->metric = $this->createMetricSetting();
        $this->lastMinutes = $this->createLastMinuteSetting();
        $this->refreshInterval = $this->createRefreshIntervalSetting();
    }

    private function createMetricSetting()
    {
        return $this->makeSetting('metric', $default = 'visits', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('LiveTab_MetricToDisplay');
            $field->description     = Piwik::translate('LiveTab_MetricDescription');
            $field->uiControl       = FieldConfig::UI_CONTROL_SINGLE_SELECT;
            $field->availableValues = array(
                'visits'          => Piwik::translate('General_ColumnNbVisits'),
                'actions'         => Piwik::translate('General_ColumnNbActions'),
                'visitsConverted' => Piwik::translate('Goals_GoalConversions'),
                'visitors'        => Piwik::translate('General_ColumnNbUniqVisitors')
            );
        });
    }

    private function createLastMinuteSetting()
    {
        return $this->makeSetting('lastMinutes', $default = 30, FieldConfig::TYPE_INT, function (FieldConfig $field) {
            $field->title = Piwik::translate('LiveTab_LastMinutes');
            $field->description  = Piwik::translate('LiveTab_LastMinutesDescription');
            $field->uiControlAttributes = array('size' => 3);
        });
    }

    private function createRefreshIntervalSetting()
    {
        return $this->makeSetting('refreshInterval', $default = 60, FieldConfig::TYPE_INT, function (FieldConfig $field) {
            $field->title = Piwik::translate('LiveTab_RefreshInterval');
            $field->description  = Piwik::translate('LiveTab_RefreshIntervalDescription');
            $field->uiControlAttributes = array('size' => 3);
        });

    }
}
