<?php

namespace Brainvire\Cache\Model\Cache;

class Type extends \Magento\Framework\Cache\Frontend\Decorator\TagScope
{
    /**
     * Type Code for Cache. It should be unique
     */
    const TYPE_IDENTIFIER = 'customcache';

    /**
     * Tag of Cache
     */
    const CACHE_TAG = 'CUSTOMCACHE';

    /**
     * @param \Magento\Framework\App\Cache\Type\FrontendPool $cacheFrontendPool
     */
    public function __construct(    
        \Magento\Framework\App\Cache\Type\FrontendPool $cacheFrontendPool
    ){
        parent::__construct(    
            $cacheFrontendPool->get(self::TYPE_IDENTIFIER), 
            self::CACHE_TAG
        );
    }
}