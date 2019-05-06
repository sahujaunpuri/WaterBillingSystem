<?php

class Account_title_model extends CORE_Model{

    protected  $table="account_titles"; //table name
    protected  $pk_id="account_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function create_default_account_title(){
        //return;
        $sql="INSERT IGNORE INTO account_titles
                  (account_id,account_no,account_title,account_class_id,parent_account_id,grand_parent_id)
              VALUES
                  (1,'101','Cash',1,0,1),
                  (2,'120','Account Receivable',1,0,2),
                  (3,'140','Inventory',1,0,3),
                  (10,'150','Input Tax',1,0,10),
                  (13,'160','Petty Cash',1,0,1),

                  (4,'210','Accounts Payable',3,0,4),
                  (11,'220','Output Tax',3,0,4),

                  (5,'300','Capital',5,0,5),

                  (6,'400','Sales Income',7,0,6),
                  (7,'410','Service Income',7,0,7),

                  (8,'500','Salaries Expense',6,0,8),
                  (9,'510','Supplies Expense',6,0,9),
                  (12,'510','Miscellaneous Expense',6,0,12)
                   ";
        $this->db->query($sql);
    }

function restore_default_account_title(){
        //return;
        $truncatesql="Truncate account_titles";
          $this->db->query($truncatesql);

        $sql="INSERT IGNORE INTO account_titles
                  (account_id,account_no,account_title,account_class_id,parent_account_id,grand_parent_id)
              VALUES
                  (1,'1000','Cash on Hand',1,0,1),
                  (2,'1100','Cash in Bank - GRB',1,0,2),
                  (3,'1100','Petty Cash Fund',1,0,3),
                  (4,'1120','Revolving Fund',1,0,4),
                  (5,'1200','Account Receivable',1,0,5),
                  (6,'1210','Account Receivable OTH',1,0,6),
                  (7,'1300','Furniture and Fixture',2,0,7),
                  (8,'1301','Accumulative Depreciation',2,0,8),
                  (9,'1400','Service Vehicles',2,0,9),
                  (10,'1500','Kitchen Equipment',2,0,10),
                  (11,'1600','Computer and Electronic Equipment',2,0,11),
                  (12,'1700','Appliances and Other Electronic Gadgets',2,0,12),
                  (13,'2000','Liability',3,0,13),
                  (14,'2001','Long Term Loan',3,0,14),
                  (15,'2002','Short Term Loan',3,0,15),
                  (16,'2200','Account Payable - Trade Supplier',3,0,16),
                  (17,'3000','Capital - Equity',5,0,17),
                  (18,'3010','Retained Earnings',5,0,18),
                  (19,'4000','Sales Income',7,0,19),
                  (20,'4010','Other Income',7,0,20),
                  (21,'4020','Bar Sales',7,0,21),
                  (22,'4030','Event Income',7,0,22),
                  (23,'4040','Function Income',7,0,23),
                  (24,'5000','Expenses',6,0,24),
                  (25,'5010','Labor',6,0,25),
                  (26,'5020','Repair and Maintenance',6,0,26),
                  (27,'5030','Salaries and Wages - Admin',6,0,27),
                  (28,'5031','Salaries and Wages - Agency and Security',6,0,28),
                  (29,'5032','Salaries and Wages - Hotel Personnel',6,0,29),
                  (30,'5040','Office Supplies',6,0,30),
                  (31,'5050','Commissions - Massage / Vehicle',6,0,31),
                  (32,'5060','Gas and Oil',6,0,32),
                  (33,'5070','Telephone and Communication and Internet',6,0,33),
                  (34,'5080','Garbage Expense and Sewerage',6,0,34),
                  (35,'5090','Water Consumption',6,0,35),
                  (36,'5100','Miscellaneous Expense',6,0,36),
                  (37,'5200','Construction Maintenance',6,0,37),
                  (38,'5300','Utility Expenses and Plumbing',6,0,38),
                  (39,'5400','Janitorial Expense',6,0,39),
                  (40,'550','Rental and Occupancy Expense',6,0,40),
                  (41,'5600','Purchases and Wet Market Purchases',6,0,41),
                  (42,'5700','Groceries',6,0,42),
                  (43,'5800','Hotel Supplies',6,0,43),
                  (44,'5900','Toiletries',6,0,44),
                  (48,'2210','Output Tax',3,0,48),
                  (49,'6100','Representation',6,0,49),
                  (50,'2220','Input Tax',3,0,50),
                  (51,'6010','Cost of Sales / Operating Expense',6,0,51),
                  (52,'4050','Sales Discount',7,0,52),
                  (53,'6020','Purchase Discount',6,0,53)";
            $this->db->query($sql);
    }



  function get_account_types(){

        $sql="SELECT * FROM account_types  
        order by account_type_id ASC";
        return $this->db->query($sql)->result();
    }   
    function get_account_classes(){

        $sql="SELECT * FROM account_classes  
        WHERE is_active = TRUE and is_deleted = FALSE 
        order by account_type_id ASC";
        return $this->db->query($sql)->result();
    }
    function get_account_titles(){

        $sql="SELECT at.* FROM account_titles at
        WHERE at.is_active = TRUE AND at.is_deleted = FALSE AND at.parent_account_id = 0
        ";
        return $this->db->query($sql)->result();
    }

    function get_account_titles_child(){

        $sql="SELECT at.* FROM account_titles at
        WHERE at.is_active = TRUE AND at.is_deleted = FALSE AND at.parent_account_id != 0
        ";
        return $this->db->query($sql)->result();
    }


    function get_account_titles_balance($start=null,$end=null){
        $sql="SELECT

                at.account_no,at.account_title,
                IFNULL(SUM(ja.dr_amount),0) as dr_amount,
                IFNULL(SUM(ja.cr_amount),0) as cr_amount,
                ac.account_class_id,ac.account_type_id,

                IF(
                    ac.account_type_id=1 OR ac.account_type_id=5,
                    IFNULL(SUM(ja.dr_amount),0)-IFNULL(SUM(ja.cr_amount),0),
                    IFNULL(SUM(ja.cr_amount),0)-IFNULL(SUM(ja.dr_amount),0)
                ) as balance


                FROM (account_titles as at LEFT JOIN `account_classes` as ac ON at.`account_class_id`=ac.account_class_id)
                LEFT JOIN

                (

                SELECT ja.* FROM journal_accounts as ja INNER
                JOIN journal_info as ji ON ja.journal_id=ji.journal_id
                WHERE ji.is_active AND ji.is_deleted=FALSE
                ".($start!=null&&$end!=null?" AND ji.date_txn BETWEEN '$start' AND '$end'":"")."

                )as ja

                ON at.account_id=ja.account_id



                GROUP BY at.account_id";

            return $this->db->query($sql)->result();
    }




}




?>