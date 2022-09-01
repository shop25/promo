## Description
Package for connecting promotion to the project.

## Install

```bash
composer require s25/promo
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
2. Create the promo client facade
```php
use S25\Promo;

class PromotionClientFacade
{
    private static PromotionsClient|null $instance;
    private static bool $isSet = false;

    public static function getInstance(): PromotionsClient|null
    {
        if (!self::$isSet) {
            try{
                self::$isSet = true;

                $options = new PromotionsClientOptions('host', 'project', 'ru');

                self::$instance = new PromotionsClient(new \GuzzleHttp\Client(), $options);
            } catch (Exception) {
                self::$instance = null;
            }
        }

        return self::$instance;
    }
}
```
3. Create template
```php
<?php $promotionPlace = PromotionClientFacade::getInstance()?->getHeaderPlace() ?>


<?php if($promotionPlace !== null): ?>
  <div
       [data-location-name="<?= $promotionPlace->getName() ?>"
       class="<?= $promotionPlace->getClasses() ?>"
       style="<?= $promotionPlace->getStyle() ?>"
  >
    <iframe src="<?= $promotionPlace->getIframeSrc()?>"></iframe>
  </div>
<?php endif; ?>
```
4. Javascript
```bash
npm i @shop25/banners-client
```
```js
import { PromotionClient } from '@shop25/banners-client'
import '@shop25/banners-client/dist/style.css'

const element = document.querySelector('[my-selector]')
const location = client.createLocation('header')

location.mount(element).then(() => console.log('mounted'))

// if need destroy
location.destroy()
```