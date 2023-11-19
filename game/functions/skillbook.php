<?php
include_once('skills.php');
class Skillbook {
    private $skills = [];
    private $availableSkills = [];
    private $maxAvailableSkills = 4; 

    public function __construct() {
        
        $this->learnSkill("Attack");
        $this->loadSkills(1); 
    }

    public function getSkills() {
        return $this->skills;
    }

    public function getAvailableSkills() {
        return $this->availableSkills;
    }

    public function learnSkill($skillName) {
        
        

        
        if (!in_array($skillName, $this->skills)) {
            $this->skills[] = $skillName;

            
            if (($key = array_search($skillName, $this->availableSkills)) !== false) {
                unset($this->availableSkills[$key]);
            }
        }
    }

    public function forgetSkill($skillName) {
        
        $key = array_search($skillName, $this->skills);
        if ($key !== false) {
            unset($this->skills[$key]);
        }
    }
    public function loadSkills($skillData) {
        $this->skills = []; 
    
        if (!empty($skillData)) {
            
            $skillsArray = explode(',', $skillData);
    
            foreach ($skillsArray as $skill) {
                if (isset($skill)) {
                    
                    $this->skills[] = $skill;
                }
            }
        }
    }
    
      

    public function addAvailableSkill($skillName) {
        
        

        if (count($this->availableSkills) < $this->maxAvailableSkills) {
            $this->availableSkills[] = $skillName;
        }
    }
}


?>