<?php
class ControllerExtensionModuleAffiliate extends Controller {
	public function index() {
		$this->load->language('extension/module/affiliate');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_forgotten'] = $this->language->get('text_forgotten');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_payment'] = $this->language->get('text_payment');
		$data['text_tracking'] = $this->language->get('text_tracking');
		$data['text_transaction'] = $this->language->get('text_transaction');

		$data['logged'] = $this->affiliate->isLogged();
		$data['register'] = $this->url->link('affiliate/register', '', true);
		$data['login'] = $this->url->link('affiliate/login', '', true);
		$data['logout'] = $this->url->link('affiliate/logout', '', true);
		$data['forgotten'] = $this->url->link('affiliate/forgotten', '', true);
		$data['account'] = $this->url->link('affiliate/account', '', true);
		$data['edit'] = $this->url->link('affiliate/edit', '', true);
		$data['password'] = $this->url->link('affiliate/password', '', true);
		$data['payment'] = $this->url->link('affiliate/payment', '', true);
		$data['tracking'] = $this->url->link('affiliate/tracking', '', true);
		$data['transaction'] = $this->url->link('affiliate/transaction', '', true);

		if ($this->config->get('gixocaccount_status')) {
			$els = array();
			$els_css = '';

			$language_id = $this->config->get('config_language_id');

			$els = $this->config->get('gixocaccount_module_affiliate');
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
		return $this->load->view('extension/module/affiliate', $data);
	}
}