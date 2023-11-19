<?php
class LawSpellbook {
    private $spells;

    public function __construct() {
        
        $this->spells = [
            "Spell1" => "Description1",
        ];
    }

    
    public function getSpells() {
        
        return [
            'spellA' => 'Description A',
            'spellB' => 'Description B',
            
        ];
    }

    public function loadSpells($spellData) {
        $this->spells = []; 

        if (!empty($spellData)) {
            
            $spellsArray = explode(',', $spellData);

            foreach ($spellsArray as $spell) {
                list($spellName, $description) = explode(':', $spell);

                
                $this->spells[$spellName] = $description;
            }
        }
    }
}



class ChaosSpellbook {
    private $spells;

    public function __construct() {
        
        $this->spells = [
            "SpellA" => "DescriptionA",
        ];
    }

    public function loadSpells($spellData) {
        $this->spells = []; 

        if (!empty($spellData)) {
            
            $spellsArray = explode(',', $spellData);

            foreach ($spellsArray as $spell) {
                list($spellName, $description) = explode(':', $spell);

                
                $this->spells[$spellName] = $description;
            }
        }
    }

    public function getSpells() {
        
        return [
            'spell1' => 'Description 1',
            'spell2' => 'Description 2',
            
        ];
    }
}

class NeutralSpellbook {
    private $spells;

    public function __construct() {
        
        $this->spells = [
            "SpellA" => "DescriptionA",
        ];
    }

    public function loadSpells($spellData) {
        $this->spells = []; 

        if (!empty($spellData)) {
            
            $spellsArray = explode(',', $spellData);

            foreach ($spellsArray as $spell) {
                list($spellName, $description) = explode(':', $spell);

                
                $this->spells[$spellName] = $description;
            }
        }
    }

    public function getSpells() {
        
        return [
            'spellX' => 'Description X',
            'spellY' => 'Description Y',
            
        ];
    }
}
?>