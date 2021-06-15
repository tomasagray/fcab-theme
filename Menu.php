<?php

namespace fcab\theme;

class Menu
{
    private array $items;
    private string $title;

    /**
     * Menu constructor.
     * @param array $items
     */
    public function __construct(array $items = null, string $title = '')
    {
        if ($items !== null) {
            $this->items = $items;
        } else {
            $this->items = array();
        }
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function addItem(MenuItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @param int $submenu_id
     * @param Menu $submenu
     * @return bool
     */
    public function addSubMenuItem(int $submenu_id, MenuItem $menu_item): bool
    {
        foreach ($this->items as $item) {
            if ($item->getId() === $submenu_id) {
                $item->addSubmenuItem($menu_item);
                return true;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    public function toHtml(string $class = null): string
    {
        if ($class === null) {
            $class = 'nav-menu';
        }
        $str = '<ul class="'.$class.'" id="'.$this->title.'">';
        if ($this->items !== null) {
            foreach ($this->items as $item) {
                $str .= $item->toHtml();
            }
        }
        $str .= '</ul>';
        return $str;
    }
}
