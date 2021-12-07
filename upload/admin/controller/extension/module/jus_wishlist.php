<?php
/*
 * This file is part of JusWishlist module for OC3.x
 * (c) 2021 jigius@gmail.com
 */
class ControllerExtensionModuleJusWishlist extends Controller
{
    private $error = array();

    public function __construct($registry)
    {
        parent::__construct($registry);
    }

    public function index()
    {
        $this->load->language('extension/module/jus_wishlist');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_jus_wishlist', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/jus_wishlist', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        $data['action'] = $this->url->link('extension/module/jus_wishlist', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $settings = $this->model_setting_setting->getSetting('module_jus_wishlist');
        if (isset($this->request->post['module_jus_wishlist_status'])) {
            $data['status'] = (int)$this->request->post['module_jus_wishlist_status'];
        } else {
            $data['status'] = $settings['module_jus_wishlist_status'] ?? 0;
        }
        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();
        $data['entry_title'] = $this->language->get('heading_title');
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('extension/module/jus_wishlist', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/jus_wishlist')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return count($this->error) === 0;
    }

    public function install()
    {
        $this->load->model('setting/setting');
        $this
            ->model_setting_event
            ->addEvent(
                'jus_wishlist',
                'catalog/controller/account/wishlist/before',
                'extension/module/jus_wishlist/modify'
            );
        $this
            ->model_setting_event
            ->addEvent(
                'jus_wishlist',
                'catalog/controller/account/wishlist/add/before',
                'extension/module/jus_wishlist/modify'
            );
		$this
			->model_setting_event
			->addEvent(
				'jus_wishlist',
				'catalog/controller/*/before',
				'extension/module/jus_wishlist/restore'
			);
        $this->load->model('setting/setting');
        $this
            ->model_setting_setting
            ->editSetting(
                'module_jus_wishlist',
                [
                    'module_jus_wishlist_status' => 0,
                ]
            );
    }

    public function uninstall()
    {
        $this->model_setting_event->deleteEventByCode('jus_wishlist');
        $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting('module_jus_wishlist');
    }
}
