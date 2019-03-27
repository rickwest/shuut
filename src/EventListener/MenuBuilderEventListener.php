<?php

namespace App\EventListener;

use App\Menu\MenuBuilder;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class MenuBuilderEventListener
{
    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var MenuBuilder
     */
    private $menuBuilder;
    /**
     * MenuBuilderListener constructor.
     * @param \Twig_Environment $twig
     * @param MenuBuilder $menuBuilder
     */
    public function __construct(\Twig_Environment $twig, MenuBuilder $menuBuilder)
    {
        $this->twig = $twig;
        $this->menuBuilder = $menuBuilder;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $this->twig->addGlobal('menu', $this->menuBuilder->build());
    }
}