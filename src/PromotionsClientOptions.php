<?php

namespace S25\Promo;


class PromotionsClientOptions
{
    public function __construct(
        private string $host,
        private string $project,
        private string $lang
    ) {
        $this->host = trim($this->host, '/');
    }

    public function asJson(): string
    {
        return json_encode(
            [
                'host'    => $this->host,
                'project' => $this->project,
                'lang'    => $this->lang,
            ]
        );
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function getProject(): string
    {
        return $this->project;
    }

    public function getLocationsUrl(): string
    {
        return $this->host.
            "/locations/project/{$this->project}/lang/{$this->lang}";
    }
}
