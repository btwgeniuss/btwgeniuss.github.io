<?php
class ControllerAffiliateAccount extends Controller {
	public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/account', '', true);

			$this->response->redirect($this->url->link('affiliate/login', '', true));
		}

		$this->load->language('affiliate/account');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('affiliate/account', '', true)
		);

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_my_account'] = $this->language->get('text_my_account');
		$data['text_my_tracking'] = $this->language->get('text_my_tracking');
		$data['text_my_transactions'] = $this->language->get('text_my_transactions');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_payment'] = $this->language->get('text_payment');
		$data['text_tracking'] = $this->language->get('text_tracking');
		$data['text_transaction'] = $this->language->get('text_transaction');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['edit'] = $this->url->link('affiliate/edit', '', true);
		$data['password'] = $this->url->link('affiliate/password', '', true);
		$data['payment'] = $this->url->link('affiliate/payment', '', true);
		$data['tracking'] = $this->url->link('affiliate/tracking', '', true);
		$data['transaction'] = $this->url->link('affiliate/transaction', '', true);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('affiliate/account', $data));
		if ($this->config->get('gixocaccount_status')) {
			$groups = array();
			$els = array();
			$els_css = '';

			$this->load->model('tool/image');

			$language_id = $this->config->get('config_language_id');

			$groups = $this->config->get('gixocaccount_groups_affiliate');
			$els = $this->config->get('gixocaccount_el_affiliate');

			foreach ($groups as $group) {
				if ($group['status']){
					foreach ($els as $el) {
						if (($el['status']) && ($el['affiliate_group_id'] == $group['id'])) {
							if (is_file(DIR_IMAGE . $el['image'])) {
								$image = $this->model_tool_image->resize($el['image'], $el['image_width'], $el['image_height']);
							} else {
								$image = $this->model_tool_image->resize('no_image.png', 64, 64);
							};

							$els_css .= '#el' . $el['id'] . '{color: ' . $el['color'] . '; font-size: ' . $el['font'] . 'px;}';
							$els_css .= '#el' . $el['id'] . ':hover{color: ' . $el['color_hover'] . '; font-size: ' . $el['font_hover'] . 'px;}';

							$names = $el['name'][$language_id];

							$sort_order = $el['sort_order'];

							$el_data[] = array(
								'name'        => $names,
								'id'          => 'el' . $el['id'],
								'url'         => $el['url'],
								'image'       => $image,
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

					$data['groups'][] = array(
						'id'                  => 'group' . $group['id'],
						'sort_order'          => $group['sort_order'],
						'name'                => $group['name'][$language_id],
						'class_el'            => $group['class_el'],
						'els'                 => $el_data
					);

					$els_css .= '#group' . $group['id'] . '{color: ' . $group['color'] . '; font-size: ' . $group['font'] . 'px;}';
					$els_css .= '#group' . $group['id'] . ':hover{color: ' . $group['color_hover'] . '; font-size: ' . $group['font_hover'] . 'px;}';
				
					$el_data = array();
				};
			};

			$sort_order = array();

			foreach ($data['groups'] as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $data['groups']);

			$data['els_css'] = $els_css . $this->config->get('gixocaccount_css');

			$this->response->setOutput($this->load->view('extension/module/gixocaccount', $data));
		}
	}
}