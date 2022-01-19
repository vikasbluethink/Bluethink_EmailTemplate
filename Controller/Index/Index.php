<?php

namespace Bluethink\EmailTemplate\Controller\Index;

use Bluethink\EmailTemplate\Model\Mail\TransportBuilder;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $storeManager;
	protected $_transportBuilder;
	protected $inlineTranslation;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
		\Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
		$this->storeManager = $storeManager;
		$this->_transportBuilder = $transportBuilder;
		$this->inlineTranslation = $inlineTranslation;
		return parent::__construct($context);
	}

	public function execute()
	{

		$templateOptions = array('area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->storeManager->getStore()->getId());
		$templateVars = array(
							'store' => $this->storeManager->getStore(),
							'customer_name' => 'John Doe',
							'message'	=> 'Hello World!!.'
						);
		$from = array('email' => "vikas.bluethink63062@gmail.com", 'name' => 'Bluethink');
		$this->inlineTranslation->suspend();
		$to = array('vikas.bluethink63062@gmail.com');
		$transport = $this->_transportBuilder->setTemplateIdentifier('test_emailTemplate')
						->setTemplateOptions($templateOptions)
						->setTemplateVars($templateVars)
						->setFrom($from)
						->addTo($to)
						->getTransport();
		$transport->sendMessage();
		$this->inlineTranslation->resume();

		return $this->_pageFactory->create();
	}

}
