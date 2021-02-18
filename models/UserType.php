<?php

namespace cottacush\userauth\models;

use cottacush\userauth\exceptions\UserTypeException;
use cottacush\userauth\libs\Utils;

/**
 * Class UserLoginHistory
 * @property int id
 * @property string name
 * @property string created_at
 * @property string updated_at
 * @package cottacush\userauth\models;
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 */
class UserType extends BaseModel
{
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(string $updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return "user_types";
    }


    /**
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @return bool
     */
    public function beforeValidate(): bool
    {
        if ($this->hasAttribute('updated_at')) {
            $this->updated_at = Utils::getCurrentDateTime();
        }

        if ($this->isNewRecord && $this->hasAttribute('created_at')) {
            $this->created_at = Utils::getCurrentDateTime();
        }

        return true;
    }

    /**
     * Validate user type entered
     * @return array|bool
     */
    public function rules(): array|bool
    {
        return [
            ['name', 'required', 'message' => 'User type name must be supplied'],
            ['name', 'unique', 'message' => 'Sorry, the user type already exists']
        ];
    }

    /**
     * Create  user type/role
     * @param string $name
     * @return int
     * @throws UserTypeException
     */
    public function createUserType(string $name): int
    {
        $userType = new self();
        $userType->name = $name;
        if (!$userType->save()) {
            throw new UserTypeException(Utils::getErrorsAsString($this->getErrors()));
        }
        return $userType->id;
    }

    /**
     * Return all user types/roles
     * @return $this[]
     */
    public function getUserTypes()
    {
        return $this->find()->all();
    }
}