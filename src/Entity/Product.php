<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read-product"}},
 *     attributes={"pagination_items_per_page"=20}
 * )
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read-product"})
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read-product"})
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read-product"})
     */
    private $productName;

    /**
     * @ORM\Column(type="float")
     * @Groups({"read-product"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     * @Groups({"read-product"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read-product"})
     */
    private $tag;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read-product"})
     */
    private $productMaterial;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Groups({"read-product"})
     */
    private $imageUrl;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read-product"})
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="product")
     * @Groups({"read-product"})
     */
    private $reviews;

    /**
     * @ORM\Column(type="string", length=500)
     * @Groups({"read-product"})
     */
    private $category;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getProductMaterial(): ?string
    {
        return $this->productMaterial;
    }

    public function setProductMaterial(string $productMaterial): self
    {
        $this->productMaterial = $productMaterial;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setProduct($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getProduct() === $this) {
                $review->setProduct(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }
}
