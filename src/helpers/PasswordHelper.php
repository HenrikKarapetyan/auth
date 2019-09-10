<?php

namespace henrik\auth\helpers;

use henrik\auth\exceptions\HashException;
use henrik\auth\interfaces\PasswordHelperInterface;

/**
 * Class PasswordHelperInterface
 * @package henrik\auth
 */
class PasswordHelper implements PasswordHelperInterface
{

    /**
     * @var int
     */
    private static $password_hash_algorithm = PASSWORD_BCRYPT;

    /**
     * @param string $savedPassword
     * @param string $submittedPassword
     * @return bool
     */
    public static function verify($savedPassword, $submittedPassword)
    {
        return password_verify($submittedPassword, $savedPassword);
    }

    /**
     * @param string $submittedPassword
     * @return bool|string
     * @throws HashException
     */
    public static function hash($submittedPassword)
    {
        $hash = password_hash($submittedPassword, static::$password_hash_algorithm);
        if ($hash === false) {
            throw new HashException('Failed to hash submitted password');
        }
        return $hash;
    }

    /**
     * @return int
     */
    public static function getPasswordHashAlgorithm()
    {
        return self::$password_hash_algorithm;
    }

    /**
     * @param int $password_hash_algorithm
     */
    public static function setPasswordHashAlgorithm($password_hash_algorithm)
    {
        self::$password_hash_algorithm = $password_hash_algorithm;
    }
}