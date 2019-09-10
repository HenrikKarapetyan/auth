<?php
namespace henrik\auth\interfaces;

/**
 * Interface AuthUserInterface
 * @package henrik\auth\interfaces
 */
interface AuthUserInterface
{

    /**
     * @return int
     */
    public function getAuthId();

    /**
     * @return string
     */
    public function getAuthUsername();

    /**
     * @return string
     */
    public function getAuthPassword();

    /**
     * @return string|null
     */
    public function getTwoFactorSecret();

}