<?php

namespace ide\ui;

use php\demonck\animated\layout\UXAnimatedHbox;

use php\gui\layout\UXAnchorPane;
use php\gui\layout\UXVBox;
use php\gui\UXWindow;
use php\lib\num;

class UXModal extends UXVBox
{
    private array $_list;

    public function __construct(string $animation, float $speedIn, float $speedOut)
    {
        parent::__construct();
        UXAnchorPane::setAnchor($this, 0);

        $this->_list = [];
        $this->alignment = "CENTER";
        $this->classes->add("modal");
        $this->enabled =false;
        $this->hide();
    }

    public function showModal($node)
    {
        if (empty($this->_list)) {
            $this->enabled = true;
            $this->show();
            $this->add($node);
        }
        $this->_list[] = $node;
    }

    public function hideModal($node)
    {
        $this->children->remove($node);

        $index = array_search($node, $this->_list, true);
        if ($index !== false) {
            unset($this->_list[$index]);
            $this->_list = array_values($this->_list);
        }

        if (!empty($this->_list)) {
            $newNode = $this->_list[0];
            $this->children->add($newNode);
            return;
        }

        $this->enabled = false;
        $this->hide();
    }
}