<?php

class OfferModel extends CI_Model {

    public $table = 'saler_offers';

    function getOffers($id = null) {

        if ($id == null) return [];

        return $this->db->select('*')
               ->from($this->table)
               ->where('saler_id', $id)
               ->get()->result();
    }

    function offerData($id){
        $offer = $this->db->select('of.*,s.email,s.phone')->from('saler_offers of')
                 ->where('of.id', $id)
                 ->join('salers as s', 'of.saler_id = s.id', 'left')
                 ->get()->first_row();

        if (!$offer) return 0;

        $offer_data = explode(',', $offer->data);

        if (!$offer_data || !count($offer_data)) {
            $offer->offerData = [];
        } else {
            $offer->offerData = $this->db->select('s.code,f.medium,b.id,b.GID,b.coordinates,b.address,t.name,t.color')
                                ->from('board_sides s')
                                ->join('boards b', 's.board_id = b.id')
                                ->join('board_types t', 'b.type = t.id', 'left')
                                ->join('files f', 's.image_id = f.id', 'left')
                                ->where_in('s.id', explode(',', $offer->data))
                                ->get()->result();
        }

        return $offer;
    }

    function getUniqueForMap($objs){
        $temp = [];
        $mapObjs = [];

        foreach($objs as $obj){
            if (array_search($obj->id,$temp) === false){
                $temp[] = $obj->id;
                $mapObjs[] = $obj;
            }
        }

        return $mapObjs;
    }

}