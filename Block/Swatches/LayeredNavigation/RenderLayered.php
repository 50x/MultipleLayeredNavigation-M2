<?php
/**
 * Multiple Layered Navigation
 * 
 * @author Slava Yurthev
 */
namespace SY\MultipleLayeredNavigation\Block\Swatches\LayeredNavigation;

use Magento\Catalog\Model\Layer\Filter\Item as FilterItem;
use Magento\Eav\Model\Entity\Attribute\Option;

class RenderLayered extends \Magento\Swatches\Block\LayeredNavigation\RenderLayered
{
    const ACTIVE_SWATCH_CLASS = 'active';

    /**
     * @var \SY\MultipleLayeredNavigation\Model\Url\Builder
     */
	protected $urlBuilder;

    /**
     * RenderLayered constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Eav\Model\Entity\Attribute $eavAttribute
     * @param \Magento\Catalog\Model\ResourceModel\Layer\Filter\AttributeFactory $layerAttribute
     * @param \Magento\Swatches\Helper\Data $swatchHelper
     * @param \Magento\Swatches\Helper\Media $mediaHelper
     * @param \SY\MultipleLayeredNavigation\Model\Url\Builder $urlBuilder
     * @param array $data
     */
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Eav\Model\Entity\Attribute $eavAttribute,
		\Magento\Catalog\Model\ResourceModel\Layer\Filter\AttributeFactory $layerAttribute,
		\Magento\Swatches\Helper\Data $swatchHelper,
		\Magento\Swatches\Helper\Media $mediaHelper,
		\SY\MultipleLayeredNavigation\Model\Url\Builder $urlBuilder,
		array $data = []
	) {
		$this->urlBuilder = $urlBuilder;
		parent::__construct(
			$context,
			$eavAttribute,
			$layerAttribute,
			$swatchHelper,
			$mediaHelper,
			$data
		);
	}

    /**
     * @param string $attributeCode
     * @param int $optionId
     * @return string
     */
	public function buildUrl($attributeCode, $optionId)
    {
		if (in_array($optionId, $this->urlBuilder->getValuesFromUrl($attributeCode))) {
			return $this->urlBuilder->getRemoveFilterUrl($attributeCode, $optionId);
		} else {
			return $this->urlBuilder->getFilterUrl($attributeCode, $optionId);
		}
	}

    /**
     * @param FilterItem $filterItem
     * @param Option $swatchOption
     * @return array
     */
    protected function getOptionViewData(FilterItem $filterItem, Option $swatchOption)
    {
        $optionViewdata = parent::getOptionViewData($filterItem, $swatchOption);

        $customStyle = $optionViewdata['custom_style'];

        if ($filterItem->isActive()) {
            $customStyle .= ' ' . self::ACTIVE_SWATCH_CLASS;
            $optionViewdata['custom_style'] = $customStyle;
        }

        return $optionViewdata;
    }
}
