<?php

namespace App\Entity;

use App\Enum\CompanyActiveEnum;
use App\Enum\CompanyPlanEnum;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'company', cascade: ['persist'], orphanRemoval: true)]
    private Collection $userId;

    public function __construct(
        #[ORM\Column(length: 255)]
        private ?string $companyName = null,
        #[ORM\Column(length: 255)]
        private ?CompanyActiveEnum $companyActive = null,
        #[ORM\Column(length: 20)]
        private ?string $company_nip = null,
        #[ORM\Column(length: 255)]
        private ?string $email = null,
        #[ORM\Column(length: 20)]
        private ?CompanyPlanEnum $plan = null,
    ) {
        $this->userId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getCompanyActive(): CompanyActiveEnum
    {
        return $this->companyActive;
    }

    public function setCompanyActive(CompanyActiveEnum $companyActive): static
    {
        $this->companyActive = $companyActive;

        return $this;
    }

    public function getCompanyNip(): ?string
    {
        return $this->company_nip;
    }

    public function setCompanyNip(string $company_nip): static
    {
        $this->company_nip = $company_nip;

        return $this;
    }

    public function getPlan(): CompanyPlanEnum
    {
        return $this->plan;
    }

    public function setPlan(CompanyPlanEnum $plan): static
    {
        $this->plan = $plan;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): static
    {
        if (!$this->userId->contains($userId)) {
            $this->userId->add($userId);
            $userId->setCompany($this);
        }

        return $this;
    }

    public function removeUserId(User $userId): static
    {
        if ($this->userId->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getCompany() === $this) {
                $userId->setCompany(null);
            }
        }

        return $this;
    }
}
