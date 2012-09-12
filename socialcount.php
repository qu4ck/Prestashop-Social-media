<?php
/*
 * Author : Airlangga bayu seto
 * Email  : qu4ck@Iso.web.id
 *
 * Free Prestashop Module
 */

if (!defined('_PS_VERSION_'))
    exit;

class SocialCount extends Module {
    private $_html;

    /* instalasi */
    public function  __construct() {
        $this->name     = 'socialcount';
        $this->tab      = 'front_office_features';
        $this->version  = 1.0;
        $this->author   = 'Airlangga bayu seto';
        $this->need_instance = 0;
        parent::__construct();
        $this->displayName = $this->l('Social Count');
        $this->description = $this->l('Social Count for prestashop Module [http://www.iso.web.id]');
    }

    public function install() {
        if(!parent::install()
           OR !$this->registerHook('Header')
           OR !$this->registerHook('extraRight')
           OR !$this->registerHook('top')
           OR !Configuration::updateValue('SC_TWITTER', '')
           OR !Configuration::updateValue('SC_GOOGLEPLUS', '')
           OR !Configuration::updateValue('SC_FACEBOOK', '')
          ){
            return false;
        }
        return true;
    }

    public function uninstall() {
        if(!parent::uninstall()
            OR !$this->unregisterHook('Header')
            OR !$this->unregisterHook('extraRight')
            OR !$this->unregisterHook('top')
            OR !Configuration::deleteByName('SC_TWITTER')
            OR !Configuration::deleteByName('SC_GOOGLEPLUS')
            OR !Configuration::deleteByName('SC_FACEBOOK')
        ){
            return false;
        }
        return true;
    }

    /* konfigurasi */
    public function getContent(){
        if (Tools::isSubmit('submitZopim')){
            $facebook   = array(trim(Tools::getValue('fblyt')), trim(Tools::getValue('fbwidth')), trim(Tools::getValue('fbdsp')), trim(Tools::getValue('fbfnt')));
            $twitter    = array(trim(Tools::getValue('twcount')), trim(Tools::getValue('twvia')), trim(Tools::getValue('twchk')), trim(Tools::getValue('twlrg')));
            $google     = array(trim(Tools::getValue('gpsize')), trim(Tools::getValue('gpant')), trim(Tools::getValue('gpwidth')));

            if (empty($facebook)){
                $errors[] = $this->l('Facebook Configure Can\'t empty');
            }else if(empty($twitter)){
                $errors[] = $this->l('Twitter Configure Can\'t empty');
            }else if(empty($google)){
                $errors[] = $this->l('Google one plus Configure Can\'t empty');
            }else{
                Configuration::updateValue('SC_FACEBOOK', implode("|",$facebook));
                Configuration::updateValue('SC_TWITTER', implode("|",$twitter));
                Configuration::updateValue('SC_GOOGLEPLUS', implode("|",$google));
            }

            if (isset($errors) AND sizeof($errors)){
                $this->_html .= $this->displayError(implode('<br />', $errors));
            }else{
                $this->_html .= $this->displayConfirmation($this->l('Social count Success Configure'));
            }
        }

        $this->_displayForm();

        return $this->_html;
    }

