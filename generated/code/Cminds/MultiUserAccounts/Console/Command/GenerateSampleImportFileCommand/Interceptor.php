<?php
namespace Cminds\MultiUserAccounts\Console\Command\GenerateSampleImportFileCommand;

/**
 * Interceptor class for @see \Cminds\MultiUserAccounts\Console\Command\GenerateSampleImportFileCommand
 */
class Interceptor extends \Cminds\MultiUserAccounts\Console\Command\GenerateSampleImportFileCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Cminds\MultiUserAccounts\Model\Import\Validator $importValidator, \Magento\Framework\File\Csv $csvProcessor, \Magento\Framework\App\Filesystem\DirectoryList $directoryList)
    {
        $this->___init();
        parent::__construct($importValidator, $csvProcessor, $directoryList);
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
