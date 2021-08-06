<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Core\Annotation\ApiFilter;

use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 *      collectionOperations={
 *          "get",
 *          "post"={
 *              "security"="is_granted('ROLE_PRO')",
 *          },
 *          "create_annonce"={
 *              "method"= "POST",
 *              "openapi_context"={
 *                  "summary"     = "Create an announce",
 *                  "description" = "# Create an announce",
 *                  "requestBody" = {
 *                      "content" = {
 *                          "application/json" = {
 *                              "schema"  = {
 *                                  "type"       = "object",
 *                                  "properties" =
 *                                      {
 *                                          "titre"        = {"type" = "string"},
 *                                          "description" = {"type" = "string"},
 *                                          "descComplete" = {"type" = "string"},
 *                                          "referenceAnnonce" = {"type" = "string"},
 *                                          "miseEnCirculation" = {"type" = "integer"},
 *                                          "kilometrage" = {"type" = "integer"},
 *                                          "prix" = {"type" = "decimal"},
 *                                          "datePublication" = {
 *                                              "type": "string",
 *                                              "format": "date-time"
 *                                          },
 *                                          "carburant.id" = {"type" = "integer"},
 *                                          "modele.id" ={"type" = "integer"},
 *                                          "garage.id" ={"type" = "integer"},
 *                                      },
 *                              },
 *                              "example" = {
 *                                  "titre"        = "Une annonce random",
 *                                  "description" = "Une description random",
 *                                  "descComplete" = "Une description random un peu plus complete",
 *                                  "referenceAnnonce"= "10caracter",
 *                                  "miseEnCirculation" = 2002,
 *                                  "kilometrage" = 12000,
 *                                  "prix" = "10000.99",
 *                                  "datePublication" = "2021-08-06 11:46",
 *                                  "carburant.id" = 2,
 *                                  "modele.id" = 4,
 *                                  "garage.id" = 8,    
 *                              },
 *                          },
 *                      },
 *                  },
 *              },
 *          },
 *      },
 *      itemOperations={
 *          "get",
 *          "put"={
 *              "security"="is_granted('ROLE_ADMIN') or object.garage.professionnel == user"
 *          },
 *          "delete"={
 *              "security"="is_granted('ROLE_ADMIN') or object.garage.professionnel == user"
 *          },
 *          "patch"={
 *              "security"="is_granted('ROLE_ADMIN') or object.garage.professionnel == user"
 *          }
 *      },
 *      normalizationContext={"groups"={"annonce:get"}},
 *      denormalizationContext={"groups"={"annonce:post"}},
 * )
 * @ApiFilter(SearchFilter::class, properties={"referenceAnnonce"="partial",
 * "miseEnCirculation"="partial","carburant.type"="partial","modele.denomination"="partial",
 * "modele.marque.nom"="partial","garage.nom"="partial","garage.ville"="partial", "garage.codePostal"="partial"})
 * @ApiFilter(RangeFilter::class, properties={"kilometrage", "miseEnCirculation", "prix"})
 * @ApiFilter(NumericFilter::class, properties={"miseEnCirculation"})
 * @ApiFilter(DateFilter::class, properties={"datePublication"})
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"annonce:get", "annonce:post", "garage:get", "images:get", "modele:get"}),
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"annonce:get", "annonce:post"})
     * @Assert\NotBlank(
     *      message="Description ne peut pas être vide"
     * )
     * @Assert\NotNull(
     *      message="Description ne peut pas être null"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=500)
     * @Groups({"annonce:post"})
     * @Assert\NotBlank(
     *      message="Description complete ne peut pas être vide"
     * )
     * @Assert\NotNull(
     *      message="Description complete ne peut pas être null"
     * )
     */
    private $descComplete;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"annonce:get", "annonce:post", "garage:get", "images:get", "modele:get"})
     * @Assert\NotBlank(
     *      message="La reference d'annonce ne peut pas être vide"
     * )
     * @Assert\NotNull(
     *      message="La reference d'annonce ne peut pas être null"
     * )
     * @Assert\Length(
     *      min = 10,
     *      max = 10,
     *      minMessage = "La reference de l'annonce doit contenir exactement 10 caractères",
     *      maxMessage = "La reference de l'annonce doit contenir exactement 10 caractères"
     * )
     */
    private $referenceAnnonce;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"annonce:get", "annonce:post"})
     * @Assert\Type(
     *     type="integer",
     *     message="La mise en circulation de l'annonce doit être un entier."
     * )
     * @Assert\NotBlank(
     *      message="La mise en circulation de l'annonce ne peut pas être vide"
     * )
     * @Assert\NotNull(
     *      message="La mise en circulation de l'annonce ne peut pas être null"
     * )
     * @Assert\Positive(
     *      message="La mise en circulation de l'annonce doit être un nombre positif"
     * )
     */
    private $miseEnCirculation;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"annonce:get", "annonce:post"})
     * @Assert\Type(
     *     type="integer",
     *     message="Le kilométrage doit être un entier."
     * )
     * @Assert\NotBlank(
     *      message="Le kilométrage ne peut pas être vide"
     * )
     * @Assert\NotNull(
     *      message="Le kilométrage ne peut pas être null"
     * )
     * @Assert\Positive(
     *      message="Le kilométrage doit être un nombre positif"
     * )
     */
    private $kilometrage;

    /**
     * @ORM\Column(type="decimal")
     * @Groups({"annonce:get", "annonce:post"})
     * @Assert\Type(
     *     type="double",
     *     message="Le prix doit être un ciffre à virgule."
     * )
     * @Assert\NotBlank(
     *      message="Le prix ne peut pas être vide"
     * )
     * @Assert\NotNull(
     *      message="Le prix ne peut pas être null"
     * )
     * @Assert\Positive(
     *      message="Le prix doit être un nombre positif"
     * )
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"annonce:get", "annonce:post", "garage:get", "images:get", "modele:get"})
     */
    private $datePublication;

    /**
     * @ORM\ManyToOne(targetEntity=Carburant::class, inversedBy="annonces")
     * @Groups({"annonce:get", "annonce:post"})
     */
    public $carburant;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="annonce")
     * @Groups({"annonce:get", "annonce:post"})
     */
    public $images;

    /**
     * @ORM\ManyToOne(targetEntity=Modele::class, inversedBy="annonces")
     * @Groups({"annonce:get", "annonce:post"})
     */
    public $modele;

    /**
     * @ORM\ManyToOne(targetEntity=Garage::class, inversedBy="annonces")
     * @Groups({"annonce:get", "annonce:post"})
     */
    public $garage;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->titre;
    }

    public function setTitle(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescComplete(): ?string
    {
        return $this->descComplete;
    }

    public function setDescComplete(string $descComplete): self
    {
        $this->descComplete = $descComplete;

        return $this;
    }

    public function getReferenceAnnonce(): ?string
    {
        return $this->referenceAnnonce;
    }

    public function setReferenceAnnonce(string $referenceAnnonce): self
    {
        $this->referenceAnnonce = $referenceAnnonce;

        return $this;
    }

    public function getMiseEnCirculation(): ?int
    {
        return $this->miseEnCirculation;
    }

    public function setMiseEnCirculation(int $miseEnCirculation): self
    {
        $this->miseEnCirculation = $miseEnCirculation;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getCarburant(): ?Carburant
    {
        return $this->carburant;
    }

    public function setCarburant(?Carburant $carburant): self
    {
        $this->carburant = $carburant;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAnnonce($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAnnonce() === $this) {
                $image->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getModele(): ?Modele
    {
        return $this->modele;
    }

    public function setModele(?Modele $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getGarage(): ?Garage
    {
        return $this->garage;
    }

    public function setGarage(?Garage $garage): self
    {
        $this->garage = $garage;

        return $this;
    }
}
