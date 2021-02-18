<?php

namespace cottacush\userauth\models;
use cottacush\userauth\exceptions\PasswordChangeException;
use cottacush\userauth\libs\Utils;


/**
 * Class UserPasswordChange
 * @property mixed user_id
 * @property mixed id
 * @property mixed date_changed
 * @property mixed password_hash
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 * @package cottacush\userauth\models
 */
class UserPasswordChange extends BaseModel
{
    const MAX_PASSWORD_CHANGES_BEFORE_REUSE = 5;


    /**
     * Table for managing model
     * @return string
     */
    public static function tableName(): string
    {
        return "user_password_changes";
    }

    /**
     * Get ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get user's user ID
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * Set user ID
     * @param $userId
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    /**
     * Get the date password change was made
     * @return string
     */
    public function getDateChanged(): string
    {
        return $this->date_changed;
    }

    /**
     * Set date changed
     * @param $dateChanged
     */
    public function setDateChanged($dateChanged)
    {
        $this->date_changed = $dateChanged;
    }

    /**
     * Get password hash
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    /**
     * Set Password Hash
     * @param $passwordHash
     */
    public function setPasswordHash($passwordHash)
    {
        $this->password_hash = $passwordHash;
    }

    /**
     * check if the new password does not correspond to the previous max passwords
     * We use max-1 in the query because we are assuming that the user's current password is
     * inclusive of the last max passwords used and this has already been checked above
     *
     * @param int $userId
     * @param string $newPassword
     * @param int $max
     * @throws PasswordChangeException
     */
    public static function validateNewPassword(
        int $userId,
        string $newPassword,
        $max = self::MAX_PASSWORD_CHANGES_BEFORE_REUSE
    )
    {
        $recentPasswords = UserPasswordChange::find()
            ->where(['user_id' => $userId])
            ->orderBy(['date_changed' => SORT_DESC])
            ->limit($max - 1)
            ->asArray()
            ->all();

        foreach ($recentPasswords as $aRecentPassword) {
            if (Utils::verifyPassword($newPassword, $aRecentPassword['password_hash'])) {
                throw new PasswordChangeException("You cannot use any of your last {$max} passwords");
            }
        }
    }
}
