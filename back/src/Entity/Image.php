<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Validator\Constraints as Assert;

use ApiPlatform\Core\Annotation\ApiProperty;


/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_ADMIN')"
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_PRO')",
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_ADMIN') or object.annonce.garage.professionnel == user"
 *          },
 *          "put"={
 *              "security"="is_granted('ROLE_ADMIN') or object.annonce.garage.professionnel == user"
 *          },
 *          "delete"={
 *              "security"="is_granted('ROLE_ADMIN') or object.annonce.garage.professionnel == user"
 *          },
 *          "patch"={
 *              "security"="is_granted('ROLE_ADMIN') or object.annonce.garage.professionnel == user"
 *          }
 *      },
 *      normalizationContext={"groups"={"images:get"}},
 *      denormalizationContext={"groups"={"annonce:post"}},
 * )
 * @ApiFilter(SearchFilter::class, properties={"annonce.referenceAnnonce"="partial"})
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"images:get", "annonce:post"})
     * @Assert\Type(
     *     type="integer",
     *     message="L'id doit être un entier."
     * )
     * @Assert\Positive(
     *      message="L'id doit être un nombre positif"
     * )
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={"type"="integer", "example"="1"}
     *     }
     * )
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"annonce:get", "images:get"})
     */
    private $legende;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"annonce:get", "images:get"})
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="images")
     * @Groups({"images:get"})
     */
    public $annonce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLegende(): ?string
    {
        return $this->legende;
    }

    public function setLegende(?string $legende): self
    {
        $this->legende = $legende;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }
}
