<?php //strict

namespace LayoutCore\Services;

use Plenty\Modules\Basket\Contracts\BasketRepositoryContract;
use Plenty\Modules\Basket\Contracts\BasketItemRepositoryContract;
use Plenty\Modules\Basket\Models\Basket;
use Plenty\Modules\Basket\Models\BasketItem;
use Plenty\Modules\Item\DataLayer\Models\RecordList;
use Plenty\Modules\Item\DataLayer\Models\Record;

use LayoutCore\Services\ItemService;

/**
 * Class BasketService
 * @package LayoutCore\Services
 */
class BasketService
{
	/**
	 * @var BasketRepositoryContract
	 */
	private $basketRepository;
	/**
	 * @var BasketItemRepositoryContract
	 */
	private $basketItemRepository;
	/**
	 * @var ItemService
	 */
	private $itemService;
    
    /**
     * BasketService constructor.
     * @param BasketRepositoryContract $basketRepository
     * @param BasketItemRepositoryContract $basketItemRepository
     * @param \LayoutCore\Services\ItemService $itemService
     */
	public function __construct(
		BasketRepositoryContract $basketRepository,
		BasketItemRepositoryContract $basketItemRepository,
		ItemService $itemService
	)
	{
		$this->basketRepository     = $basketRepository;
		$this->basketItemRepository = $basketItemRepository;
		$this->itemService          = $itemService;
	}

	/**
	 * Returns basket as array
	 * @return Basket
	 */
	public function getBasket():Basket
	{
		return $this->basketRepository->load();
	}
    
    /**
     * get list of basket items
     * @return array
     */
	public function getBasketItems():array
	{
		$result = array();
        $basketItems = $this->basketItemRepository->all();
        $basketItemData = $this->getBasketItemData( [$basketItems] );
        foreach( $basketItems as $basketItem )
        {
            array_push(
                $result,
                $this->addVariationData($basketItem, $basketItemData[$basketItem->variationId])
            );
        }
        return $result;
	}
    
    /**
     * get one basket item
     * @param int $basketItemId
     * @return array
     */
	public function getBasketItem(int $basketItemId):array
	{
		$basketItem = $this->basketItemRepository->findOneById( $basketItemId );
        if( $basketItem === null )
        {
            return array();
        }
        $basketItemData = $this->getBasketItemData( array($basketItem) );
        return $this->addVariationData( $basketItem, $basketItemData[$basketItem->variationId] );
    }
    
    /**
     * load variation data for basket item
     * @param BasketItem $basketItem
     * @param $variationData
     * @return array
     */
	private function addVariationData( BasketItem $basketItem, $variationData ):array
    {
        $arr = $basketItem->toArray();
        $arr["variation"] = $variationData;
        return $arr;
    }
    
    /**
     * add item to basket or update
     * @param array $data
     * @return array
     */
	public function addBasketItem(array $data):array
	{
		$basketItem = $this->findExistingOneByData($data);
		if($basketItem instanceof BasketItem)
		{
			$data['id']       = $basketItem->id;
			$data['quantity'] = (int)$data['quantity'] + $basketItem->quantity;
			$this->basketItemRepository->updateBasketItem($basketItem->id, $data);
		}
		else
		{
			$this->basketItemRepository->addBasketItem($data);
		}

		return $this->getBasketItems();
	}
    
    /**
     * update basket item
     * @param int $basketItemId
     * @param array $data
     * @return array
     */
	public function updateBasketItem(int $basketItemId, array $data):array
	{
		$data['id'] = $basketItemId;
		$this->basketItemRepository->updateBasketItem($basketItemId, $data);
		return $this->getBasketItems();
	}
    
    /**
     * delete item from basket
     * @param int $basketItemId
     * @return array
     */
	public function deleteBasketItem(int $basketItemId):array
	{
		$this->basketItemRepository->removeBasketItem($basketItemId);
		return $this->getBasketItems();
	}
    
    /**
     * check if item is already in the basket
     * @param array $data
     * @return null|BasketItem
     */
	public function findExistingOneByData(array $data)
	{
		return $this->basketItemRepository->findExistingOneByData($data);
	}
    
    /**
     * get data of basket items
     * @param array $basketItems
     * @return array
     */
	private function getBasketItemData($basketItems = array()):array
	{
		if(count($basketItems) <= 0)
		{
			return array();
		}

		$basketItemVariationIds = array();
		foreach($basketItems as $basketItem)
		{
			array_push($basketItemVariationIds, $basketItem->variationId);
		}

		$items  = $this->itemService->getVariations($basketItemVariationIds);
		$result = array();
		foreach($items as $item)
		{
			$variationId          = $item->variationBase->id;
			$result[$variationId] = $item;
		}

		return $result;
	}


}
