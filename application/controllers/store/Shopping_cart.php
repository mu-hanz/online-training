<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopping_cart extends CI_Controller {

    var $folder = 'Shopping_cart';
    var $file   = '';

	//---Templating----//
    public function __construct()
    {
        parent::__construct();
		$this->_init();
        // if (!$this->ion_auth->logged_in()) {
        //     $this->session->set_userdata('redirect_login', $this->agent->referrer());
        //     redirect($_SERVER['HTTP_REFERER']);
        // }
        $this->load->model($this->folder.'_m');
    }

    private function _init()
    {
        $this->output->set_template('store/layout/store');
		$this->load->section('mainmenu', 'store/layout/main_menu');
		
		$this->load->section('footer', 'store/layout/footer');
    }

    public function index()
	{	

        $this->load->css('assets/store/css/style-custom.css');
        $this->load->js('assets/store/js/shopping-cart.js');

        // Update code after sytem login done!!!
        $id_user = '1';

        $count_user_shopping_cart = $this->Shopping_cart_m->count_user_shopping_cart($id_user);

        if ($count_user_shopping_cart == '0') {
            $data = array(
                'status_shopping_cart' => 'Empty'
            );
        } else {
            $list_shopping_cart_detail = $this->Shopping_cart_m->list_shopping_cart_detail($id_user);

            $sub_total = 0;
            foreach ($list_shopping_cart_detail as $row) {
                $count_voucher = $this->Shopping_cart_m->count_voucher($row->id_event);
                if ($count_voucher > 0) {
                    $data = array(
                        'status_voucher' => 'Available'
                    );
                    $update_shopping_cart_detail_voucher = $this->Shopping_cart_m->update_shopping_cart_detail($row->id_shopping_cart, $row->id_event, $data);
                } else {
                    $data = array(
                        'status_voucher' => 'Not Available'
                    );
                    $update_shopping_cart_detail_voucher = $this->Shopping_cart_m->update_shopping_cart_detail($row->id_shopping_cart, $row->id_event, $data);
                }

                if ($row->cost_campaign_promo != '0') {
                    $sub_total += $row->cost_campaign_promo*$row->qty;
                } else if ($row->cost_campaign_promo == '0' && $row->cost_promo_event != '0') {
                    $sub_total += $row->cost_promo_event*$row->qty;
                } else if ($row->cost_campaign_promo == '0' && $row->cost_promo_event == '0') {
                    $sub_total += $row->cost_event*$row->qty;
                }
            }

            $sub_total = $sub_total;

            $row                    = $this->Shopping_cart_m->get_shopping_cart($id_user);
            $count_status_voucher   = $this->Shopping_cart_m->count_status_voucher($row->id);

            if ($count_status_voucher > 0) {
                $voucher = "Available";
            } else {
                $voucher = "Not Available";
            }

            $status_collectible_voucher     = 'Not Found';
            $discount_collectible_voucher   = '0';
            $id_collectible_voucher         = '0';
            $limit_collectible_voucher      = '0';
            $list_shopping_cart_collectible_voucher = $this->Shopping_cart_m->list_shopping_cart_collectible_voucher($id_user);
            foreach ($list_shopping_cart_collectible_voucher as $row) {
                $list_promotions_detail = $this->Shopping_cart_m->list_promotions_detail($row->id_voucher);
                foreach ($list_promotions_detail as $row2) {
                    $list_shopping_cart_detail = $this->Shopping_cart_m->list_shopping_cart_detail($id_user);
                    foreach ($list_shopping_cart_detail as $row3) {
                        if ($row2->event_id == $row3->id_event) {
                            $status_collectible_voucher = 'Found';
                            $id_collectible_voucher = $row->id_voucher;
                            $row4 = $this->Shopping_cart_m->get_promotions_type($row->id_voucher);
                            if ($row4->type_discount == 'nominal') {
                                if ($sub_total >= $row4->nominal_limit) {
                                    $discount_collectible_voucher = $nominal_discount;
                                } else {
                                    $discount_collectible_voucher = '0';
                                }
                                $limit_collectible_voucher = $row4->nominal_limit;
                            } else {
                                if ($sub_total >= $row4->percent_limit) {
                                    $temp_discount_collectible_voucher = ($sub_total*$row4->percent_discount)/100;
                                    if ($temp_discount_collectible_voucher <= $row4->percent_max_discount) {
                                        $discount_collectible_voucher = $temp_discount_collectible_voucher;
                                    } else {
                                        $discount_collectible_voucher = $row4->percent_max_discount;
                                    }
                                } else {
                                    $discount_collectible_voucher = '0';
                                }
                                $limit_collectible_voucher = $row4->percent_limit;
                            }
                            break 2;
                        }
                    }
                }
            }       

            $data = array(
                'list_shopping_cart_detail'     => $this->Shopping_cart_m->list_shopping_cart_detail($id_user),
                'voucher'                       => $voucher,
                'id_shopping_cart'              => $row->id,
                'status_collectible_voucher'    => $status_collectible_voucher,
                'discount_collectible_voucher'  => $discount_collectible_voucher,
                'id_collectible_voucher'        => $id_collectible_voucher,
                'limit_collectible_voucher'     => $limit_collectible_voucher,
                'status_shopping_cart'          => 'Not Empty'
            );

        }

		$this->output->set_title('Shopping Cart');
        $this->load->view('store/'.strtolower($this->folder), $data);
    }

    public function save()
    {
        $id_user    = $_POST['id_user'];
        $id_event   = $_POST['id_event'];

        if (isset($_POST['qty_event'])) {
            $qty_event = $_POST['qty_event'];
        } else {
            $qty_event = '0';
        }

        if (isset($_POST['cost_campaign_promo'])) {
            $cost_campaign_promo = $_POST['cost_campaign_promo'];
        } else {
            $cost_campaign_promo = '0';
        }

        $count_user_shopping_cart   = $this->Shopping_cart_m->count_user_shopping_cart($id_user);
        $row                        = $this->Shopping_cart_m->get_event($id_event);

        if ($count_user_shopping_cart > 0) {

            $data_update_shopping_cart = array(
                'edited_date' => date('Y-m-d H:i:s')
            );
            $update_shopping_cart = $this->Shopping_cart_m->update_shopping_cart($id_user, $data_update_shopping_cart);

            $get_shopping_cart   = $this->Shopping_cart_m->get_shopping_cart($id_user);
            $id_shopping_cart    = $get_shopping_cart->id;

            $count_event_shopping_cart_detail = $this->Shopping_cart_m->count_event_shopping_cart_detail($id_shopping_cart, $id_event);

            if ($count_event_shopping_cart_detail > 0) {

                $get_shopping_cart_detail   = $this->Shopping_cart_m->get_shopping_cart_detail($id_shopping_cart, $id_event);
                $update_qty_event_shopping_cart_detail = $get_shopping_cart_detail->qty + $qty_event; 

                $data = array(
                    'name_event'            => $row->event_name,
                    'thumbs_event'          => $row->event_thumbs,
                    'cost_event'            => $row->event_cost,
                    'cost_promo_event'      => $row->event_cost_promo,
                    'cost_campaign_promo'   => $cost_campaign_promo,
                    'qty'                   => $update_qty_event_shopping_cart_detail
                );
                $update_shopping_cart_detail = $this->Shopping_cart_m->update_shopping_cart_detail($id_shopping_cart, $id_event, $data);

            } else {
                $data = array(
                    'id_shopping_cart'      => $id_shopping_cart,
                    'id_event'              => $id_event,
                    'name_event'            => $row->event_name,
                    'thumbs_event'          => $row->event_thumbs,
                    'cost_event'            => $row->event_cost,
                    'cost_promo_event'      => $row->event_cost_promo,
                    'cost_campaign_promo'   => $cost_campaign_promo,
                    'qty'                   => $qty_event,
                );
                $insert_shopping_cart_detail = $this->Shopping_cart_m->insert_shopping_cart_detail($data);
            }

        } else {
            $data = array(
                'id_user'       => $id_user,
                'edited_date'   => date('Y-m-d H:i:s')
            );
            $id_last_shopping_cart  = $this->Shopping_cart_m->insert_shopping_cart($data);
            
            $data2 = array(
                'id_shopping_cart'      => $id_last_shopping_cart,
                'id_event'              => $id_event,
                'name_event'            => $row->event_name,
                'thumbs_event'          => $row->event_thumbs,
                'cost_event'            => $row->event_cost,
                'cost_promo_event'      => $row->event_cost_promo,
                'cost_campaign_promo'   => $cost_campaign_promo,
                'qty'                   => $qty_event
            );
            $insert_shopping_cart_detail = $this->Shopping_cart_m->insert_shopping_cart_detail($data2);
        }

        redirect('/shopping-cart');
    }

    public function update()
    {
        $this->output->unset_template();

        // Update code after sytem login done!!!
        $id_user = '1';

        $id         = $_POST['id'];
        $qty        = $_POST['qty'];
        $category   = $_POST['category'];

        if ($category == 'UpdateShoppingCartDetail') {
            
            if (isset($_POST['category2'])) {
                $sub_total = $_POST['sub_total'];
                $row4 = $this->Shopping_cart_m->get_promotions_type($_POST['id_collectible_voucher']);
                if ($row4->type_discount == 'nominal') {
                    if ($sub_total >= $row4->nominal_limit) {
                        $discount_collectible_voucher = $nominal_discount;
                    } else {
                        $discount_collectible_voucher = '0';
                    }
                } else {
                    if ($sub_total >= $row4->percent_limit) {
                        $temp_discount_collectible_voucher = ($sub_total*$row4->percent_discount)/100;
                        if ($temp_discount_collectible_voucher <= $row4->percent_max_discount) {
                            $discount_collectible_voucher = $temp_discount_collectible_voucher;
                        } else {
                            $discount_collectible_voucher = $row4->percent_max_discount;
                        }
                    } else {
                        $discount_collectible_voucher = '0';
                    }
                }
                $data = array(
                    'discount_collectible_voucher' => rupiah($discount_collectible_voucher)
                );
            } else {
                $row = $this->Shopping_cart_m->get_shopping_cart_detail_ajax($id);
                $data2 = array(
                    'qty'   => $qty
                );
                $update_shopping_cart_detail2 = $this->Shopping_cart_m->update_shopping_cart_detail2($id, $data2);

                if ($row->cost_campaign_promo != '0') {
                    $price_event = $qty*$row->cost_campaign_promo;
                } else if ($row->cost_promo_event != '0' && $row->cost_campaign_promo == '0') {
                    $price_event = $qty*$row->cost_promo_event;
                } else if ($row->cost_event != '0' && $row->cost_promo_event == '0' && $row->cost_campaign_promo == '0') {
                    $price_event = $qty*$row->cost_event;
                }

                $data = array(
                    'price_event' => rupiah($price_event)
                );
            }
        } else if ($category == 'DeleteShoppingCartDetail') {
            $row                = $this->Shopping_cart_m->get_shopping_cart_detail_ajax($id);
            $id_shopping_cart   = $row->id_shopping_cart;
            
            $delete_row         = $this->Shopping_cart_m->delete_shopping_cart_detail($id);

            if ($delete_row) {
                $status_delete = 'Success';
            } else {
                $status_delete = 'Error';
            }

            $count_shopping_cart_detail         = $this->Shopping_cart_m->count_shopping_cart_detail($id_shopping_cart);

            if ($count_shopping_cart_detail == '0') {
                $delete_shopping_cart   = $this->Shopping_cart_m->delete_shopping_cart($id_shopping_cart);
                $count_shopping_cart    = 'Empty';
            } else {
                $count_shopping_cart    = 'NotEmpty';
            }

            $count_status_voucher       = $this->Shopping_cart_m->count_status_voucher($id_shopping_cart);

            if ($count_status_voucher > 0) {
                $status_voucher = 'Available';
            } else {
                $status_voucher = 'Not Available';
            }

            //Check Collectible Voucher
            $id_collectible_voucher   = $_POST['id_collectible_voucher'];
            $status_collectible_voucher = 'Not Found';
            if ($id_collectible_voucher != '0') {
                $list_shopping_cart_detail       = $this->Shopping_cart_m->list_shopping_cart_detail($id_user);
                foreach ($list_shopping_cart_detail as $row) {
                    $list_promotions_detail       = $this->Shopping_cart_m->list_promotions_detail($id_collectible_voucher);
                    foreach ($list_promotions_detail as $row2) {
                        if ($row->id_event == $row2->event_id) {
                            $status_collectible_voucher = 'Found';
                            break 2;
                        }
                    }
                }
            } else {
                $status_collectible_voucher = 'Not Found';
            }

            $data = array(
                'status_delete'                 => $status_delete,
                'count_shopping_cart'           => $count_shopping_cart,
                'status_voucher'                => $status_voucher,
                'status_collectible_voucher'    => $status_collectible_voucher
            );

        } else if ($category == 'CheckCouponCode') {
            $coupon_code            = $_POST['coupon_code'];
            $sub_total              = $_POST['sub_total'];

            $count_active_voucher   = $this->Shopping_cart_m->count_active_voucher($coupon_code);
            if ($count_active_voucher > 0) {
                $count_orders_code_voucher  = $this->Shopping_cart_m->count_orders_code_voucher($coupon_code);
                $row                        = $this->Shopping_cart_m->get_promotions($coupon_code);
                if ($count_orders_code_voucher < $row->limit_promotion) {
                    $count_orders_code_voucher_by_user  = $this->Shopping_cart_m->count_orders_code_voucher_by_user($coupon_code, $id_user);
                    if ($count_orders_code_voucher_by_user < $row->limit_user) {
                        $row2   = $this->Shopping_cart_m->get_promotions_type($row->promotions_id);
                        if ($row2->type_discount == 'nominal') {
                            if ($sub_total >= $row2->nominal_limit) {
                                $data = array(
                                    'status_voucher'            => 'Available',
                                    'nominal_discount_voucher'  => rupiah($row2->nominal_discount)
                                );
                            } else {
                                $data = array(
                                    'status_voucher'        => 'Limit Nominal Not Available'
                                );  
                            }
                        } else {
                            if ($sub_total >= $row2->percent_limit) {
                                $total_discount = ($sub_total*$row2->percent_discount)/100;
                                if ($total_discount <= $row2->percent_max_discount) {
                                    $data = array(
                                        'status_voucher'            => 'Available',
                                        'nominal_discount_voucher'  => rupiah($total_discount)
                                    );
                                } else {
                                    $data = array(
                                        'status_voucher'            => 'Available',
                                        'nominal_discount_voucher'  => rupiah($row2->percent_max_discount)
                                    );
                                }
                            } else {
                                $data = array(
                                    'status_voucher'        => 'Limit Nominal Not Available'
                                );  
                            }
                        }
                    } else {
                        $data = array(
                            'status_voucher'        => 'Limit Not Available'
                        );  
                    }
                } else {
                    $data = array(
                        'status_voucher'        => 'Limit Not Available'
                    ); 
                }
            } else {
                $data = array(
                    'status_voucher'        => 'Not Available'
                );
            }
        }

        echo json_encode($data);
    }

    public function save_collectible_voucher()
    {
        $this->output->unset_template();

        $id_user                    = $_POST['id_user'];
        $id_collectible_voucher     = $_POST['id'];

        $count_collectible_voucher_by_user  = $this->Shopping_cart_m->count_collectible_voucher_by_user($id_collectible_voucher, $id_user);

        if ($count_collectible_voucher_by_user > 0) {
            $data = array(
                'status'        => 'Success'
            ); 
        } else {
            $data2 = array(
                'id_user'       => $id_user,
                'id_voucher'    => $id_collectible_voucher
            );
            $insert_collectible_voucher         = $this->Shopping_cart_m->insert_collectible_voucher($data2);
            if ($insert_collectible_voucher) {
                $data = array(
                    'status'        => 'Success'
                ); 
            } else {
                $data = array(
                    'status'        => 'Error'
                ); 
            }
        }

        echo json_encode($data);

    }
    
}