<?php

namespace Pyz\Yves\Customer\Plugin\Provider;

use Pyz\Yves\Application\Plugin\Provider\AbstractServiceProvider;
use Pyz\Yves\Customer\CustomerFactory;
use Pyz\Yves\Customer\Form\LoginForm;
use Silex\Application;
use Spryker\Client\Customer\CustomerClientInterface;
use Spryker\Shared\Config;
use Spryker\Shared\Customer\CustomerConstants;

/**
 * @method \Spryker\Client\Customer\CustomerClientInterface getClient()
 * @method \Pyz\Yves\Customer\CustomerFactory getFactory()
 */
class CustomerSecurityServiceProvider extends AbstractServiceProvider
{
    const FIREWALL_SECURED = 'secured';
    const ROLE_USER = 'ROLE_USER';
    const IS_AUTHENTICATED_ANONYMOUSLY = 'IS_AUTHENTICATED_ANONYMOUSLY';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function register(Application $app)
    {
        $this->setSecurityFirewalls($app);
        $this->setSecurityAccessRules($app);
        $this->setAuthenticationSuccessHandler($app);
    }

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function boot(Application $app)
    {
    }

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function setSecurityFirewalls(Application &$app)
    {
        $app['security.firewalls'] = [
            self::FIREWALL_SECURED => [
                'anonymous' => true,
                'pattern' => '^/',
                'form' => [
                    'login_path' => '/login',
                    'check_path' => '/login_check',
                    'username_parameter' => LoginForm::FORM_NAME . '[' . LoginForm::FIELD_EMAIL . ']',
                    'password_parameter' => LoginForm::FORM_NAME . '[' . LoginForm::FIELD_PASSWORD . ']',
                ],
                'logout' => [
                    'logout_path' => '/logout',
                ],
                'users' => $app->share(function () {
                    return $this->getFactory()->createCustomerUserProvider();
                }),
            ],
        ];
    }

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function setSecurityAccessRules(Application &$app)
    {
        $app['security.access_rules'] = [
            [
                Config::get(CustomerConstants::CUSTOMER_SECURED_PATTERN),
                self::ROLE_USER,
            ],
            [
                Config::get(CustomerConstants::CUSTOMER_ANONYMOUS_PATTERN),
                self::IS_AUTHENTICATED_ANONYMOUSLY,
            ],
        ];
    }

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function setAuthenticationSuccessHandler(Application &$app)
    {
        $app['security.authentication.success_handler._proto'] = $app->protect(function ($name, $options) use ($app) {
            return $app->share(function () use ($name, $options, $app) {
                return $this->getFactory()->createCustomerAuthenticationSuccessHandler();
            });
        });
    }

}
