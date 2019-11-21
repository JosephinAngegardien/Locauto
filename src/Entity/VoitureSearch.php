<?php

namespace App\Entity;

class VoitureSearch{

    /**
     * @var int | null
     */
    private $maxTarif;

    /**
     * @var string | null
     */
    private $marque;

    /**
     * @var string | null
     */
    private $categorie;

    /**
     * @var string | null
     */
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
    public function setMarque(string $marque)
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
    public function setCategorie(string $categorie)
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
    public function setAgence(string $agence)
    {
        $this->agence = $agence;

        return $this;
    }
}

