<?php

namespace DimeConsole;

use Symfony\Component\Console\Application;
use Stecman\Component\Symfony\Console\BashCompletion\CompletionCommand;
use Stecman\Component\Symfony\Console\BashCompletion\CompletionHandler;
use Stecman\Component\Symfony\Console\BashCompletion\Completion;

/**
 * Class DimeShellCompletionCommand
 * @package DimeConsole
 * @author Thomas Jez
 * applies Stecman Tab completion to the dime console
 *
 */
class DimeShellCompletionCommand extends CompletionCommand
{
    protected  function configureCompletion(CompletionHandler $handler)
    {
        $taskCompletion = new Completion(
            'activities',
            'task',
            Completion::TYPE_ARGUMENT,
            [
                'show',
                'resume',
                'stop',
                'interactive'
            ]
        );

        $idCompletion = new Completion(
            'activities',
            'id',
            Completion::TYPE_OPTION,
            function() {
                $controller = new DimeShellController($this->getApplication()->getServices()->get('client'));
                return $controller->requestActivityIds();
            }
        );

        $nameCompletion = new Completion(
            'activities',
            'name',
            Completion::TYPE_OPTION,
            function() {
                $controller = new DimeShellController($this->getApplication()->getServices()->get('client'));
                return array_keys($controller->requestActivityNames());
            }
        );

        $handler->addHandlers([$taskCompletion, $idCompletion, $nameCompletion]);
    }
}
