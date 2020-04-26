<?php
class ControllerExtensionModuleAccount extends Controller {
	public function index() {
		$this->load->language('extension/module/account');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_forgotten'] = $this->language->get('text_forgotten');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_reward'] = $this->language->get('text_reward');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_recurring'] = $this->language->get('text_recurring');

		$data['logged'] = $this->customer->isLogged();
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['forgotten'] = $this->url->link('account/forgotten', '', true);
		$data['account'] = $this->url->link('account/account', '', true);
		$data['edit'] = $this->url->link('account/edit', '', true);
		$data['password'] = $this->url->link('account/password', '', true);
		$data['address'] = $this->url->link('account/address', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist');
		$data['order'] = $this->url->link('account/order', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['reward'] = $this->url->link('account/reward', '', true);
		$data['return'] = $this->url->link('account/return', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);
		$data['recurring'] = $this->url->link('account/recurring', '', true);

		if ($this->config->get('gixocaccount_status')) {
			$els = array();
			$els_css = '';

			$language_id = $this->config->get('config_language_id');

			$els = $this->config->get('gixocaccount_module_customer');
			foreach ($els as $el) {
				if ($el['status']) {
					$els_css .= '#mod' . $el['id'] . '{color: ' . $el['color'] . '; font-size: ' . $el['font'] . 'px;}';
					$els_css .= '#mod' . $el['id'] . ':hover{color: ' . $el['color_hover'] . '; font-size: ' . $el['font_hover'] . 'px;}';

					$names = $el['name'][$language_id];

					$sort_order = $el['sort_order'];

					$el_data[] = array(
						'id'          => 'mod' . $el['id'],
						'name'        => $names,
						'url'         => $el['url'],
						'class_el'    => $el['class_el'],
						'sort_order'  => $el['sort_order']
					);
				}
			}

			$sort_order = array();

			foreach ($el_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $el_data);

			$data['els'] = $el_data;

			$data['els_css'] = $els_css . $this->config->get('gixocaccount_css');

			return $this->load->view('extension/module/gixocaffiliate', $data);
		}
		return $this->load->view('extension/module/account', $data);
	}
}