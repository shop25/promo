<?php

namespace S25\Promo;


class PromoPlace
{
    private array $conditions = [];

    public function __construct(
        private string $name,
        private string $classes,
        private string $style,
        private string $url,
        public PlaceFilter $filter,
    ) {}

    /**
     * @param string[] $conditions
     * @return void
     */
    public function setConditions(array $conditions = []): void {
        $this->conditions = $conditions;
    }

    private function getConditions(): array {
        return $this->conditions;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStyle(): string
    {
        return $this->style;
    }

    public function getClasses(): string
    {
        return $this->classes;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getIframeSrc(): string
    {
        $conditions = $this->getConditions();
        $filterQuery = '';

        if (!empty($conditions)) {
            $joinedConditions = urlencode(implode(',', $conditions));
            $filterQuery = "?filter={$joinedConditions}";
        }

        return"{$this->getUrl()}$filterQuery";
    }
}
