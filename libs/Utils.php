<?php

namespace cottacush\userauth\libs;

use Yii;
use yii\helpers\BaseInflector;


/**
 * Class Utils
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 * @package cottacush\userauth\libs
 */
class Utils
{

    /**
     * Performs one-way encryption of a user's password using PHP's bcrypt
     *
     * @param string $rawPassword the password to be encrypted
     * @return bool|string
     */
    public static function encryptPassword($rawPassword)
    {
        return Yii::$app->security->generatePasswordHash($rawPassword);
    }


    /**
     * Verify that password entered will match the hashed password
     *
     * @param string $rawPassword the user's raw password
     * @param string $dbHash the hashed password that was saved
     * @return bool
     */
    public static function verifyPassword($rawPassword, $dbHash)
    {
        return Yii::$app->security->validatePassword($rawPassword, $dbHash);
    }


    /**
     * Function to generate a random password
     * @param int $length
     * @param bool|true $strict
     * @return string
     */
    public static function generateRandomPassword($length = 8, $strict = true)
    {
        return Yii::$app->security->generateRandomString($length);
    }

    /**
     * @param int $length length of the string
     * @param bool|true $strict whether or not the string should contain a symbol
     * @return string
     */
    public static function generateRandomString($length, $strict = true)
    {
        return Yii::$app->security->generateRandomString($length);
    }

    /**
     * Get current date and time
     * @author Tega Oghenekohwo <tega@cottacush.com>
     * @return bool|string
     */
    public static function getCurrentDateTime()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * @param array $keys
     * @param array $array
     * @return bool
     */
    public static function validateArrayHasAllKeys(array $keys, array $array)
    {
        foreach ($keys as $aKey) {
            if (!array_key_exists($aKey, $array)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param array $properties
     * @param $object
     * @return bool
     */
    public static function validateObjectHasAllProperties(array $properties, $object)
    {
        foreach ($properties as $aProperty) {
            if (!property_exists($object, $aProperty)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param mixed $message
     * @return string
     */
    public static function getMessagesFromStringOrArray($message)
    {
        $messages = "";
        // check if the messages parameter passed is an array or a string
        if (is_array($message)) {
            foreach ($message as $m) {
                //double check to ensure that internal value is not an array
                if (!is_array($m)) {
                    $messages .= $m . ",";
                }
            }
        } else {
            $messages = $message;
        }

        return $messages;
    }

    /**
     * Get errors as string
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @param $errors
     * @return string
     */
    public static function getErrorsAsString($errors)
    {
        if (is_array($errors)) {
            $errorsStringArr = [];
            /** @var  $error */
            foreach ($errors as $field => $errorsArr) {
                $errorsStringArr = array_merge($errorsStringArr, $errorsArr);
            }
            return BaseInflector::sentence($errorsStringArr);
        }
        return $errors;
    }
}