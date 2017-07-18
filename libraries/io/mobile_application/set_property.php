<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

_wpl_import('libraries.property');
_wpl_import('libraries.locations');
_wpl_import('libraries.file');
_wpl_import('libraries.items');

class wpl_io_cmd_set_property extends wpl_io_cmd_base
{
    private $built;
    private $pid;
    private $property_uid;

    /**
     * This method is the main method of each commands
     * @return mixed
     */
    public function build()
    {
        $this->property_uid = $this->params['user_id'];
        $this->pid = wpl_property::create_property_default($this->property_uid);

        $data = array();
        foreach ($this->params as $key => $value)
        {
            if(stripos($key, 'field_') === 0)
            {
                $field = substr($key, 6);
                $data[$field] = $value;
            }
            elseif (stripos($key, 'image_') === 0)
            {
                $name = substr($key, 6);
                $image = base64_decode($value);
                $this->save_image($name, $image, $name);
            }
        }

        $this->update_property($data);
        $this->built['result'] = array('success' => true, 'message' => '');
        return $this->built;
    }

    /**
     * Data validation
     * @return boolean
     */
    public function validate()
    {
        return true;
    }

    /**
     * Update property
     * @author Steve A. <steve@realtyna.com>
     * @param  array   $data Input Data
     * @return null
     */
    private function update_property($data)
    {
        if(!$this->pid or !$data) return;

        $q = '';
        foreach($data as $column => $value) $q .= "`$column` = '".wpl_db::escape($value)."',";
        $q = trim($q, ',');

        wpl_db::q("UPDATE `#__wpl_properties` SET $q WHERE `id` = '{$this->pid}'", 'update');
     
        wpl_locations::update_LatLng('', $this->pid);
        
        wpl_property::finalize($this->pid, 'edit', $this->property_uid);
    }

    /**
     * Save property image
     * @author Steve A. <steve@realtyna.com>
     * @param  string $name  Image Name
     * @param  string $image Image Data
     * @param  string $index Image Index
     * @return null
     */
    private function save_image($name, $image, $index)
    {
        $kind = 0; // We support properties only, for now
        $name .= ".jpg"; // All images are stored in JPEG format
        $item_type = 'gallery'; // For efficiency
        $item_cat = 'image'; // For efficiency

        $blog_id = wpl_property::get_blog_id($this->pid);
        $path = wpl_global::get_upload_base_path($blog_id).$this->pid.DS.$name;

        wpl_file::write($path, $image);
        $item = array('parent_id' => $this->pid, 'parent_kind' => $kind, 'item_type' => $item_type, 'item_cat' => $item_cat, 'item_name' => $name, 'creation_date' => date("Y-m-d H:i:s"), 'index' => $index);
        wpl_items::save($item);
    }
}