<?php

namespace S25\Promo;


abstract class BasePromotionsClient
{

    /**
     * @var PromoPlace[]
     */
    private array $places;

    function __construct(
         \GuzzleHttp\Client $httpClient,
        private PromotionsClientOptions $options
    ) {
        $response = $httpClient->get($options->getLocationsUrl());
        $contents = $response->getBody()->getContents();
        $result = json_decode($contents, true);

        $conditions = $result['filters'];

        $this->places = [];

        foreach ($result['attributes'] as $item) {
            $name = $item['locationName'];

            $place = new PromoPlace(
                name: $name,
                classes: $item['classes'],
                style: $item['style'],
                url: $item['url'],
                filter: new PlaceFilter($conditions[$name]),
            );

            $this->places[$name] = $place;
        }
    }

    public function getOptions(): PromotionsClientOptions
    {
        return $this->options;
    }

    /**
     * @param string $name
     * @param string[] $conditions
     * @return PromoPlace|null
     */
    protected function getPlace(string $name, array $conditions = []): PromoPlace|null
    {
        $place = $this->places[$name] ?? null;

        if ($place instanceof PromoPlace) {
            if ($place->filter->isValid($conditions)) {
                if (!empty($conditions)) {
                    $place->setConditions($conditions);
                }

                return $place;
            }
        }

        return null;
    }
}
