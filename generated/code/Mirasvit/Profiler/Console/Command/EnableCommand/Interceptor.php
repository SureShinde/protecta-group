<?php
namespace Mirasvit\Profiler\Console\Command\EnableCommand;

/**
 * Interceptor class for @see \Mirasvit\Profiler\Console\Command\EnableCommand
 */
class Interceptor extends \Mirasvit\Profiler\Console\Command\EnableCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Profiler\Model\Config $config, \Magento\Framework\App\State $appState)
    {
        $this->___init();
        parent::__construct($config, $appState);
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
