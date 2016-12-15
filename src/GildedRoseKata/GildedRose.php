<?php

namespace Kata\GildedRoseKata;

class GildedRose
{

    private $items;

    function __construct($items)
    {
        $this->items = $items;
    }

    function update_quality()
    {
        foreach ($this->items as $item)
        {
            $this->factory_method($item);

            if ($item->name != 'Aged Brie' and $item->name != 'Backstage passes to a TAFKAL80ETC concert')
            {
                $this->decrementQualityOneUnitIfItemNameIsNotSulfuras($item);
            }
            else
            {
                $this->incrementQuality($item);
            }

            if ($item->name != 'Sulfuras, Hand of Ragnaros')
            {
                $item->sell_in = $item->sell_in - 1;
            }

            if ($item->sell_in > 0)
            {
                continue;
            }

            if ($item->name == 'Aged Brie')
            {
                $this->increaseQualityByOneUnitWhenQualitySmallerThanFifty($item);
            }

            if ($item->name != 'Backstage passes to a TAFKAL80ETC concert')
            {
                $this->decrementQualityOneUnitIfItemNameIsNotSulfuras($item);
            }
            else
            {
                $item->quality = $item->quality - $item->quality;
            }
        }
    }

    public function increaseQualityByOneUnitWhenQualitySmallerThanFifty($item): void
    {
        if ($item->quality < 50)
        {
            $item->quality = $item->quality + 1;
        }
    }

    public function decrementQualityOneUnitIfItemNameIsNotSulfuras($item): void
    {
        if ($item->quality > 0)
        {
            if ($item->name != 'Sulfuras, Hand of Ragnaros')
            {
                $item->quality = $item->quality - 1;
            }
        }
    }

    public function incrementQuality($item): void
    {
        if ($item->quality >= 50)
        {
            return;
        }

        $item->quality = $item->quality + 1;

        if ($item->name !== 'Backstage passes to a TAFKAL80ETC concert')
        {
            return;
        }

        $this->incrementQualityForBackstagePasses($item);
    }

    private function incrementQualityForBackstagePasses($item): void
    {
        if ($item->sell_in < 11)
        {
            $this->increaseQualityByOneUnitWhenQualitySmallerThanFifty($item);
        }
        if ($item->sell_in < 6)
        {
            $this->increaseQualityByOneUnitWhenQualitySmallerThanFifty($item);
        }
    }

    private function factory_method($item)
    {
        if ($item->name == BackstagePassesItem::NAME)
        {
            $new_item = BackstagePassesItem::createBackstagePasses($item->sell_in, $item->quality);
        }
        elseif ($item->name == AgedBrieItem::NAME)
        {
            $new_item = AgedBrieItem::createAgedBrieItem($item->sell_in, $item->quality);
        }
        elseif ($item->name == SulfurasItem::NAME)
        {
            $new_item = SulfurasItem::createSulfurasItem($item->sell_in, $item->quality);
        }else{
            $new_item = $item;
        }

        return $new_item;
    }
}

