<?

IncludeModuleLangFile(__FILE__);

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Security\Random;

class bx_jwt extends CModule
{
    public $MODULE_ID = "bx.jwt";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $errors;

    public function __construct()
    {
        $this->MODULE_VERSION = "1.0.1";
        $this->MODULE_VERSION_DATE = "2020-11-24 08:59:04";
        $this->MODULE_NAME = "Bitrix JWT";
        $this->MODULE_DESCRIPTION = "Работа с JWT токенами";
    }

    /**
     * @param string $message
     */
    public function setError(string $message)
    {
        $GLOBALS["APPLICATION"]->ThrowException($message);
    }

    /**
     * @return bool
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public function DoInstall(): bool
    {
        $result = $this->installRequiredModules();
        if (!$result) {
            return false;
        }

        ModuleManager::RegisterModule($this->MODULE_ID);
        if (empty(Option::get($this->MODULE_ID, 'JWT_SECRET'))) {
            Option::set($this->MODULE_ID, 'JWT_SECRET', Random::getString(32, true));
        }

        if (empty(Option::get($this->MODULE_ID, 'JWT_HTTP_HEADER'))) {
            Option::set($this->MODULE_ID, 'JWT_HTTP_HEADER', 'X-API-Key');
        }

        if (empty(Option::get($this->MODULE_ID, 'JWT_TTL'))) {
            Option::set($this->MODULE_ID, 'JWT_TTL', 8600);
        }

        return true;
    }

    /**
     * @return bool
     */
    public function DoUninstall(): bool
    {
        ModuleManager::UnRegisterModule($this->MODULE_ID);
        return true;
    }

    /**
     * @return bool
     */
    public function installRequiredModules(): bool
    {
        $isInstalled = ModuleManager::isModuleInstalled('bx.model');
        if ($isInstalled) {
            return true;
        }

        $modulePath = getLocalPath("modules/bx.model/install/index.php");
        if (!$modulePath) {
            $this->setError('Отсутствует модуль bx.model - https://github.com/beta-eto-code/bx.model');
            return false;
        }

        require_once $_SERVER['DOCUMENT_ROOT'].$modulePath;
        $moduleInstaller = new bx_model();
        $resultInstall = (bool)$moduleInstaller->DoInstall();
        if (!$resultInstall) {
            $this->setError('Ошибка установки модуля bx.model');
        }

        return $resultInstall;
    }

    public function InstallEvents()
    {
        return true;
    }

    public function UnInstallEvents()
    {
        return true;
    }

    public function InstallFiles()
    {
        return true;
    }

    public function UnInstallFiles()
    {
        return true;
    }
}
