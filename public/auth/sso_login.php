<?php
/**
 * Front controller tipis — lihat app/Controllers/AuthController.php::ssoLogin()
 * dan app/Services/SimulatedLdap.php untuk kerentanan CWE-90 LDAP Injection.
 */
require_once __DIR__ . '/../../config/config.php';

(new AuthController())->ssoLogin();
