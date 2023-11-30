<?php

/**
 * @category     Eclipse
 * @package      Eclipse_Core
 * @subpackage   Model
 * @author       Hubert Kwapisiewicz <hubert.kwapisiewicz@eclipsegroup.co.uk>
 * @copyright    2020 Eclipse
 * @since        1.1.0
 */

declare(strict_types=1);

namespace Eclipse\Core\Model;

use Eclipse\Core\Exception\NullablePathException;
use InvalidArgumentException;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;

class DefaultConfigProvider
{
    /**
     * DefaultConfigProvider constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param Json                 $jsonSerializer
     * @param string               $scopeType
     */
    public function __construct(
        protected ScopeConfigInterface $scopeConfig,
        protected Json $jsonSerializer,
        protected string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT
    ) {
    }

    /**
     * @param string $path
     * @param null   $scopeCode
     *
     * @return string|null
     * @throws NullablePathException
     * @throws InvalidArgumentException
     */
    protected function getOptionalValue(
        string $path,
        $scopeCode = null
    ): ?string {
        if (empty($path)) {
            throw new NullablePathException(__('Config Path cannot be null')->render());
        }

        $value = $this->scopeConfig->getValue($path, $this->scopeType, $scopeCode);

        return is_array($value) ? (string)$this->jsonSerializer->serialize($value) : (string)$value;
    }
}
