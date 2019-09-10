<?php
namespace henrik\auth\interfaces;

/**
 * Interface PasswordHelperInterface
 * @package henrik\auth\interfaces
 */
interface PasswordHelperInterface
{

    /**
     * @param $savedPassword
     * @param $submittedPassword
     * @return bool
     */
    public static function verify($savedPassword, $submittedPassword);

    /**
     * @param $submittedPassword
     * @return string
     */
    public static function hash($submittedPassword);

}