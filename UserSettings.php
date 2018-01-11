<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\LiveTab;

use Piwik\Piwik;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;

/**
 * Defines Settings for LiveTab.
 *
 * Usage like this:
 * $settings = new UserSettings();
 * $settings->autoRefresh->getValue();
 * $settings->color->getValue();
 */
class UserSettings extends \Piwik\Settings\Plugin\UserSettings
{
    /** @var Setting */
    public $metric;

    /** @var Setting */
    public $lastMinutes;

    /** @var Setting */
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
            $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
            $field->description = Piwik::translate('LiveTab_MetricDescription');
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
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = array('size' => 3);
            $field->description = Piwik::translate('LiveTab_LastMinutesDescription');
        });
    }

    private function createRefreshIntervalSetting()
    {
        return $this->makeSetting('refreshInterval', $default = 60, FieldConfig::TYPE_INT, function (FieldConfig $field) {
            $field->title = Piwik::translate('LiveTab_RefreshInterval');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = array('size' => 3);
            $field->description = Piwik::translate('LiveTab_RefreshIntervalDescription');
        });
    }
}
