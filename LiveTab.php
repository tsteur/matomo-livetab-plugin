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

use Piwik\Piwik;
use Piwik\Plugin;

/**
 *
 * @package Piwik_LiveTab
 */
class Piwik_LiveTab extends Plugin
{
    /**
     * @see Piwik_Plugin::getListHooksRegistered
     */
    public function getListHooksRegistered()
    {
        return array('AssetManager.getJsFiles' => 'getJsFiles');
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = 'plugins/LiveTab/javascripts/liveTab.js';
    }
}
