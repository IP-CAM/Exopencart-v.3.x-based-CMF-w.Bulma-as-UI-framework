<?php
class ControllerExtensionModuleStore extends Controller {
  public function index() {
    $status = true;

    if ($this->config->get('module_store_admin')) {
      $this->user = new Cart\User($this->registry);

      $status = $this->user->isLogged();
    }

    if ($status) {
      $this->load->language('extension/module/store');

      $data['store_id'] = $this->config->get('config_store_id');

      $data['stores'] = array();

      $this->load->model('setting/store');

      $results = $this->model_setting_store->getStores();

      foreach ($results as $result) {
        $data['stores'][] = array(
          'store_id' => $result['store_id'],
          'name'     => $result['name'],
          'city'     => $result['city'],
          'url'      => $result['url'] . 'index.php?route=common/home&session_id=' . $this->session->getId()
        );
      }

      $data['stores'][] = array(
        'store_id' => 0,
        'name'     => $this->config->get('config_name'),
        'city'     => $this->config->get('config_city'),
        'url'      => HTTP_SERVER . 'index.php?route=common/home&session_id=' . $this->session->getId()
      );

      //return $this->load->view('extension/module/store', $data);
      $this->response->setOutput($this->load->view('extension/module/store', $data));
    }
  }
}
