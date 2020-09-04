<?php


namespace App;

use App\Traits\CacheTrait;
use App\Api\Facade as Api;

class Config
{
    use CacheTrait;

    const CONFIG_TAG_JIVO_ACTIVE = 'jivo_active';
    const CONFIG_TAG_JIVO_SCRIPT = 'jivo_script';

    /**
     * @var Config|null
     */
    protected static ?Config $instance = null;

    /**
     * Токен пользователя, для которого будет получаться конфиг
     *
     * @var string|null
     */
    protected ?string $userToken;

    /**
     * Config constructor.
     * @param string|null $userToken
     * @throws \Exception
     */
    public function __construct(string $userToken = null)
    {
        if (empty($userToken)) {
            $userToken = User::getToken();
        }
        $this->userToken = $userToken;
    }

    /**
     * @return Config|null
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param string $tag
     * @return mixed|null
     */
    public function get(string $tag)
    {
        if ($this->cache()->exists($tag)) {
            return $this->cache()->get($tag);
        } else {
            $response = Api::instance()->getConfig($this->userToken, $tag);
            if ($response->status ?? true) {
                $output = $response->value ?? null;
                $this->cache()->set($tag, $output);
                return $output;
            } else {
                return null;
            }
        }
    }

    /**
     * @return string|null
     */
    public function getJivoLink() : ?string
    {
        $jivoActive = $this->get(self::CONFIG_TAG_JIVO_ACTIVE);
        if (empty($jivoActive)) {
            return null;
        } else {
            return $this->get(self::CONFIG_TAG_JIVO_SCRIPT);
        }
    }

}