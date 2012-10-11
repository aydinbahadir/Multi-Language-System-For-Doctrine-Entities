<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(PATH_ENTITIES.'BbrLanguage.php');
require_once(PATH_ENTITIES.'BbrTranslation.php');
// ------------------------------------------------------------------------
/**
 * BBR_BaseEntity Class
 * 
 * This class is used to handle translate options about entities.
 * 
 * !! Potential Warning -- This Class works with Doctrine ORM v2.2.2 and hasnt been tested with other versions !!
 *
 * @package		MLS 
 * @category	Entities
 * 
 * @author		Mehmet Aydýn Bahadýr
 * @version     1.0.0
 * @date        11.10.2012
 */
class BBR_BaseEntity {
    
    private $ci;         /** codeigniter instance */
    private $error_log;  /** error log array */
    private $mode;       /** translation mode from config */
    public  $flag = false;       /** translate function is called? */
    private $em;         /** entity manager object */
    
    private $table_name;
    
    public function __construct($class_name = ''){
        $this->ci =& get_instance();
        $this->error_log = array();
        $this->mode = $this->ci->config->item('translation_mode');
        $this->em = $this->ci->doctrine->em;
        
        $this->flag = true;
        $this->table_name = $class_name;
    }
    
    /**
     * translate()
     * 
     * @access      public
     * 
     * @param       string      $name_safe_lang
     * @return      this
     * 
     * translates all of objects and returns it
     */
    public function translate($name_safe_lang){
        $this->__construct(array(), '');
        if(!$this->flag){       /** check if it is a proxy object */
            $this->ci =& get_instance();
            $this->error_log = array();
            $this->mode = $this->ci->config->item('translation_mode');
            $this->em = $this->ci->doctrine->em;
            
            $this->table_name = str_replace('Proxies\__CG__\\', '', get_class($this));       
            $this->flag = true;     
                    
        }
        $language = $this->em->getRepository('BbrLanguage')->findOneBy(array('nameSafe' => $name_safe_lang));
        if(!count($language) > 0){
            $this->error_log[] = array('class'    => get_class($this),
                                       'method'   => __METHOD__,
                                       'error'    => ExD1x001,
                                       'hint'     => 'Check if your WHERE clause is correct or check if there is matching data in database.',
                                       'exception'=> ''
            );
            return false;
        }
        foreach($this->translation_fields as $translation_field){
            $translation = $this->em->getRepository('BbrTranslation')->findOneBy(array( 'table'  => $this->table_name,
                                                                                        'column' => $translation_field,
                                                                                        'row'    => $this->getId(),
                                                                                        'language' => $language->getId()));
            if(!count($translation) > 0){
                $this->error_log[] = array('class'    => get_class($this),
                                           'method'   => __METHOD__,
                                           'error'    => ExD1x001,
                                           'hint'     => 'Check if your WHERE clause is correct or check if there is matching data in database.',
                                           'exception'=> ''
                );
            }
            else{
                $function_name = 'set'.ucfirst($translation_field);
                $this->$function_name($translation->getTranslation());
            }
        }
        return $this;
    }
        
}
