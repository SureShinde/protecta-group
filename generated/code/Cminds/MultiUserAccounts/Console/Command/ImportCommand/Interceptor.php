<?php
namespace Cminds\MultiUserAccounts\Console\Command\ImportCommand;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Console\Command\ImportCommand
 */
class Interceptor extends \Cminds\MultiUserAccounts\Console\Command\ImportCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Filesystem\DirectoryList $directoryList, \Cminds\MultiUserAccounts\Model\Import $import)
    {
        $this->___init();
        parent::__construct($directoryList, $import);
    }

    /**
     * {@inheritdoc}
     */
    public function run(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'run');
        if (!$pluginInfo) {
            return parent::run($input, $output);
        } else {
            return $this->___callPlugins('run', func_get_args(), $pluginInfo);
        }
    }
}