    private function _displayForm(){
        $this->_html  .= "<link type=\"text/css\" rel=\"stylesheet\" href=\""._PS_BASE_URL_.__PS_BASE_URI__."modules/".$this->name."/assets/css/admin.css\" />";
        $fb = explode("|", Configuration::get('SC_FACEBOOK'));
        $tw = explode("|", Configuration::get('SC_TWITTER'));
        $gp = explode("|", Configuration::get('SC_GOOGLEPLUS'));

        $fbwidth = (empty($fb[1]))?450:$fb[1];
        $twvia   = (empty($tw[1]))?"":$tw[1];
        $gpwidth = (empty($gp[2]))?450:$gp[2];
        if($gp[0] == 'tall'){
            $tall = "checked=\"checked\"";
        }else if($gp[0] == 'standart'){
            $std = "checked=\"checked\"";
        }else if($gp[0] == 'medium'){
            $mdm = "checked=\"checked\"";
        }else{
            $sml = "checked=\"checked\"";
        }

        $this->_html .="
            <script type=\"text/javascript\">
                $(function(){
                    $(\"#fblyt\").val(\"".$fb[0]."\");
                    $(\"#fbdsp\").val(\"".$fb[2]."\");
                    $(\"#fbfnt\").val(\"".$fb[3]."\");
                    $(\"#twcount\").val(\"".$tw[0]."\");
                    $(\"#twchk\").val([\"".$tw[2]."\"]);
                    $(\"#twlrg\").val([\"".$tw[3]."\"]);
                    $(\"#gpsize\").val([\"".$gp[0]."\"]);
                    $(\"#gpant\").val(\"".$gp[1]."\");
                });
            </script>
            <h2>Social Network Count</h2>
            <form action=\"".$this->_baseUrl."\" method=\"post\">
                <fieldset>
                    <legend> ".$this->l('Facebook like')."</legend>
                    <label>".$this->l('Layout style')."</label>
                    <div class=\"margin-form\">
                        <select name=\"fblyt\" id=\"fblyt\">
                            <option value=\"box_count\" selected=\"selected\">box count</option>
                            <option value=\"standart\">standart</option>
                            <option value=\"button_count\">button count</option>
                        </select>
                        <sup>".$this->l('Default box_count')."</sup>
                    </div>
                    <label>".$this->l('width')."</label>
                    <div class=\"margin-form\">
                        <input name=\"fbwidth\" id=\"fbwidth\" value=\"".  $fbwidth ."\" />
                        <sup>".$this->l('Default 450 pixel for Standart Layout')."</sup>
                    </div>
                    <label>".$this->l('verb to display')."</label>
                    <div class=\"margin-form\">
                        <select name=\"fbdsp\" id=\"fbdsp\">
                            <option value=\"like\">like</option>
                            <option value=\"recommend\">recommend</option>
                        </select>
                        <sup>".$this->l('Default standart')."</sup>
                    </div>
                    <label>".$this->l('Font')."</label>
                    <div class=\"margin-form\">
                        <select name=\"fbfnt\" id=\"fbfnt\">
                            <option value=\"arial\">arial</option>
                            <option value=\"tahoma\">tahoma</option>
                            <option value=\"verdana\">verdana</option>
                        </select>
                        <sup>".$this->l('Default arial')."</sup>
                    </div>
                </fieldset>
                <br />
                <fieldset>
                    <legend> ".$this->l('Twitter button')."</legend>
                    <label>".$this->l('Twitter Count')." </label>
                    <div class=\"margin-form\">
                        <select name=\"twcount\" id=\"twcount\">
                            <option value=\"vertical\">vertical</option>
                            <option value=\"horizontal\">horizontal</option>
                        </select> <sup>".$this->l('Default data count is vertical')."</sup>
                    </div>
                    <label>".$this->l('Via')."</label>
                    <div class=\"margin-form\">
                        @<input type=\"text\" name=\"twvia\" id=\"twvia\" value=\"".$twvia."\" /> <sup>".$this->l('Input your twitter Username')."</sup>
                    </div>
                    <label></label>
                    <div class=\"margin-form\">
                        <input type=\"checkbox\" name=\"twchk\" id=\"twchk\" value=\"none\" /> ".$this->l('Show Count')."
                    </div>
                    <label></label>
                    <div class=\"margin-form\">
                        <input type=\"checkbox\" name=\"twlrg\" id=\"twlrg\" value=\"large\" /> ".$this->l('Large button')."
                    </div>
                </fieldset>
                <br />
                <fieldset>
                    <legend> ".$this->l('Google plus one')."</legend>
                    <label>".$this->l('Size')." </label>
                    <div class=\"margin-form\" id=\"googleplus\">
                        <input type=\"radio\" name=\"gpsize\" id=\"gpsize\" value=\"small\" ".$sml." /> <sup>".$this->l('Small (15px)')."</sup>
                        <input type=\"radio\" name=\"gpsize\" id=\"gpsize\" value=\"medium\" ".$mdm." /> <sup>".$this->l('Medium (20px)')."</sup>
                        <input type=\"radio\" name=\"gpsize\" id=\"gpsize\" value=\"standart\" ".$std." /> <sup>".$this->l('Standart (24px)')."</sup>
                        <input type=\"radio\" name=\"gpsize\" id=\"gpsize\" value=\"tall\" ".$tall." /> <sup>".$this->l('Tall (60px)')."</sup>
                    </div>
                    <label>".$this->l('Annotation')." </label>
                    <div class=\"margin-form\">
                        <select name=\"gpant\" id=\"gpant\">
                            <option value=\"bubble\">bubble</option>
                            <option value=\"inline\" id=\"inline\">inline</option>
                            <option value=\"none\">none</option>
                        </select>
                        ".$this->l('Default bubble')."
                    </div>
                    <label>".$this->l('Width')." </label>
                    <div class=\"margin-form\">
                        <input type=\"text\" name=\"gpwidth\" value=\"". $gpwidth ."\"  /> <sup>".$this->l('Default 450 pixel for Inline Annotation')."</sup>
                    </div>
                </fieldset>
                <br />
                <input type=\"submit\" name=\"submitZopim\" value=\"".$this->l('Save')."\" class=\"button\" />
                <input type=\"reset\" name=\"resetZopim\" value=\"".$this->l('Cancel')."\" class=\"button\" />
            </form>";

        return $this->_html;
    }

    /* hook*/
    function hookHeader(){
        Tools::addCSS($this->_path.'socialcount.css', 'all');
        $this->display(__FILE__, 'assets/tpl/facebook.tpl');
    }

    function hookTop(){
        return $this->display(__FILE__, 'assets/tpl/top.tpl');
    }

    function hookExtraRight(){
        global $smarty;

        $smarty->assign(
            array( "fb"     => explode("|",Configuration::get('SC_FACEBOOK'))
                  ,"tw"     => explode("|",Configuration::get('SC_TWITTER'))
                  ,"gp"     => explode("|",Configuration::get('SC_GOOGLEPLUS'))
            )
        );
        return $this->display(__FILE__, 'assets/tpl/socialcount.tpl');
    }
}
?>
