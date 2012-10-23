<?php

namespace Auth\Model;

abstract class User extends \Nerd\Model
{
    protected static $table = 'nerd_users';

    public $meta;

    public function __construct()
    {
        $meta = get_called_class().'\\Meta';

		if (isset($this->id)) {
	        $this->meta = $meta::findOne('SELECT * FROM nerd_user_metadata WHERE user_id = ?', $this->_values['id']);
		} else {
			$this->meta = new $meta();
		}
    }

    /**
     * {@inheritdoc}
     */
    public function __get($property)
    {
        if (isset($this->_values[$property])) {
            return $this->_values[$property];
        } else {
            if ($this->meta) {
                return $this->meta->__get($property);
            }
        }
    }
}
