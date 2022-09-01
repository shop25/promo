<?php

namespace S25\Promo;


class PlaceFilter
{
    public function __construct(private array $filters)
    {
    }

    /**
    * 1. empty in
    * 2. хотябы один из множетсва $conditions входит в $in
    * 3. empty notIn
    * 4. ни один из $conditions не должен входить в $notIn
    *
    * @param string[] $conditions
    * @return bool
    */
    public function isValid(array $conditions): bool
    {
        $isValid = false;

        foreach ($this->filters as $filters) {
            ['in' => $inConditions, 'notIn' => $notInConditions] = $filters;

            $isValidInConditions = empty($inConditions);

            if (!$isValidInConditions) {
                $isValidInConditions = !empty(array_intersect($conditions, $inConditions));
            }

            // Если $inConditions не валидные то нет смысла проверять $notInConditions
            if (!$isValidInConditions) {
                continue;
            }

            $isValidNotInConditions = empty($notInConditions);

            if (!$isValidNotInConditions) {
                $isValidNotInConditions = empty(array_intersect($conditions, $notInConditions));
            }

            if ($isValidNotInConditions) {
                $isValid = true;

                break;
            }
        }

        return $isValid;
    }
}