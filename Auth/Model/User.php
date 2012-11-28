<?php

namespace Auth\Model;

abstract class User extends \Nerd\Model
{
    protected static $columns;
    protected static $constraints;
    protected static $columnNames;
    protected static $primary;

    public static function validate($identifier, $secret)
    {
        $field = strpos($identifier, '@') !== false ? 'email' : 'username';
        $sql   = "SELECT * FROM `".static::$table."` WHERE `$field` = ? AND `password` = ?";

        return static::findOne($sql, $identifier, $secret);
    }

    public $meta;

    public function __construct()
    {
        $sql  = 'SELECT * FROM nerd_user_metadata WHERE user_id = ?';
        $meta = get_called_class().'\\Meta';

        if (isset($this->id)) {
            $this->meta = $meta::findOne($sql, $this->_values['id']);
        }

        if (!$this->meta) {
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
