<?php

class Setup_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        //load the db_forge
        $this->load->dbforge();
    }

    function create_db_schema()
    {
       //to see if it works
        //echo __FUNCTION__;


        /*=====================================================================
         * BLOGS TABLE
         * ====================================================================
         */

        //identify fields
        $blog_fields = array
        (
            //primary key
            'id'            => array
                                (
                                    'type'              => 'INT',
                                    'constraint'        => 11,//max number of values
                                    'unsigned'          => TRUE,//to avoid  -ve values
                                    'auto_increment'    => TRUE//you can only have one auto increament
                                ),
            //title
            'title'         => array
                                (
                                    'type'              => 'VARCHAR',
                                    'constraint'        => '100',
                                ),
            //slug
            'slug'          => array
                                (
                                    'type'              => 'VARCHAR',
                                    'constraint'        => '100',
                                ),
            //tags
            'tags'          => array
                                (
                                    'type'              => 'TEXT',
                                    'null'              => TRUE,
                                ),
            //cover image
            'cover_image'   => array
                                (
                                    'type'              =>'VARCHAR',
                                    'constraint'        => '100',
                                    'default'           => 'article_cover.lpg',
                                ),
            //content
            'content'     => array
                                (
                                    'type'              => 'TEXT',
                                    'null'              => TRUE,
                                ),
            //author
            'blog_author' => array
                                (
                                    'type'              =>'INT',
                                    'constraint'        => '11',
                                ),

            //date added
            'dateadded'   => array
                                (
                                    'type'              => 'DATETIME'
                                )
        );
        //enum trash fields
        $blog_fields['trash'] = array
                                (
                                    'type' => 'ENUM("y","n")',
                                    'default' => 'n',
                                    'null' => FALSE,
                                );

        //to add fields
        $this->dbforge->add_field($blog_fields);
        $this->dbforge->add_key('id', TRUE);//make id primary key
        $this->dbforge->create_table('blogs');

        //echo $this->db->last_query().'<br>hr';



        /*=====================================================================
         * BLOG TAGS TABLE
         * ====================================================================
         */

        //identify fields
        $blogtag_fields = array
        (
            //primary key
            'id'            => array
            (
                'type'              => 'INT',
                'constraint'        => 11,//max number of values
                'unsigned'          => TRUE,//to avoid  -ve values
                'auto_increment'    => TRUE//you can only have one auto increament
            ),
            //title
            'tag'         => array
            (
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ),

            //author
            'blog_author' => array
            (
                'type'              =>'INT',
                'constraint'        => '11',
            ),

        );
        //enum trash fields
        $blogtag_fields['trash'] = array
        (
            'type' => 'ENUM("y","n")',
            'default' => 'n',
            'null' => FALSE,
        );

        //to add fields
        $this->dbforge->add_field($blogtag_fields);
        $this->dbforge->add_key('id', TRUE);//make id primary key
        $this->dbforge->create_table('blog_tags');

        //echo $this->db->last_query().'<br>hr';




        /*=====================================================================
         * SITE INFO TABLE
         * ====================================================================
         */

        //identify fields
        $siteinfo_fields = array
        (
            //primary key
            'id'            => array
            (
                'type'              => 'INT',
                'constraint'        => 11,//max number of values
                'unsigned'          => TRUE,//to avoid  -ve values
                'auto_increment'    => TRUE//you can only have one auto increament
            ),
            //title
            'title'         => array
            (
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ),
            //slug
            'slug'          => array
            (
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ),
            //cover image
            'logo'          => array
            (
                'type'              =>'VARCHAR',
                'constraint'        => '100',
                'default'           => 'logo.jpg',
            ),
            //tagline
            'tagline'       => array
            (
                'type'              => 'TEXT',
                'null'              => TRUE,
            ),
            //address
            'address'       => array
            (
                'type'              =>'TEXT',
                'null'              => TRUE,
            ),

            //telephone
            'tel'   => array
            (
                'type'               => 'VARCHAR',
                'constraint'         =>'20',
            )
        );
        //enum trash fields
        $siteinfo_fields['trash'] = array
        (
            'type' => 'ENUM("y","n")',
            'default' => 'n',
            'null' => FALSE,
        );

        //to add fields
        $this->dbforge->add_field($siteinfo_fields);
        $this->dbforge->add_key('id', TRUE);//make id primary key
        $this->dbforge->create_table('siteinfo');

        //echo $this->db->last_query().'<br>hr';



        /*=====================================================================
         * USERTYPES TABLE
         * ====================================================================
         */

        //identify fields
        $usertype_fields = array
        (
            //primary key
            'id'            => array
            (
                'type'              => 'INT',
                'constraint'        => 11,//max number of values
                'unsigned'          => TRUE,//to avoid  -ve values
                'auto_increment'    => TRUE//you can only have one auto increament
            ),
            //title
            'usertype'         => array
            (
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            )
        );
        //enum trash fields
        $usertype_fields['trash'] = array
        (
            'type' => 'ENUM("y","n")',
            'default' => 'n',
            'null' => FALSE,
        );

        //to add fields
        $this->dbforge->add_field($usertype_fields);
        $this->dbforge->add_key('id', TRUE);//make id primary key
        $this->dbforge->create_table('usertypes');

        //echo $this->db->last_query().'<br>hr';



         /*=====================================================================
         * USERS TABLE
         * ====================================================================
         */

        //identify fields
        $userinfo_fields = array
        (
            //primary key
            'id'            => array
            (
                'type'              => 'INT',
                'constraint'        => 11,//max number of values
                'unsigned'          => TRUE,//to avoid  -ve values
                'auto_increment'    => TRUE//you can only have one auto increament
            ),
            //FIRSTNAME
            'fname'         => array
            (
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ),
            //lastname
            'lname'          => array
            (
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ),
            //email
            'email'          => array
            (
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ),
            //usertype
            'usertype'       => array
            (
                'type'              =>'INT',
                'constraint'        => '11',
            ),
            //password
            'password'       => array
            (
                'type'              => 'VARCHAR',
                'constraint'        => '255',
            ),
            //avatar
            'avatar'         => array
            (
                'type'              =>'VARCHAR',
                'constraint'        => '100',
                'default'           => 'avatar.jpg',
            ),
            //date added
            'dateadded'      => array
                                (
                                    'type'              => 'DATETIME'
                                ),
            //last login
            'lastlogin'      => array
                                (
                                    'type'              => 'DATETIME'
                                )
        );
        //enum trash fields
        $userinfo_fields['trash'] = array
        (
            'type' => 'ENUM("y","n")',
            'default' => 'n',
            'null' => FALSE,
        );

        //to add fields
        $this->dbforge->add_field($userinfo_fields);
        $this->dbforge->add_key('id', TRUE);//make id primary key
        $this->dbforge->create_table('users');

        //echo $this->db->last_query().'<br>hr';


        /*=====================================================================
        * USERS ADDITIONAL INFO TABLE
        * ====================================================================
        */

        //identify fields
        $userinfo_fields = array
        (
            //primary key
            'id'            => array
            (
                'type'              => 'INT',
                'constraint'        => 11,//max number of values
                'unsigned'          => TRUE,//to avoid  -ve values
                'auto_increment'    => TRUE//you can only have one auto increament
            ),
            //userID
            'user_id'       => array
            (
                'type'              =>'INT',
                'constraint'        => '11',
            ),

            //TELEPHONE
            'telephone'         => array
            (
                'type'              => 'VARCHAR',//some telephones have letters and numbers
                'constraint'        => '100',
            ),
            //address
            'address'          => array
            (
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ),
            //email
            'city'          => array
            (
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ),
            //bio
            'bio' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            //date of birth
            'd_o_b'       => array
            (
                'type'              => 'DATETIME'
            ),
            //facebook
            'facebook'         => array
            (
                'type'              =>'VARCHAR',
                'constraint'        => '255'
            ),
            //twitter
            'twitter'         => array
            (
                'type'              =>'VARCHAR',
                'constraint'        => '255'
            ),
            //google_plus
            'google_plus'         => array
            (
                'type'              =>'VARCHAR',
                'constraint'        => '255'
            ),
            //date added
            'dateadded'      => array
            (
                'type'              => 'DATETIME'
            )
        );
        //enum trash fields
        $userinfo_fields['trash'] = array
        (
            'type' => 'ENUM("y","n")',
            'default' => 'n',
            'null' => FALSE,
        );

        //to add fields
        $this->dbforge->add_field($userinfo_fields);
        $this->dbforge->add_key('id', TRUE);//make id primary key
        $this->dbforge->create_table('users_additional_info');

        //echo $this->db->last_query().'<br>hr';






        /*=====================================================================
        * NOTIFICATION TABLE
        * ====================================================================
        */

        //identify fields
        $info_fields = array
        (
            //primary key
            'id'            => array
            (
                'type'              => 'INT',
                'constraint'        => 11,//max number of values
                'unsigned'          => TRUE,//to avoid  -ve values
                'auto_increment'    => TRUE//you can only have one auto increament
            ),
            //userID
            'user_id'       => array
            (
                'type'              =>'INT',
                'constraint'        => '11',
            ),

            //notification
            'notification' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),

            //alert type
            'alert_type'         => array
            (
                'type'              => 'VARCHAR',//some telephones have letters and numbers
                'constraint'        => '100',
            ),

            //date added
            'dateadded'      => array
            (
                'type'              => 'DATETIME'
            ),
            //date added
            'dateaddressed'      => array
            (
                'type'              => 'DATETIME'
            )
        );
        //enum seen fields
        $info_fields['seen'] = array
        (
            'type' => 'ENUM("y","n")',
            'default' => 'n',
            'null' => FALSE,
        );
        //enum trash fields
        $info_fields['trash'] = array
        (
            'type' => 'ENUM("y","n")',
            'default' => 'n',
            'null' => FALSE,
        );

        //to add fields
        $this->dbforge->add_field($info_fields);
        $this->dbforge->add_key('id', TRUE);//make id primary key
        $this->dbforge->create_table('notifications');

        //echo $this->db->last_query().'<br>hr';

        return $this->db->last_query();


    }


}