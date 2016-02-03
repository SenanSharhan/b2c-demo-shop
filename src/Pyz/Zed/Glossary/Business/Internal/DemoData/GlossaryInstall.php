<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace Pyz\Zed\Glossary\Business\Internal\DemoData;

use Spryker\Zed\Installer\Business\Model\AbstractInstaller;
use Spryker\Zed\Glossary\Dependency\Plugin\GlossaryInstallerPluginInterface;

class GlossaryInstall extends AbstractInstaller
{

    /**
     * @var \Spryker\Zed\Glossary\Dependency\Plugin\GlossaryInstallerPluginInterface[]
     */
    protected $installers;

    /**
     * @param array $installers
     */
    public function __construct(array $installers)
    {
        $this->installers = $installers;
    }

    public function install()
    {
        $this->info('This will install a standard set of translations in the demo shop');

        foreach ($this->installers as $installer) {
            $installer->installGlossaryData();
        }
    }

}
