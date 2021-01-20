<?

IncludeModuleLangFile(__FILE__);
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
        $this->MODULE_VERSION = "0.0.1";
        $this->MODULE_VERSION_DATE = "2020-11-24 08:59:04";
        $this->MODULE_NAME = "Bitrix JWT";
        $this->MODULE_DESCRIPTION = "Работа с JWT токенами";
    }

    public function DoInstall()
    {
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

    public function DoUninstall()
    {
        ModuleManager::UnRegisterModule($this->MODULE_ID);
        return true;
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
