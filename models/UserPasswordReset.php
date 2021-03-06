<?php

namespace cottacush\userauth\models;
use cottacush\userauth\exceptions\ResetPasswordException;
use cottacush\userauth\libs\Utils;
use yii\base\Exception;
use yii\db\ActiveRecord;


/**
 * Class UserPasswordReset
 * @property int user_id
 * @property int id
 * @property string token
 * @property string date_requested
 * @property int date_of_expiry
 * @property  int expires
 * @package UserAuth\Models
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 */
class UserPasswordReset extends BaseModel
{
    /**
     * The default length of a reset password token
     */
    const DEFAULT_TOKEN_LENGTH = 50;

    /**
     * The maximum length of a reset password token
     */
    const MAX_TOKEN_LENGTH = 200;

    /**
     * The minimum length of a reset password token
     */
    const MIN_TOKEN_LENGTH = 20;

    /**
     * The default token expiry time of a reset password token
     */
    const DEFAULT_TOKEN_EXPIRY_TIME = 259200; //3 * 24 * 3600

    /**
     * Set the object's ID
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the object's ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the object's User ID
     * @param int $user_id
     */
    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Get the object's User ID
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * Set the token for this object
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the token for this object
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Set the date the password request was made for this object
     * @param string $date_requested
     */
    public function setDateRequested(string $date_requested)
    {
        $this->date_requested = $date_requested;
    }

    /**
     * Get the date the password request was made for this object
     * @return string
     */
    public function getDateRequested(): string
    {
        return $this->date_requested;
    }

    /**
     * Set the expiry timestamp for the token created when this reset password request was made
     * @param int $date_of_expiry
     */
    public function setDateOfExpiry(int $date_of_expiry)
    {
        $this->date_of_expiry = $date_of_expiry;
    }

    /**
     * Get the UNIX timestamp for which the token created when this reset password request was made will expire
     * @return int
     */
    public function getDateOfExpiry(): int
    {
        return $this->date_of_expiry;
    }

    /**
     * Set whether or not a token should expired
     * @param $expires
     */
    public function setExpires($expires)
    {
        $this->expires  = $expires;
    }

    /**
     * Get whether or not a token will expire
     * @return bool|int
     */
    public function getExpires(): bool|int
    {
        return $this->expires;
    }

    /**
     * Table for managing model
     * @return string
     */
    public static function tableName(): string
    {
        return "user_password_resets";
    }

    /**
     * @param int $user_id
     * @param int $tokenLength
     * @param int $expires
     * @param boolean $expiry
     * @return string
     * @throws ResetPasswordException
     * @throws Exception
     */
    public function generateToken(int $user_id, int $tokenLength, int $expires, bool $expiry): string
    {
        if ($tokenLength > self::MAX_TOKEN_LENGTH) {
            throw new ResetPasswordException(sprintf(ErrorMessages::RESET_PASSWORD_TOKEN_TOO_LONG, UserPasswordReset::MAX_TOKEN_LENGTH));
        }

        if ($tokenLength < self::MIN_TOKEN_LENGTH) {
            throw new ResetPasswordException(sprintf(ErrorMessages::RESET_PASSWORD_TOKEN_TOO_SHORT, UserPasswordReset::MIN_TOKEN_LENGTH));
        }

        $tokenLength = $tokenLength - 10; //append a timestamp
        $token = Utils::generateRandomString($tokenLength, false);
        $token = $token . time();
        if ($this->tokenExists($token)) {
            return $this->generateToken($user_id, $tokenLength, $expires, $expiry);
        }

        $this->setUserId($user_id);
        $this->setExpires((int) $expires);
        $this->setDateOfExpiry($expires ? time() + $expiry : null);
        $this->setToken($token);
        $this->setDateRequested(date("Y-m-d H:i:s"));

        if (!$this->save()) {
            throw new ResetPasswordException(ErrorMessages::RESET_PASSWORD_FAILED);
        }

        return $token;
    }

    /**
     * Get reset data associated with a token
     * @param $token
     * @return array|UserPasswordReset|ActiveRecord
     */
    public function getTokenData($token): self|array|ActiveRecord
    {
        return $this->find()->where(['token' => $token])->one();
    }

    /**
     * Check if a token already exists
     * @param string $token
     * @return bool
     */
    private function tokenExists(string $token): bool
    {
        $tokenData = $this->getTokenData($token);
        if ($tokenData == false) {
            return false;
        }

        return $tokenData == false;
    }

    /**
     * Expire a token
     * @param string $token
     * @return bool
     */
    public function expireToken(string $token): bool
    {
        $tokenData = $this->getTokenData($token);
        if ($tokenData == false) {
            return false;
        }

        $tokenData->date_of_expiry = time() - 1;
        return $tokenData->save();
    }

}