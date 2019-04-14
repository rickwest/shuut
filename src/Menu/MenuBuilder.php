<?php

namespace App\Menu;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class MenuBuilder
 * @package App\Menu
 */
class MenuBuilder
{
    /** @var RouterInterface $router */
    protected $router;

    /** @var Security $security */
    protected $security;

    /**
     * MenuBuilder constructor.
     * @param RouterInterface $router
     * @param Security $security
     */
    public function __construct(
        RouterInterface $router,
        Security $security
    ) {
        $this->router = $router;
        $this->security = $security;
    }

    /**
     * @return Menu
     */
    public function build()
    {
        // Create a new menu instance
        $menu = new Menu();

        // Check for an authenticated user and build appropriate menu
        if ($this->security->getToken() && $this->security->isGranted('ROLE_ADMIN')) {
            $menu
                ->addItem($this->item('index', 'Dashboard', ['icon' => 'icon-speedometer']))
                ->addItem($this->item('', 'Jobs', ['isTitle' => true]))
                ->addItem($this->item('job_index', 'Jobs', ['icon' => 'icon-directions']))
                ->addItem($this->item('', 'Quotes', ['isTitle' => true]))
                ->addItem($this->item('', 'Quotes', ['icon' => 'icon-map'])
                    ->addChild($this->item('quote_index', 'Quotes', ['icon' => 'icon-map']))
                    ->addChild($this->item('quote_new', 'New Quote', ['icon' => 'icon-plus'])))
                ->addItem($this->item('', 'Assets', ['isTitle' => true]))
                ->addItem($this->item('customer_index', 'Customers', ['icon' => 'icon-layers']))
                ->addItem($this->item('vehicle_index', 'Vehicles', ['icon' => 'icon-rocket']))
                ->addItem($this->item('driver_index', 'Drivers', ['icon' => 'icon-people']))
            ;
        } else {
            // no menu to build
        }

        return $menu;
    }

    /**
     * @param $route
     * @param $label
     * @param $options
     * @return MenuItem
     */
    public function item($route, $label, $options)
    {
        return new MenuItem(empty($route) ? '' : $this->router->generate($route), $label, $options);
    }
}