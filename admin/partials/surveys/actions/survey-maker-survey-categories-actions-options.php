<?php
    $action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';

    $id = (isset($_GET['id'])) ? absint(intval($_GET['id'])) : null;

    $html_name_prefix = 'ays_';

    $user_id = get_current_user_id();

    $options = array(

    );

    $object = array(
        'title' => '',
        'description' => '',
        'status' => 'published',
        'date_created' => current_time( 'mysql' ),
        'date_modified' => current_time( 'mysql' ),
        'options' => json_encode( $options ),
    );

    $heading = '';
    switch ($action) {
        case 'add':
            $heading = __( 'Add new category', $this->plugin_name );
            break;
        case 'edit':
            $heading = __( 'Edit category', $this->plugin_name );
            $object = $this->surveys_categories_obj->get_item_by_id( $id );
            break;
    }

    if (isset($_POST['ays_submit']) || isset($_POST['ays_submit_top'])) {
        $_POST["id"] = $id;
        $this->surveys_categories_obj->add_or_edit_item();
    }

    if(isset($_POST['ays_apply']) || isset($_POST['ays_apply_top'])){
        $_POST["id"] = $id;
        $_POST['save_type'] = 'apply';
        $this->surveys_categories_obj->add_or_edit_item();
    }

    if(isset($_POST['ays_save_new']) || isset($_POST['ays_save_new_top'])){
        $_POST["id"] = $id;
        $_POST['save_type'] = 'save_new';
        $this->surveys_categories_obj->add_or_edit_item();
    }


    // Options
    $options = isset( $object['options'] ) && $object['options'] != '' ? $object['options'] : '';
    $options = json_decode( $options, true );

    // Title
    $title = isset( $object['title'] ) && $object['title'] != '' ? stripslashes( htmlentities( $object['title'] ) ) : '';
    
    // Description
    $description = isset( $object['description'] ) && $object['description'] != '' ? stripslashes( htmlentities( $object['description'] ) ) : '';
    
    // Status
    $status = isset( $object['status'] ) && $object['status'] != '' ? stripslashes( $object['status'] ) : 'published';
    
    // Date created
    $date_created = isset( $object['date_created'] ) && Survey_Maker_Admin::validateDate( $object['date_created'] ) ? $object['date_created'] : current_time( 'mysql' );
    
    // Date modified
    $date_modified = current_time( 'mysql' );