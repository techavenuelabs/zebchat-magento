<?php
/**
 * ZebChat settings page in the Magento admin.
 *
 * @package   ZebChat
 * @copyright (C) 2026 Tech Avenue Labs
 * @license   GNU General Public License version 2 or later; see https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Zebchat\Widget\Controller\Adminhtml\Settings;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Zebchat\Widget\Model\Connection;

class Index extends Action
{
    public const ADMIN_RESOURCE = 'Zebchat_Widget::settings';

    public function __construct(
        Context $context,
        private readonly PageFactory $pages,
        private readonly Connection $connection,
        private readonly StoreManagerInterface $stores,
        private readonly CacheInterface $cache
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $app = $this->connection->app();
        $store = $this->stores->getStore();
        $host = \ZebChatApp::host($store->getBaseUrl());
        if ($this->getRequest()->isPost()) {
            if (!$this->_formKeyValidator->validate($this->getRequest())) {
                $this->messageManager->addErrorMessage(__('The form expired. Try again.'));
            } else {
                $app->handle(
                    $this->getRequest()->getPostValue() ?: [],
                    $host,
                    \ZebChatApp::allowedHosts($host),
                    (string) $store->getName()
                );
                $this->cache->clean(['zebchat_widget']);
            }
            return $this->resultRedirectFactory->create()->setPath('zebchat/settings/index');
        }
        $page = $this->pages->create();
        $page->getConfig()->getTitle()->prepend(__('ZebChat'));
        $token = $this->_formKey->getFormKey();
        $hidden = '<input type="hidden" name="form_key" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '" />';
        $html = $app->render($host, (string) $store->getName(), $this->getUrl('zebchat/settings/index'), $hidden);
        $text = $page->getLayout()->createBlock(\Magento\Framework\View\Element\Text::class, 'zebchat.settings');
        $text->setText($html);
        $page->getLayout()->setChild('content', 'zebchat.settings', 'zebchat.settings');
        return $page;
    }
}
