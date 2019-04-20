<?php 
    function get_order_billing($id)
    {
        $get_order = wc_get_order($id);
        $order = $get_order->get_data();
        return $order['billing'];
    }

    function get_order_shipping($id)
    {
        $get_order = wc_get_order($id);
        $order = $get_order->get_data();
        return $order['shipping'];
    }

    function random_rtn($order_id)
    {
        $random = rand(10000, 99999);
        $numb = $random.$order_id;
        return $numb;
    }

    function parsing_time($time)
    {
        return date( 'g:i', strtotime($time) );

    }


    function create_order($post)
    {
        $url = api_url().'/SG/4.1/orders';
        $cust = get_order_shipping($post['order_id']);
        $cust_bill = get_order_billing($post['order_id']);
        if ($post['pk_req'] === 'on') {
            $pk_req = true;
        } else {
            $pk_req = false;
        }
        // $data = [
        //     'service_type'              => 'Parcel',
        //     'service_level'             => $post['service_level'],
        //     'requested_tracking_number' => $post['rtn'],
        //     'reference'                 => [
        //         'merchant_order_number' => 'SHIP-1234-56789'
        //     ],
        //     'from'                      => [
        //         'name'          => get_option('sender_name'),
        //         'phone_number'  => '+'.get_option('sender_phone'),
        //         'email'         => get_option('sender_mail'),
        //         'address'       => [
        //             'address1'  => get_option('sender_address_1'),
        //             'address2'  => get_option('sender_address_2'),
        //             'country'   => get_option('sender_country'),
        //             'postcode'  => get_option('sender_postal_code')
        //         ]
        //     ],
        //     'to'                        => [
        //         'name'          => $cust['first_name'].' '.$cust['last_name'],
        //         'phone'         => '+'.$cust_bill['phone'],
        //         'email'         => $cust_bill['email'],
        //         'address'       => [
        //             'address1'  => $cust['address_1'],
        //             'address2'  => $cust['address_2'],
        //             'country'   => $cust['country'],
        //             'postcode'  => $cust['postcode']
        //         ]
        //     ],
        //     'parcel_job'    => [
        //         'is_pickup_required'    => $pk_req,
        //         'pickup_address_id'     => 98989012,
        //         'pickup_service_type'   => $post['pk_st'],
        //         'pickup_service_level'  => $post['pk_slv'],
        //         'pickup_date'           => date('Y-m-d', strtotime($post['pk_date'])),
        //         'pickup_timeslot'       => [
        //             'start_time'        => parsing_time($post['pk_start']),
        //             'end_time'          => parsing_time($post['pk_end']),
        //             'timezone'          => 'Asia/Singapore'
        //         ],
        //         'pickup_instruction'    => $post['pk_inst'],
        //         'delivery_instruction'  => $post['dl_inst'],
        //         'delivery_start_date'   => date('Y-m-d', strtotime($post['dl_date'])),
        //         'delivery_timeslot'     => [
        //             'start_time'        => parsing_time($post['dl_start']),
        //             'end_time'          => parsing_time($post['dl_end']),
        //             'timezone'          => 'Asia/Singapore'
        //         ]
        //     ]
        // ];
        $data = '{  
   "service_type":"Parcel",
   "service_level":"Standard",
   "requested_tracking_number":"759771305",
   "reference":{  
      "merchant_order_number":"SHIP-1234-56789"
   },
   "from":{  
      "name":"Closet",
      "phone_number":"+64448325",
      "email":"natashasakuma@demarca.sg",
      "address":{  
         "address1":"6 Scotts Road",
         "address2":"#03-10 Scotts Square",
         "country":"SG",
         "postcode":"228209"
      }
   },
   "to":{  
      "name":"Rafi Halilintar",
      "phone":"+64448325",
      "email":"masitingss@gmail.com",
      "address":{  
         "address1":"6 Scotts Road",
         "address2":"#03-10 Scotts Square",
         "country":"SG",
         "postcode":"228209"
      }
   },
   "parcel_job":{  
      "is_pickup_required":true,
      "pickup_address_id":98989012,
      "pickup_service_type":null,
      "pickup_service_level":null,
      "pickup_date":"2019-06-22",
      "pickup_timeslot":{  
         "start_time":"9:00",
         "end_time":"12:00",
         "timezone":"Asia/Singapore"
      },
      "pickup_instruction":"Nonono",
      "delivery_instruction":"nonoonono",
      "delivery_start_date":"2019-06-23",
      "delivery_timeslot":{  
         "start_time":"9:00",
         "end_time":"12:00",
         "timezone":"Asia/Singapore"
      }
   }
}';
        // $result = json_encode($data);
        $response = curl_create_order($url, $data, $post['access_tokn']);
        // return $data;
        return $response;
    }
