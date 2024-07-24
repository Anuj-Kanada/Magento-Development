<?php
declare(strict_types=1);

namespace Brainvire\Studentmgt\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
/**
 * Class Generic
 */
class Generic
{
    /**
     * Url Builder
     *
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Registry
     *
     * @var Registry
     */
    protected $registry;

    /**
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        Registry $registry)
    {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
    }

    /**
     * Return the customer Id.
     *
     * @return int|null
     */
    public function getStdId()
    {
        return $this->registry->registry('current_student');
    }

    /**
     * Getting URL
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}