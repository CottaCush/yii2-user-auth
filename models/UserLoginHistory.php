<?php

namespace cottacush\userauth\models;
use cottacush\userauth\libs\Utils;
use stdClass;
use yii\db\ActiveRecord;


/**
 * Class UserLoginHistory
 * @property int id
 * @property int user_id
 * @property string date_logged
 * @property string login_status
 * @property string ip_address
 * @property string user_agent
 * @package cottacush\userauth\models
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 */
class UserLoginHistory extends BaseModel
{

    const LOGIN_STATUS_SUCCESS = 'success';

    const LOGIN_STATUS_FAILED = 'failed';

    const LOGIN_STATUS_UNKNOWN = 'unknown';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     * @return $this
     */
    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateLogged(): string
    {
        return $this->date_logged;
    }

    /**
     * @param string $date_logged
     */
    public function setDateLogged(string $date_logged)
    {
        $this->date_logged = $date_logged;
    }

    /**
     * @return string
     */
    public function getLoginStatus(): string
    {
        return $this->login_status;
    }

    /**
     * @param string $login_status
     */
    public function setLoginStatus(string $login_status)
    {
        $this->login_status = $login_status;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ip_address;
    }

    /**
     * @param string $ip_address
     */
    public function setIpAddress(string $ip_address)
    {
        $this->ip_address = $ip_address;
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->user_agent;
    }

    /**
     * @param string $user_agent
     */
    public function setUserAgent(string $user_agent)
    {
        $this->user_agent = $user_agent;
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return "user_login_history";
    }

    /**
     * Set field before validation check
     */
    public function beforeValidate(): bool
    {
        $this->date_logged = Utils::getCurrentDateTime();
        return true;
    }

    /**
     * Save
     * @param $data
     * @return bool
     */
    public function addLog($data): bool
    {
        $request = \Yii::$app->getRequest();

        if (empty($data['ip_address'])) {
            $data['ip_address'] = $request->getUserIP();
        }

        if (empty($data['user_agent'])) {
            $data['user_agent'] = $request->getUserAgent();
        }

        $this->setAttributes($data, false);

        return $this->save();
    }

    /**
     * Get an instance of this class
     * @author Tega Oghenekohwo <tega@cottacush.com>
     * @return $this
     */
    public static function getInstance(): static
    {
        return new self();
    }

    /**
     * @param $page
     * @param $limit
     * @return array|stdClass
     */
    public function fetchLoginHistory($page, $limit): array|stdClass
    {
        return self::find()->where(['user_id' => $this->user_id])->offset($page)->limit($limit)->all();
    }
}