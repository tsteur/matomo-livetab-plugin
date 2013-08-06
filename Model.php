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
use Piwik\Common;
use Piwik\Db;

/**
 *
 * @package Piwik_LiveTab
 */
class Piwik_LiveTab_Model
{
    private $login;
    private static $tableName = 'user_livetab_settings';

    public function __construct($login)
    {
        $this->login = $login;
    }

    public function getSettings()
    {
        $query    = sprintf('SELECT metric, last_minutes, refresh_interval FROM %s  WHERE login = ?',
                            Common::prefixTable(self::$tableName));

        $settings = Db::fetchRow($query, array($this->login));

        if (!$settings) {
            return array();
        }

        return $settings;

    }

    public function setSettings($metric, $lastMinutes, $refreshIntervalInMinutes)
    {
        if ($this->hasSettings()) {
            $this->updateSettings($metric, $lastMinutes, $refreshIntervalInMinutes);
        } else {
            $this->createSettings($metric, $lastMinutes, $refreshIntervalInMinutes);
        }
    }

    private function hasSettings()
    {
        return !!$this->getSettings();
    }

    private function createSettings($metric, $lastMinutes, $refreshIntervalInMinutes)
    {
        $query = sprintf('INSERT INTO %s (login, metric, last_minutes, refresh_interval) VALUES (?, ?,?,?)',
                         Common::prefixTable(self::$tableName));

        $bindParams = array($this->login, $metric, $lastMinutes, $refreshIntervalInMinutes);

        Db::query($query, $bindParams);
    }

    private function updateSettings($metric, $lastMinutes, $refreshIntervalInMinutes)
    {
        $query = sprintf('UPDATE %s SET metric = ?, last_minutes = ?, refresh_interval = ? WHERE login = ?',
                         Common::prefixTable(self::$tableName));

        $bindParams = array($metric, $lastMinutes, $refreshIntervalInMinutes, $this->login);

        Db::query($query, $bindParams);
    }

    public static function install()
    {
        try {
            $sql = "CREATE TABLE " . Common::prefixTable(self::$tableName) . " (
                    login VARCHAR( 100 ) NOT NULL ,
                    metric VARCHAR( 20 ) NOT NULL ,
                    last_minutes INT NOT NULL ,
                    refresh_interval INT NOT NULL,
                    PRIMARY KEY ( login )
                    )  DEFAULT CHARSET=utf8 ";
            Db::exec($sql);
        } catch (Exception $e) {
            // mysql code error 1050:table already exists
            // see bug #153 http://dev.piwik.org/trac/ticket/153
            if (!Zend_Registry::get('db')->isErrNo($e, '1050')) {
                throw $e;
            }
        }
    }

    public static function uninstall()
    {
        Db::dropTables(Common::prefixTable(self::$tableName));
    }
}
