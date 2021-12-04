<?php

namespace fcab\theme;

class Menu
{
    private array $items;
    private string $title;

    /**
     * Menu constructor.
     * @param array|null $items
     * @param string $title
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

    public function addItem(MenuItem $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @param int $submenu_id
     * @param MenuItem $menu_item
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
        if (count($this->items) > 0) {
            foreach ($this->items as $item) {
                $str .= $item->toHtml();
            }
        }
        $str .= '</ul>';
        return $str;
    }
}
