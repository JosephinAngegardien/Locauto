<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoitureRepository")
 */
class Voiture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modele;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tarif;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $reference;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     * 
     * @Gedmo\Slug(fields={"modele"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", inversedBy="voitures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agence", inversedBy="voitures")
     */
    private $agence;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Location", mappedBy="voiture", orphanRemoval=true)
     */
    private $locations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie", inversedBy="voitures")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="voiture", cascade={"persist"})
     * @Assert\Url
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="voiture", orphanRemoval=true)
     */
    private $commentaires;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setVoiture($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getVoiture() === $this) {
                $location->setVoiture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->categories->contains($categorie)) {
            $this->categories[] = $categorie;
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        if ($this->categories->contains($categorie)) {
            $this->categories->removeElement($categorie);
        }

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTarif(): ?int
    {
        return $this->tarif;
    }

    public function setTarif(?int $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setVoiture($this);
        }

        return $this;
    }

    public function removeImage(image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getVoiture() === $this) {
                $image->setVoiture(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Permet d'obtenir un tableau des jours où la voiture est réservée
     *
     * @return array Un tableau d'objets DateTime représentant les jours de réservation
     */
    public function getNotAvailableDays() {
        $notAvailableDays = [];

        foreach($this->locations as $location) {
            // Calculer les jours qui se trouvent entre le début et la fin de la location
            $resultat = range(
                $location->getDebut()->getTimestamp(), 
                $location->getFin()->getTimestamp(), 
                24 * 60 * 60
            );
            
            $days = array_map(function($dayTimestamp){
                return new \DateTime(date('Y-m-d', $dayTimestamp));
            }, $resultat);

            $notAvailableDays = array_merge($notAvailableDays, $days);
        }

        return $notAvailableDays;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setVoiture($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getVoiture() === $this) {
                $commentaire->setVoiture(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
      return $this->modele;
    }


}


