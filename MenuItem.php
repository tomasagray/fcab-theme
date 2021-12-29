<?php


class MenuItem
{
    private int $id;
    private string $url;
    private string $title;
    private ?Menu $submenu;

    /**
     * MenuItem constructor.
     * @param int $id
     * @param string $url
     * @param string $title
     * @param Menu|null $submenu
     */
    public function __construct(int $id, string $url, string $title, Menu $submenu = null)
    {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->submenu = $submenu;
    }

    /**
     * @return Menu
     */
    public function getSubmenu(): Menu
    {
        return $this->submenu;
    }

    /**
     * @param Menu $submenu
     */
    public function setSubmenu(Menu $submenu): void
    {
        $this->submenu = $submenu;
    }

    public function addSubmenuItem(MenuItem $item): void
    {
        if ($this->submenu === null) {
            $this->setSubmenu(new Menu(null, ''));
        }
        $this->submenu->addItem($item);
    }

    public function toHtml(string $class = null): string
    {
        if ($class === null) {
            $class = 'menu-item';
        }

        $str = '<li id="menu-item-' . $this->getId() . '" class="' . $class . '">'
            . '<div class="menu-item-container">'
            . '<a href="' . $this->getUrl() . '">' . $this->getTitle() . '</a>';
        if ($this->submenu !== null) {
            $str .= '<img src="' . get_template_directory_uri() . '/img/mobile-menu-arrow.png"'
                . ' class="mobile-submenu-arrow" alt="Expand submenu"/>'
                . '</div>';
            $str .= $this->submenu->toHtml('sub-menu');
        } else {
            $str .= '</div>';
        }
        $str .= '</li>';
        return $str;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
