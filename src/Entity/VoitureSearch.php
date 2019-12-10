<?php

namespace App\Entity;

use App\Entity\Marque;

class VoitureSearch{

    private $maxTarif;

    private $minTarif;

    private $marque;

    private $categorie;

    private $agence;


    /**
     * Get | null
     *
     * @return  int
     */ 
    public function getMaxTarif()
    {
        return $this->maxTarif;
    }

    /**
     * Set | null
     *
     * @param  int  $maxTarif  | null
     *
     * @return  self
     */ 
    public function setMaxTarif(int $maxTarif)
    {
        $this->maxTarif = $maxTarif;

        return $this;
    }

    /**
     * Get | null
     *
     * @return  string
     */ 
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set | null
     *
     * @param  string  $marque  | null
     *
     * @return  self
     */ 
    public function setMarque(Marque $marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get | null
     *
     * @return  string
     */ 
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set | null
     *
     * @param  string  $categorie  | null
     *
     * @return  self
     */ 
    public function setCategorie(Categorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get | null
     *
     * @return  string
     */ 
    public function getAgence()
    {
        return $this->agence;
    }

    /**
     * Set | null
     *
     * @param  string  $agence  | null
     *
     * @return  self
     */ 
    public function setAgence(Agence $agence)
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * Get the value of minTarif
     */ 
    public function getMinTarif()
    {
        return $this->minTarif;
    }

    /**
     * Set the value of minTarif
     *
     * @return  self
     */ 
    public function setMinTarif($minTarif)
    {
        $this->minTarif = $minTarif;

        return $this;
    }
}

