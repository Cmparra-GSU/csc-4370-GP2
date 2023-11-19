<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once 'inventory.php';

class Character {
    public $name;
    public $level;
    public $experience;
    public $maxHealth;
    public $currentHealth;
    public $maxMana;
    public $currentMP; 
    public $status;
    public $alignment;
    public $alignmentIndex;
    public $stats;
    public $cash;
    public $skills;
    public $spellbook;
    public $equipment;
    public $inventory;
    public $currentMap;
    public $xCoordinate;
    public $yCoordinate;

    public function __construct($name) {
        $this->generatePassword();
        $this->name = $name;
        $this->level = 1;

        $this->maxHealth = 25; 
        $this->currentHealth = $this->maxHealth;
        $this->status = "Normal"; 
        $this->stats = [
            'strength' => 5,
            'vitality' => 5,
        ];
        $this->cash = 15;
        $this->inventory = new Inventory();
        $this->currentMap = "field-one.php";
        $this->xCoordinate = 0;
        $this->yCoordinate = 0;


    }

    function generatePassword($length = 8) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
    
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        return $password;
    }
    public function loadSkills() {
        $skillsArray = [];
      
        if (isset($_COOKIE['characterSkills'])) {
          $skillsArray = unserialize($_COOKIE['characterSkills']);
      
          if (empty($skillsArray)) {
            $skillsArray = [];
          }
        }

        $skillbook = new Skillbook();
        $skillbook->loadSkills($skillsArray);
      
        $this->skills = $skillbook;
      }      
      
    public function updatePosition($map, $x, $y) {
        $this->currentMap = $map;
        $this->xCoordinate = $x;
        $this->yCoordinate = $y;
    }

    public function getAlignment() {
        return $this->alignment;
    }

    public function setAlignment($alignment) {
        $this->alignment = $alignment;
        if ($alignment == "Law") {
            $this->spellbook = new LawSpellbook();
        } elseif ($alignment == "Chaos") {
            $this->spellbook = new ChaosSpellbook();
        } else {
            $this->spellbook = new NeutralSpellbook();
        }
    }
    public function getAlignmentIndex() {
        return $this->alignmentIndex;
    }

    public function setAlignmentIndex($alignmentIndex) {
        $this->alignmentIndex = $alignmentIndex;
    }

    public function adjustAlignmentIndex($change) {
        $newAlignmentIndex = $this->alignmentIndex + $change;
        $this->setAlignmentIndex(max(min($newAlignmentIndex, 5), -5));
    }

    public function useItem($itemName) {
        global $items;
        if (isset($items[$itemName])) {
            $item = $items[$itemName];
    
            switch ($item['effect']) {
                case 'Heal':
                    $this->heal($item['amount']);
                    break;
                case 'Strength':
                    $this->increaseStat('strength', $item['amount']);
                    break;
                case 'Vitality':
                    $this->increaseStat('vitality', $item['amount']);
                    break;
            }
    
            
            $this->inventory->removeItem($itemName);
        }
    }
    
    
    private function increaseStat($statName, $amount) {
        if (isset($this->stats[$statName])) {
            $this->stats[$statName] += $amount;
        }
    }
    

    private function heal($amount) {
        $this->currentHealth = min($this->currentHealth + $amount, $this->maxHealth);
    }


    public function takeDamage($damage) {

        $this->currentHealth -= $damage;

        if ($this->currentHealth < 0) {
            $this->currentHealth = 0;
        }
    }

    public function saveSkills() {
        $skillsArray = serialize($this->skills->getSkills());

        if (isset($_SESSION['characterName'])) {
            $characterName = $_SESSION['characterName'];
            setcookie('characterSkills', $skillsArray, time() + 3600, '/');
        }
    }
    
}


?>