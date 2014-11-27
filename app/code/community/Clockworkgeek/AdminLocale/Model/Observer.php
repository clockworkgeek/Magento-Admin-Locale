<?php
/**
 * Clockworkgeek's Admin Locale
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @author      Clockworkgeek (daniel@clockworkgeek.com)
 * @category    Adminhtml
 * @package     Clockworkgeek_AdminLocale
 * @copyright   Copyright (c) 2013 Clockworkgeek
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

class Clockworkgeek_AdminLocale_Model_Observer
{

	/**
	 * Load locale into session before it defaults to global setting.
	 */
	public function loadSessionLocale()
	{
		/* @var $session Mage_Adminhtml_Model_Session */
		$session = Mage::getSingleton('adminhtml/session');

		/* @var $user Mage_Admin_Model_User */
		$user = Mage::getSingleton('admin/session')->getUser();
		if (!$user) return;

		/* @var $extra array */
		$extra = $user->getExtra();
		if (is_string($extra)) {
			$extra = unserialize($extra);
		}
		if (@$extra['locale']) {
			$session->setLocale($extra['locale']);
		}
	}

	/**
	 * Save locale after page is output.
	 */
	public function saveSessionLocale()
	{
		$locale = Mage::getSingleton('adminhtml/session')->getLocale();
		/* @var $user Mage_Admin_Model_User */
		$user = Mage::getSingleton('admin/session')->getUser();
		if (!$user) return;
		/* @var $extra array */
		$extra = $user->getExtra();

		if (@$extra['locale'] != $locale) {
			$extra['locale'] = $locale;
			$user->setExtra($extra)
				->save();
		}
	}

}
