## Description
Package for connecting promotion to the project.

## Install

```bash
composer install shop25/promo
```

## Usage

1. Create the PromotionClient extended from base class
```php
use S25\Promo;

class PromotionClient extends BasePromotionsClient {

   public function getHeaderPlace(): PromoPlace|null
   {
        return $this->getPlace('header');
   }
   
    public function getCategoryPlace(array $conditions = []): PromoPlace|null
    {
        return $this->getPlace('header', $conditions);
    }
}
```
3. 