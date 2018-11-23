<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\Tracy;

use Nette\SmartObject;
use Tracy\IBarPanel;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class MessagePanel implements IBarPanel
{
    use SmartObject;

    /**
     * Renders tab.
     */
    public function getTab(): string
    {
        ob_start();
        require __DIR__ . '/templates/MessagePanel.tab.phtml';
        return ob_get_clean() ?: 'error';
    }

    /**
     * Renders panel.
     */
    public function getPanel(): string
    {
        ob_start();
        require __DIR__ . '/templates/MessagePanel.panel.phtml';
        return ob_get_clean() ?: 'error';
    }
}
