<?php

include_once 'items.php';

class Inventory {
    private $inventory = [];

    public function addItem($itemName, $quantity = 1) {
        global $items;
        if (isset($items[$itemName])) {
            if (!isset($this->inventory[$itemName])) {
                $this->inventory[$itemName] = 0;
            }
            $this->inventory[$itemName] += $quantity;
            var_dump($this->inventory); 
        }
    }

    public static function getItemName($itemType) {
        switch ($itemType) {
            case 21: return 'Potion';
            case 22: return 'Strength Soul';
            case 23: return 'Vitality Soul';
            default: return '';
        }
    }

    public function removeItem($itemName, $quantity = 1) {
        global $items;

        if (isset($items[$itemName]) && isset($this->inventory[$itemName])) {
            $this->inventory[$itemName] -= $quantity;

            if ($this->inventory[$itemName] <= 0) {
                unset($this->inventory[$itemName]);
            }
        }
    }

    public function getInventory() {
        return $this->inventory;
    }

    public function getItems() {
        include 'items.php'; 
        return $items;
    }

    public function loadItems($itemsData) {
        $this->inventory = []; 

        if (!empty($itemsData)) {
            
            $itemsArray = explode(',', $itemsData);

            foreach ($itemsArray as $item) {
                list($itemName, $quantity) = explode(':', $item);

                
                $quantity = max(1, intval($quantity));

                
                $this->addItem($itemName, $quantity);
            }
        }
    }
}



?>