<?php
/**
 * Storefront widget block.
 *
 * @package   ZebChat
 * @copyright (C) 2026 Tech Avenue Labs
 * @license   GNU General Public License version 2 or later; see https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Zebchat\Widget\Block;

use Magento\Framework\View\Element\Template;
use Zebchat\Widget\Model\Connection;

/**
 * Storefront widget tag. Tagged so saving settings drops the cached pages.
 */
class Script extends Template
{
    public function __construct(
        Template\Context $context,
        private readonly Connection $connection,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function scriptTag(): string
    {
        return $this->connection->app()->scriptTag();
    }

    /**
     * @return string[]
     */
    public function getIdentities(): array
    {
        return ['zebchat_widget'];
    }
}
