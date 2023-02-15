<?php

class GetProduct{

    private $con, $qry;

    public static $tot_nb_pgs;
    public static $p_nb;


    public function __construct($con){
        $this->con = $con;
    }



    public function getProduct($id, $cate = null){

        if($cate != null){

            $this->qry = $this->con->prepare("SELECT * FROM products 
                                            WHERE product_id != :id 
                                            AND product_category = :cate
                                            ORDER BY rand()
                                            LIMIT 4");
            $this->qry->bindValue(":id", $id);
            $this->qry->bindValue(":cate", $cate);
            $this->qry->execute();
            return $this->qry;

        } else {

            $this->qry = $this->con->prepare("SELECT * FROM products 
                                            WHERE product_id = :id");
            $this->qry->bindValue(":id", $id);
            $this->qry->execute();
            return $this->qry;
        }
    }



    public function getReview($id){

        $this->qry = $this->con->prepare("SELECT *
                                        FROM `reviews` 
                                        INNER JOIN users 
                                        ON reviews.user_id = users.user_id
                                        WHERE product_id = :pid");
        $this->qry->bindValue(":pid", $id);
        $this->qry->execute();

        return $this->qry;
    }



    public function getStar($id){

        $this->qry = $this->con->prepare("SELECT star_rate
                                        FROM `reviews` 
                                        WHERE product_id = :pid");
        $this->qry->bindValue(":pid", $id);
        $this->qry->execute();

        return $this->qry;
    }



    public function getRandProduct(){

        $this->qry = $this->con->prepare("SELECT *
                                        FROM `products` 
                                        ORDER BY RAND()
                                        LIMIT 4");
        $this->qry->execute();
        return $this->qry;

    }


    public function getSearchProduct($range, $cate){

        global $tot_nb_pgs;
        global $p_nb;

        $sql = "SELECT COUNT(*) FROM products ";

        if($cate != null) {
            $sql .= "WHERE product_category=:ct ";
        } 
        if($range != null) {
            $sql .= "AND product_price <= :pr ";
        }

        $qry_count = $this->con->prepare($sql);
        

        if($cate != null) {
            $qry_count->bindValue(":ct", $cate);
        } 
        if($range != null) {
            $qry_count->bindValue(":pr", $range);
        }

        $qry_count->execute();
        $total_record = $qry_count->fetch(PDO::FETCH_NUM);
        $total_rec = $total_record[0];

        $prd_per_pg = 8;
        $tot_nb_pgs = ceil( $total_rec / $prd_per_pg);

        $offset = ($p_nb - 1) * $prd_per_pg;
        $adjacents = "2"; 



        $sql2 = "SELECT * FROM products ";

        if($cate != null) {
            $sql2 .= "WHERE product_category=:ct ";
        } 
        if($range != null) {
            $sql2 .= "AND product_price <= :pr ";
        }
        $sql2 .="ORDER BY rand() LIMIT :of, :pg";
        
        // $this->getShopProduct($this->con, $sql2)
        $this->qry = $this->con->prepare($sql2);

        if($cate != null) {
            $this->qry->bindValue(":ct", $cate);
        } 
        if($range != null) {
            $this->qry->bindValue(":pr", $range);
        }

        $this->qry->bindValue(":of", $offset, PDO::PARAM_INT);
        $this->qry->bindValue(":pg", $prd_per_pg, PDO::PARAM_INT);
        
        $this->qry->execute();

        return $this->qry;

    }
    

    public function getOrderedProduct($o_id){

        $this->qry = $this->con->prepare("SELECT * FROM orders od
                                        LEFT JOIN order_items oi 
                                        ON od.order_id = oi.order_id
                                        WHERE 1 = 0 
                                            UNION ALL
                                            SELECT * FROM orders od
                                            RIGHT JOIN order_items oi
                                            ON od.order_id = oi.order_id
                                            WHERE od.order_id = :o_id ;");

        $this->qry->bindValue(":o_id", $o_id);
        // $this->qry->bindValue(":p_id", $p_id);
        $this->qry->execute();

        return $this->qry;

    }

    public function getOrderLists($u_id){

        $this->qry = $this->con->prepare("SELECT * FROM order_items oi
                                        LEFT JOIN orders od 
                                        ON oi.order_id = od.order_id
                                        WHERE oi.user_id = :u_id 
                                            UNION ALL
                                            SELECT * FROM order_items oi
                                            RIGHT JOIN orders od 
                                            ON oi.order_id = od.order_id
                                            WHERE oi.user_id = null");


        $this->qry->bindValue(":u_id", $u_id);
        $this->qry->execute();
        // print_r($this->qry->fetch(PDO::FETCH_ASSOC));
        return $this->qry;

    }




}



?>
