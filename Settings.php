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
use Piwik\Settings\UserSetting;

/**
 * Settings
 *
 * @package Login
 */
class Settings extends \Piwik\Plugin\Settings
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
        $this->setIntroduction(Piwik::translate('LiveTab_SettingsIntroduction'));

        $this->createMetricSetting();
        $this->createLastMinuteSetting();
        $this->createRefreshIntervalSetting();
    }

    private function createMetricSetting()
    {
        $this->metric = new UserSetting('metric', Piwik::translate('LiveTab_MetricToDisplay'));
        $this->metric->description  = Piwik::translate('LiveTab_MetricDescription');
        $this->metric->defaultValue = 'visits';
        $this->metric->type         = static::TYPE_STRING;
        $this->metric->field        = static::FIELD_SINGLE_SELECT;
        $this->metric->fieldOptions = array(
            'visits'          => Piwik::translate('General_ColumnNbVisits'),
            'actions'         => Piwik::translate('General_ColumnNbActions'),
            'visitsConverted' => Piwik::translate('Goals_GoalConversions'),
            'visitors'        => Piwik::translate('General_ColumnNbUniqVisitors')
        );

        $this->addSetting($this->metric);
    }

    private function createLastMinuteSetting()
    {
        $this->lastMinutes = new UserSetting('lastMinutes', Piwik::translate('LiveTab_LastMinutes'));
        $this->lastMinutes->type = static::TYPE_INT;
        $this->lastMinutes->fieldAttributes = array('size' => 3);
        $this->lastMinutes->description     = Piwik::translate('LiveTab_LastMinutesDescription');
        $this->lastMinutes->defaultValue    = 30;

        $this->addSetting($this->lastMinutes);
    }

    private function createRefreshIntervalSetting()
    {
        $this->refreshInterval = new UserSetting('refreshInterval', Piwik::translate('LiveTab_RefreshInterval'));
        $this->refreshInterval->type = static::TYPE_INT;
        $this->refreshInterval->fieldAttributes = array('size' => 3);
        $this->refreshInterval->description     = Piwik::translate('LiveTab_RefreshIntervalDescription');
        $this->refreshInterval->defaultValue    = 60;

        $this->addSetting($this->refreshInterval);
    }
}
