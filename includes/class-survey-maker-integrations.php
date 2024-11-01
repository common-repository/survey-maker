<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Survey_Maker
 * @subpackage Survey_Maker/includes
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Survey_Maker
 * @subpackage Survey_Maker/includes
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Survey_Maker_Integrations
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    private $capability;

    /**
     * The settings object of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      object    $settings_obj    The settings object of this plugin.
     */
    private $settings_obj;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version){

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        $this->settings_obj = new Survey_Maker_Settings_Actions($this->plugin_name);
    }

    // ===== INTEGRATIONS HOOKS =====

    // Integrations survey page action hook
    public function ays_survey_page_integrations_content( $args ){

        $integrations_contents = apply_filters( 'ays_sm_survey_page_integrations_contents', array(), $args );
        
        $integrations = array();

        foreach ($integrations_contents as $key => $integrations_content) {
            $content = '<fieldset>';
            if(isset($integrations_content['title'])){
                $content .= '<legend>';
                if(isset($integrations_content['icon'])){
                    $content .= '<img class="ays_integration_logo" src="'. $integrations_content['icon'] .'" alt="">';
                }
                $content .= '<h5>'. $integrations_content['title'] .'</h5></legend>';
            }
            $content .= $integrations_content['content'];

            $content .= '</fieldset>';

            $integrations[] = $content;
        }

        echo implode('<hr/>', $integrations);
    }

    // Integrations settings page action hook
    public function ays_settings_page_integrations_content( $args ){

        $integrations_contents = apply_filters( 'ays_sm_settings_page_integrations_contents', array(), $args );
        
        $integrations = array();

        foreach ($integrations_contents as $key => $integrations_content) {
            $content = '<fieldset>';
            if(isset($integrations_content['title'])){
                $content .= '<legend>';
                if(isset($integrations_content['icon'])){
                    $content .= '<img class="ays_integration_logo" src="'. $integrations_content['icon'] .'" alt="">';
                }
                $content .= '<h5>'. $integrations_content['title'] .'</h5></legend>';
            }
            if(isset($integrations_content['content'])){
                $content .= $integrations_content['content'];
            }

            $content .= '</fieldset>';

            $integrations[] = $content;
        }

        echo implode('<hr/>', $integrations);
    }

    ////////////////////////////////////////////////////////////////////////////////////////
    //====================================================================================//
    ////////////////////////////////////////////////////////////////////////////////////////

    // ===== MailChimp integration start =====
    // MailChimp integration / survey page

    // MailChimp integration in survey page content
    public function ays_survey_page_mailchimp_content( $integrations, $args ){
        
        $icon = SURVEY_MAKER_ADMIN_URL .'/images/integrations/mailchimp_logo.png';
        $title = __('MailChimp Settings',$this->plugin_name);

        $content = '';

        $content .= '<div class="form-group row" style="margin:0px;">';
        $content .= '<div class="col-sm-12 only_pro">';
            $content .= '<div class="pro_features">';
                $content .= '<div>';
                    $content .= '<p>';
                        $content .= __("This feature is available only in ", $this->plugin_name);
                        $content .= '<a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"> ' .__("PRO version!!!", $this->plugin_name) .'</a>';
                    $content .= '</p>';
                $content .= '</div>';
            $content .= '</div>';
        $content .= '<hr>';
        $content .= '<div class="form-group row">
            <div class="col-sm-4">
                <label for="ays_enable_mailchimp">'. __('Enable MailChimp',$this->plugin_name) .'</label>
            </div>
            <div class="col-sm-1">
                <input type="checkbox" class="ays-enable-timer1" id="ays_enable_mailchimp" value="on" >';
        $content .= '
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <label for="ays_mailchimp_list">'. __('MailChimp list',$this->plugin_name) .'</label>
            </div>
            <div class="col-sm-8">';
        $content .= '<select id="ays_mailchimp_list">';
        $content .= '<option value="" disabled selected>'. __( "Select list", $this->plugin_name ) .'</option>';
        $content .= '</select>';
        $content .= '</div>
        </div>
        </div>
        </div>';

        $integrations['mailchimp'] = array(
            'content' => $content,
            'icon' => $icon,
            'title' => $title,
        );

        return $integrations;        
    }

    // MailChimp integration / settings page

    // MailChimp integration in General settings page content
    public function ays_settings_page_mailchimp_content( $integrations, $args ){

        $actions = $this->settings_obj;

        $mailchimp_res = ($actions->ays_get_setting('mailchimp') === false) ? json_encode(array()) : $actions->ays_get_setting('mailchimp');
        $mailchimp = json_decode($mailchimp_res, true);
        $mailchimp_username = isset($mailchimp['username']) ? $mailchimp['username'] : '' ;
        $mailchimp_api_key = isset($mailchimp['apiKey']) ? $mailchimp['apiKey'] : '' ;

        $icon  = SURVEY_MAKER_ADMIN_URL . '/images/integrations/mailchimp_logo.png';
        $title = __( 'MailChimp', $this->plugin_name );

        $content = '';
        $content .= '<div class="form-group row" style="margin:0px;">';
        $content .= '<div class="col-sm-12 only_pro">';
            $content .= '<div class="pro_features">';
                $content .= '<div>';
                    $content .= '<p>';
                        $content .= __("This feature is available only in ", $this->plugin_name);
                        $content .= '<a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"> ' .__("PRO version!!!", $this->plugin_name) .'</a>';
                    $content .= '</p>';
                $content .= '</div>';
            $content .= '</div>';
        $content .= '<div class="form-group row">
            <div class="col-sm-12">
                <div class="form-group row" aria-describedby="aaa">
                    <div class="col-sm-3">
                        <label for="ays_mailchimp_username">'. __( 'MailChimp Username', $this->plugin_name ) .'</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" 
                            class="ays-text-input" 
                            id="ays_mailchimp_username" 
                            name="ays_mailchimp_username"
                            value="'. $mailchimp_username .'"
                        />
                    </div>
                </div>
                <hr/>
                <div class="form-group row" aria-describedby="aaa">
                    <div class="col-sm-3">
                        <label for="ays_mailchimp_api_key">'. __( 'MailChimp API Key', $this->plugin_name ) .'</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" 
                            class="ays-text-input" 
                            id="ays_mailchimp_api_key" 
                            name="ays_mailchimp_api_key"
                            value="'. $mailchimp_api_key .'"
                        />
                    </div>
                </div>
                <blockquote>';
        $content .= sprintf( __( "You can get your API key from your ", $this->plugin_name ) . "<a href='%s' target='_blank'> %s.</a>", "https://us20.admin.mailchimp.com/account/api/", "Account Extras menu" );
        $content .= '</blockquote>
            </div>
        </div>
        </div>
        </div>';

        $integrations['mailchimp'] = array(
            'content' => $content,
            'icon' => $icon,
            'title' => $title,
        );

        return $integrations;        
    }

    // ===== MailChimp integration end =====

    ////////////////////////////////////////////////////////////////////////////////////////
    //====================================================================================//
    ////////////////////////////////////////////////////////////////////////////////////////

    // ===== Campaign Monitor start =====    
    // Campaign Monitor integration / survey page

    // Campaign Monitor integration in survey page content
    public function ays_survey_page_camp_monitor_content($integrations, $args){

        $icon = SURVEY_MAKER_ADMIN_URL .'/images/integrations/campaignmonitor_logo.png';
        $title = __('Campaign Monitor Settings',$this->plugin_name);
        $content = '';

        $content .= '<div class="form-group row" style="margin:0px;">';
        $content .= '<div class="col-sm-12 only_pro">';
            $content .= '<div class="pro_features">';
                $content .= '<div>';
                    $content .= '<p>';
                        $content .= __("This feature is available only in ", $this->plugin_name);
                        $content .= '<a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"> ' .__("PRO version!!!", $this->plugin_name) .'</a>';
                    $content .= '</p>';
                $content .= '</div>';
            $content .= '</div>';
        $content .= '<hr/>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="ays_enable_monitor">'.__('Enable Campaign Monitor', $this->plugin_name).'</label>
                </div>
                <div class="col-sm-1">
                    <input type="checkbox" class="ays-enable-timer1" id="ays_enable_monitor" value="on" />
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="ays_monitor_list">'.__('Campaign Monitor list', $this->plugin_name).'</label>
                </div>
                <div class="col-sm-8">';
            $content .= '<select id="ays_monitor_list">
                <option disabled selected>'.__("Select List", $this->plugin_name).'</option>';
            $content .= '</select>';
        $content .= '
                </div>
            </div>
        </div>';
        
        $integrations['monitor'] = array(
            'content' => $content,
            'icon'    => $icon,
            'title'   => $title,
        );

        return $integrations;
    }
    
    // Campaign Monitor integration / settings page

    // Campaign Monitor integration in General settings page
    public function ays_settings_page_campaign_monitor_content( $integrations, $args ){
        $actions = $this->settings_obj;
        
        $monitor_res     = ($actions->ays_get_setting('monitor') === false) ? json_encode(array()) : $actions->ays_get_setting('monitor');
        $monitor         = json_decode($monitor_res, true);
        $monitor_client  = isset($monitor['client']) ? $monitor['client'] : '';
        $monitor_api_key = isset($monitor['apiKey']) ? $monitor['apiKey'] : '';
        
        $icon  = SURVEY_MAKER_ADMIN_URL . '/images/integrations/campaignmonitor_logo.png';
        $title = __( 'Campaign Monitor', $this->plugin_name );

        $content = '';
        $content .= '<div class="form-group row" style="margin:0px;">';
        $content .= '<div class="col-sm-12 only_pro">';
            $content .= '<div class="pro_features">';
                $content .= '<div>';
                    $content .= '<p>';
                        $content .= __("This feature is available only in ", $this->plugin_name);
                        $content .= '<a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"> ' .__("PRO version!!!", $this->plugin_name) .'</a>';
                    $content .= '</p>';
                $content .= '</div>';
            $content .= '</div>';
        $content .= '<div class="form-group row">
            <div class="col-sm-12">
                <div class="form-group row" aria-describedby="aaa">
                    <div class="col-sm-3">
                        <label for="ays_monitor_client">'. __( 'Campaign Monitor Client ID', $this->plugin_name ) .'</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" 
                            class="ays-text-input" 
                            id="ays_monitor_client" 
                            name="ays_monitor_client"
                            value="'. $monitor_client .'"
                        />
                    </div>
                </div>
                <hr/>
                <div class="form-group row" aria-describedby="aaa">
                    <div class="col-sm-3">
                        <label for="ays_monitor_api_key">'. __( 'Campaign Monitor API Key', $this->plugin_name ) .'</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" 
                            class="ays-text-input" 
                            id="ays_monitor_api_key" 
                            name="ays_monitor_api_key"
                            value="'. $monitor_api_key .'"
                        />
                    </div>
                </div>
                <blockquote>';
        $content .= __( "You can get your API key and Client ID from your Account Settings page.");
        $content .= '</blockquote>
            </div>
        </div>
        </div>
        </div>';

        $integrations['monitor'] = array(
            'content' => $content,
            'icon' => $icon,
            'title' => $title
        );

        return $integrations;
    }


    // ===== Campaign Monitor end =====

    ////////////////////////////////////////////////////////////////////////////////////////
    //====================================================================================//
    ////////////////////////////////////////////////////////////////////////////////////////

    // ===== Zapier start =====

    // Zapier integration / survey page

    // Zapier integration in survey page content
    public function ays_survey_page_zapier_content($integrations, $args){

        $icon = SURVEY_MAKER_ADMIN_URL .'/images/integrations/zapier_logo.png';
        $title = __('Zapier Settings',$this->plugin_name);

        $content = '';

        $content .= '<div class="form-group row" style="margin:0px;">';
        $content .= '<div class="col-sm-12 only_pro">';
            $content .= '<div class="pro_features">';
                $content .= '<div>';
                    $content .= '<p>';
                        $content .= __("This feature is available only in ", $this->plugin_name);
                        $content .= '<a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"> ' .__("PRO version!!!", $this->plugin_name) .'</a>';
                    $content .= '</p>';
                $content .= '</div>';
            $content .= '</div>';
        $content .= '<hr/>
        <div class="form-group row">
            <div class="col-sm-4">
                <label for="ays_enable_zapier">'.__('Enable Zapier Integration', $this->plugin_name).'</label>
            </div>
            <div class="col-sm-1">
                <input type="checkbox" class="ays-enable-timer1" id="ays_enable_zapier" value="on" >   
            </div>
            <div class="col-sm-3">
                <button type="button" id="testZapier" class="btn btn-outline-secondary">'.__("Send test data", $this->plugin_name).'</button>
                <a class="ays_help" data-toggle="tooltip" style="font-size: 16px;"
                   title="'.__("We will send you a test data, and you can catch it in your ZAP for configure it.", $this->plugin_name).'">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </div>
        </div>
        </div>
        </div>';

        $integrations['zapier'] = array(
            'content' => $content,
            'icon'    => $icon,
            'title'   => $title,
        );
        return $integrations;
    }

    // Zapier integration / settings page

    // Zapier integration in General settings page content
    public function ays_settings_page_zapier_content( $integrations, $args ){
        $actions = $this->settings_obj;
        
        $zapier_res  = ($actions->ays_get_setting('zapier') === false) ? json_encode(array()) : $actions->ays_get_setting('zapier');
        $zapier      = json_decode($zapier_res, true);
        $zapier_hook = isset($zapier['hook']) ? $zapier['hook'] : '';
        
        $icon  = SURVEY_MAKER_ADMIN_URL . '/images/integrations/zapier_logo.png';
        $title = __( 'Zapier', $this->plugin_name );

        $content = '';
        $content .= '<div class="form-group row" style="margin:0px;">';
        $content .= '<div class="col-sm-12 only_pro">';
            $content .= '<div class="pro_features">';
                $content .= '<div>';
                    $content .= '<p>';
                        $content .= __("This feature is available only in ", $this->plugin_name);
                        $content .= '<a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"> ' .__("PRO version!!!", $this->plugin_name) .'</a>';
                    $content .= '</p>';
                $content .= '</div>';
            $content .= '</div>';
        $content .= '<div class="form-group row">
            <div class="col-sm-12">
                <div class="form-group row" aria-describedby="aaa">
                    <div class="col-sm-3">
                        <label for="ays_zapier_hook">'. __( 'Zapier Webhook URL', $this->plugin_name ) .'</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" 
                            class="ays-text-input"
                            id="ays_zapier_hook" 
                            name="ays_zapier_hook"
                            value="'. $zapier_hook .'"
                        />
                    </div>
                </div>
                <blockquote>';
        $content .= sprintf( __( "If you don’t have any ZAP created, go", $this->plugin_name ) . "<a href='%s' target='_blank'> %s.</a>", "https://zapier.com/app/editor/", "here..." );
        $content .= '</blockquote>
                    <blockquote>
                    '.__("We will send you all data from survey information form with the “AysSurvey” key by POST method.").'
                    </blockquote>
            </div>
        </div>
        </div>
        </div>';

        $integrations['zapier'] = array(
            'content' => $content,
            'icon' => $icon,
            'title' => $title
        );

        return $integrations;
    }

    // ===== Zapier end =====

    ////////////////////////////////////////////////////////////////////////////////////////
    //====================================================================================//
    ////////////////////////////////////////////////////////////////////////////////////////

    // ===== Active Campaign start =====

    // Active Campaign integration / survey page
    
    // Active Campaign integration in survey page content
    public function ays_survey_page_active_camp_content($integrations, $args){
        
        $icon = SURVEY_MAKER_ADMIN_URL .'/images/integrations/activecampaign_logo.png';
        $title = __('ActiveCampaign Settings', $this->plugin_name);

        $content = '';
        $content .= '<div class="form-group row" style="margin:0px;">';
        $content .= '<div class="col-sm-12 only_pro">';
            $content .= '<div class="pro_features">';
                $content .= '<div>';
                    $content .= '<p>';
                        $content .= __("This feature is available only in ", $this->plugin_name);
                        $content .= '<a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"> ' .__("PRO version!!!", $this->plugin_name) .'</a>';
                    $content .= '</p>';
                $content .= '</div>';
            $content .= '</div>';
                $content .= '<hr/>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="ays_enable_active_camp">'. __('Enable ActiveCampaign', $this->plugin_name) .'</label>
                    </div>
                    <div class="col-sm-1">
                        <input type="checkbox" class="ays-enable-timer1" id="ays_enable_active_camp" value="on">
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="ays_active_camp_list">'.__('ActiveCampaign list', $this->plugin_name).'</label>
                    </div>
                    <div class="col-sm-8">';
            $content .= '<select id="ays_active_camp_list">
                <option value="" disabled selected>'. __("Select List", $this->plugin_name) .'</option>
                <option value="">'.__("Just create contact", $this->plugin_name).'</option>';
            $content .= '</select></div>';
        $content .= '</div><hr>';
        $content .= '
        <div class="form-group row">
            <div class="col-sm-4">
                <label for="ays_active_camp_automation">'.__("ActiveCampaign automation", $this->plugin_name).'</label>
            </div>
            <div class="col-sm-8">';
                
        $content .= '<select id="ays_active_camp_automation">
            <option value="" disabled selected>'.__("Select List", $this->plugin_name).'</option>
            <option value="">'.__("Just create contact", $this->plugin_name).'</option>';
        $content .= '</select></div>';
        $content .= '</div></div>';

        $integrations['active_camp'] = array(
            'content' => $content,
            'icon'    => $icon,
            'title'   => $title,
        );

        return $integrations;
    }

    
    // Active Campaign integration / settings page

    // Active Campaign integration in Gengeral settings page content
    public function ays_settings_page_active_camp_content( $integrations, $args ){
        $actions = $this->settings_obj;
        
        $active_camp_res     = ($actions->ays_get_setting('active_camp') === false) ? json_encode(array()) : $actions->ays_get_setting('active_camp');
        $active_camp         = json_decode($active_camp_res, true);
        $active_camp_url     = isset($active_camp['url']) ? $active_camp['url'] : '';
        $active_camp_api_key = isset($active_camp['apiKey']) ? $active_camp['apiKey'] : '';
        
        $icon  = SURVEY_MAKER_ADMIN_URL . '/images/integrations/activecampaign_logo.png';
        $title = __( 'ActiveCampaign', $this->plugin_name );

        $content = '';
        $content .= '<div class="form-group row" style="margin:0px;">';
        $content .= '<div class="col-sm-12 only_pro">';
            $content .= '<div class="pro_features">';
                $content .= '<div>';
                    $content .= '<p>';
                        $content .= __("This feature is available only in ", $this->plugin_name);
                        $content .= '<a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"> ' .__("PRO version!!!", $this->plugin_name) .'</a>';
                    $content .= '</p>';
                $content .= '</div>';
            $content .= '</div>';
        $content .= '<div class="form-group row">
                        <div class="col-sm-12">
                        <div class="form-group row" aria-describedby="aaa">
                            <div class="col-sm-3">
                                <label for="ays_active_camp_url">'. __( 'API Access URL', $this->plugin_name ) .'</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" 
                                    class="ays-text-input" 
                                    id="ays_active_camp_url" 
                                    name="ays_active_camp_url"
                                    value="'. $active_camp_url .'"
                                />
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row" aria-describedby="aaa">
                            <div class="col-sm-3">
                                <label for="ays_active_camp_api_key">'. __( 'API Access Key', $this->plugin_name ) .'</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" 
                                    class="ays-text-input" 
                                    id="ays_active_camp_api_key" 
                                    name="ays_active_camp_api_key"
                                    value="'. $active_camp_api_key .'"
                                />
                            </div>
                        </div>
                <blockquote>';
        $content .= __( "Your API URL and Key can be found in your account on the My Settings page under the “Developer” tab.");
        $content .= '</blockquote>
            </div>
        </div>
        </div>
        </div>';

        $integrations['active_camp'] = array(
            'content' => $content,
            'icon' => $icon,
            'title' => $title
        );

        return $integrations;
    }

    // ===== Active Campaign end =====
    
    ////////////////////////////////////////////////////////////////////////////////////////
    //====================================================================================//
    ////////////////////////////////////////////////////////////////////////////////////////

    // ===== Slack Campaign start =====
    
    // Slack integration / survey page

    // Slack integration in survey page content    
    public function ays_survey_page_slack_content($integrations, $args){

        $content = '';
        $icon  = SURVEY_MAKER_ADMIN_URL .'/images/integrations/slack_logo.png';
        $title = __('Slack Settings',$this->plugin_name);
        $content = '';

        $content .= '<div class="form-group row" style="margin:0px;">';
        $content .= '<div class="col-sm-12 only_pro">';
            $content .= '<div class="pro_features">';
                $content .= '<div>';
                    $content .= '<p>';
                        $content .= __("This feature is available only in ", $this->plugin_name);
                        $content .= '<a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"> ' .__("PRO version!!!", $this->plugin_name) .'</a>';
                    $content .= '</p>';
                $content .= '</div>';
            $content .= '</div>';
        
        $content .= '
        <hr/>
        <div class="form-group row">
            <div class="col-sm-4">
                <label for="ays_enable_slack">'.__("Enable Slack integration", $this->plugin_name).'</label>
            </div>
            <div class="col-sm-1">
                <input type="checkbox" class="ays-enable-timer1" id="ays_enable_slack" value="on">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-4">
                <label for="ays_slack_conversation">'.__("Slack conversation", $this->plugin_name).'</label>
            </div>
            <div class="col-sm-8">';
        $content .= '<select name="ays_slack_conversation" id="ays_slack_conversation">
                <option value="" disabled selected>'.__("Select Channel", $this->plugin_name).'</option>';
        $content .= '</select>';
        $content .= '</div></div>';
        $content .= '</div></div>';

        $integrations['slack'] = array(
            'content' => $content,
            'icon'    => $icon,
            'title'   => $title,
        );

        return $integrations;
    }
    
    // Slack integration / settings page

    // Slack integration in General settings page content
    public function ays_settings_page_slack_content( $integrations, $args ){
        $actions = $this->settings_obj;
        
        $slack_res    = ($actions->ays_get_setting('slack') === false) ? json_encode(array()) : $actions->ays_get_setting('slack');
        $slack        = json_decode($slack_res, true);
        $slack_client = isset($slack['client']) ? $slack['client'] : '';
        $slack_secret = isset($slack['secret']) ? $slack['secret'] : '';
        $slack_token  = isset($slack['token']) ? $slack['token'] : '';
        $slack_oauth  = !empty($_GET['oauth']) && $_GET['oauth'] == 'slack';
        
        $data_code = '';
        $code_content = sprintf(__("1. You will need to " . "<a href='%s' target='_blank'>%s</a>" . " new Slack App.", $this->plugin_name), "https://api.slack.com/apps?new_app=1", "create");
        $server_http = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://")) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "&oauth=slack";
        $slack_readonly = $slack_oauth ? '' : 'readonly';
        if ($slack_oauth) {
            $slack_temp_code = !empty($_GET['code']) ? $_GET['code'] : "";
            $slack_client    = !empty($_GET['state']) ? $_GET['state'] : "";
            $data_code       = !empty($slack_temp_code) ? $slack_temp_code : "";
            $ays_survey_tab  = 'tab2';
        }
        
        $icon  = SURVEY_MAKER_ADMIN_URL . '/images/integrations/slack_logo.png';
        $title = __( 'Slack', $this->plugin_name );

        $content = '';
        $content .= '<div class="form-group row" style="margin:0px;">';
        $content .= '<div class="col-sm-12 only_pro">';
            $content .= '<div class="pro_features">';
                $content .= '<div>';
                    $content .= '<p>';
                        $content .= __("This feature is available only in ", $this->plugin_name);
                        $content .= '<a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"> ' .__("PRO version!!!", $this->plugin_name) .'</a>';
                    $content .= '</p>';
                $content .= '</div>';
            $content .= '</div>';
        $content .= '<div class="form-group row">
                        <div class="col-sm-12">';
        if(!$slack_oauth){
            $content .= '<div class="form-group row" aria-describedby="aaa">
                            <div class="col-sm-3">
                                <button id="slackInstructionsPopOver" type="button" class="btn btn-info" title="'.__("Slack Integration Setup Instructions", $this->plugin_name).'">'.__("Instructions", $this->plugin_name).'</button>
                                <div class="d-none" id="slackInstructions">
                                    <p>'.$code_content.'</p>
                                    <p>'.__("2. Complete Project creation for get App credentials.", $this->plugin_name).'</p>
                                    <p>'.__("3. Next, go to the Features > OAuth & Permissions > Redirect URLs section.", $this->plugin_name).'</p>
                                    <p>'.__("4. Click Add a new Redirect URL.", $this->plugin_name).'</p>
                                    <p>'.__("5. In the shown input field, put this value below", $this->plugin_name).'</p>
                                    <p>
                                        <code>'.$server_http.'</code>
                                    </p>
                                    <p>'.__("6. Then click the Add button.", $this->plugin_name).'</p>
                                    <p>'.__("7. Then click the Save URLs button.", $this->plugin_name).'</p>
                                </div>
                            </div>
                        </div>';
        }
        $content .= '<div class="form-group row" aria-describedby="aaa">
                        <div class="col-sm-3">
                            <label for="ays_slack_client">
                                '.__("App Client ID", $this->plugin_name).'
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="ays-text-input" id="ays_slack_client" name="ays_slack_client" value='.$slack_client.'>
                        </div>
                    </div>
                    <hr/>';
        $content .= '<div class="form-group row" aria-describedby="aaa">
                        <div class="col-sm-3">
                            <label for="ays_slack_oauth">'.__("Slack Authorization", $this->plugin_name).'</label>
                        </div>
                        <div class="col-sm-9">';
                        if($slack_oauth){
                            $content .= '<span class="btn btn-success pointer-events-none">'.__("Authorized", $this->plugin_name).'</span>';
                        }
                        else{
                            $content .= '<button type="button" id="slackOAuth2" class="btn btn-outline-secondary disabled">'.__("Authorize", $this->plugin_name).'</button>';
                        }

        $content .= '</div>
                    </div>
                    <hr/>';
        $content .= '<div class="form-group row" aria-describedby="aaa">
                        <div class="col-sm-3">
                            <label for="ays_slack_secret">'.__('App Client Secret', $this->plugin_name).'</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="ays-text-input" id="ays_slack_secret" name="ays_slack_secret" value="'.$slack_secret.'" '.$slack_readonly.'>
                        </div>
                    </div>
                    <hr/>';                    
        $content .= '<div class="form-group row" aria-describedby="aaa">
                        <div class="col-sm-3">
                            <label for="ays_slack_oauth">'.__('App Access Token', $this->plugin_name).'</label>
                        </div>
                        <div class="col-sm-9">';
                        if($slack_oauth){
                            $content .= '<button type="button" data-code='.$data_code.' id="slackOAuthGetToken" data-success='.__("Access granted", $this->plugin_name).' class="btn btn-outline-secondary disabled">'.__("Get it", $this->plugin_name).'</button>';
                        }
                        else{
                            $content .= '<button type="button" class="btn btn-outline-secondary disabled">'.__("Need Authorization", $this->plugin_name).'</button>';
                            $content .= '<input type="hidden" id="ays_slack_token" name="ays_slack_token" value="'.$slack_token.'">';
                        }
        $content .= '</div></div>';

        $content .= '<blockquote>
                        '.__( "You can get your App Client ID and Client Secret from your App’s Basic Information page.").'
                    </blockquote>
            </div>
        </div>
        </div>
        </div>';

        $integrations['slack'] = array(
            'content' => $content,
            'icon' => $icon,
            'title' => $title
        );

        return $integrations;
    }

    // ===== Slack end =====
}
