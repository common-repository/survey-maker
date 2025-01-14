<?php
    $action = ( isset($_GET['action']) ) ? $_GET['action'] : '';
    $id     = ( isset($_GET['survey']) ) ? $_GET['survey'] : null;

    // if($action == 'duplicate'){
    //     $this->surveys_obj->duplicate_item( $id );
    // }
    $max_id = 10;//$this->get_max_id('questions');
?>

<div class="wrap ays_surveys_list_table">
    <h1 class="wp-heading-inline">
        <?php
            echo __(esc_html(get_admin_page_title()),$this->plugin_name);
            echo sprintf( '<a href="?page=%s&action=%s" class="page-title-action">' . __('Add New', $this->plugin_name) . '</a>', esc_attr( $_REQUEST['page'] ), 'add');
        ?>
    </h1>

    <?php if($max_id <= 6): ?>
    <div class="notice notice-success is-dismissible">
        <p style="font-size:14px;">
            <strong>
                <?php echo __( "If you haven't created questions yet, you need to create the questions at first.", $this->plugin_name ); ?> 
            </strong>
            <br>
            <strong>
                <em>
                    <?php echo __( "For creating a question go", $this->plugin_name ); ?> 
                    <a href="<?php echo admin_url('admin.php') . "?page=".$this->plugin_name . "-questions"; ?>" target="_blank">
                        <?php echo __( "here", $this->plugin_name ); ?>.
                    </a>
                </em>
            </strong>
        </p>
    </div>
    <?php endif; ?>
    <div id="poststuff" style="margin-top:20px;">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <?php
                        $this->surveys_obj->views();
                    ?>
                    <form method="post">
                        <?php
                            $this->surveys_obj->prepare_items();
                            $search = __( "Search", $this->plugin_name );
                            $this->surveys_obj->search_box($search, $this->plugin_name);
                            $this->surveys_obj->display();
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>
